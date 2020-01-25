<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property array $id_word
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_word'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['link'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'link' => 'Link',
            'id_word' => 'Id Word',
        ];
    }
}
