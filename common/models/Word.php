<?php

namespace common\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "word".
 *
 * @property int $id
 * @property string $word
 * @property string $translation
 * @property int $category_id
 * @property string $last_update
 * @property int $count
 *
 * @property Category $category
 */
class Word extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'word';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'count'], 'integer'],
            [['last_update'], 'safe'],
            [['word', 'translation'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            ['send_telegram', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word' => 'Word',
            'translation' => 'Translation',
            'category_id' => 'Category ID',
            'last_update' => 'Last Update',
            'count' => 'Count',
            'send_telegram' => 'Send Telegram',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function countRequestPage()
    {
        //>20
        $time_rusty = strtotime('-20 day', time());
        $delta_rysty = date('Y-m-d H:i:s', $time_rusty);    
        Yii::$app->params['count20day'] = Word::find()->where(['<=', 'last_update', $delta_rysty])->count();

        //>1 дней < 4
        $time_from = strtotime('-1 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $time_to = strtotime('-4 day', time());
        $delta_to = date('Y-m-d H:i:s', $time_to);
        Yii::$app->params['onedayfor'] = Word::find()->where(['<=', 'last_update', $delta_from])->andFilterWhere(['>=', 'last_update', $delta_to])->count();

        //speedlearn 
        $time_from_speed = strtotime('-10 day', time());
        $delta_from_speed = date('Y-m-d H:i:s', $time_from_speed);

        Yii::$app->params['speedlearn'] = Word::find()->orderBy(['rand()' => SORT_DESC, new \yii\db\Expression('last_update IS NULL ASC')])
                                                ->where(['is', 'last_update', new \yii\db\Expression('null')])
                                                ->orWhere(['<=', 'last_update', $delta_from_speed])->count();

        Yii::$app->params['telegram'] = Word::find()->where(['=', 'send_telegram', true])->count();                                        
     
        return true;
    }
}
