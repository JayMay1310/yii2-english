<?php

namespace backend\controllers;

use backend\models\UploadForm;

use yii;
use yii\web\UploadedFile;
use yii\db\Expression;
use common\models\Category;
use common\models\Word;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Json;

class WordController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDelete($id)
    {
        $model = Word::findOne((int)$id);
        $model->delete();
        return $this->redirect(['category/index']);
    }

    public function actionUpdate($id)
    {
        $categories = Category::find()->all();
        $model = Word::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }
    
    public function actionCreate($id = null)
    {
        $request = Yii::$app->request;

        $get = $request->get();

        $categories = Category::find()->all();
        $model = new Word();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }

        return $this->render('create');
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
           
            if ($model->load(Yii::$app->request->post()) &&  $model->validate()) {
                $category = Category::find()->where(['id' => $model->category])->one();
                $list_word = explode(PHP_EOL, $model->word);
                foreach ($list_word as $value)
                {
                    $translate_arr = explode('—', $value);
                    $word = trim($translate_arr[0]);
                    $translate = trim($translate_arr[1]);
                    $isWord = Word::find()->where(['word'=>$word])->one(); 
                    if (empty($isWord))
                    {
                        $model = new Word();
                        $model->word = $word;
                        $model->translation = $translate;
                        $model->category_id = $category->id;  
                        $model->save(false);
                    }      
                }
            }
        }

        return $this->render('upload', ['model' => $model,]);
    }

    public function actionLearn()
    {
        $action=Yii::$app->request->post('action');
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        $model_redirect = Word::findOne((int)$selection[0]);
        $category_redirect = $model_redirect->category_id;

        foreach($selection as $id){
            $model = Word::findOne((int)$id);//make a typecasting
            $category = Category::findOne((int)$model->category_id);
            $category->last_update = new Expression('NOW()');
            $category->save(false); 

            $model->last_update = new Expression('NOW()');
            $model->count = $model->count + 1;
            $model->send_telegram = false;
            $model->save(false); 
       }

       return $this->redirect(['category/view', 'id' => $category_redirect]);     
    }

    public function actionLearnrusty()
    {
        $action=Yii::$app->request->post('action');
        $selection=(array)Yii::$app->request->post('selection');//typecasting

        foreach($selection as $id){
            $model = Word::findOne((int)$id);//make a typecasting
            //$category = Category::findOne((int)$model->category_id);
            //if ($category != null)
            //{
            //    $category->last_update = new Expression('NOW()');
            //    $category->save(false); 
            //}
            
            $model->last_update = new Expression('NOW()');
            $model->save(false); 
       }

       return $this->redirect(['category/rusty']);     
    }

    public function actionStatistic()
    {
        //last_update
        $statistic = Word::find()->andWhere(['>', 'last_update', new Expression('LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH') ])
        ->andWhere(['<', 'last_update', new Expression('DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)') ])->asArray()->all();

        $list_data = array();
        foreach ($statistic as $value)
        {
            $date = date('Y-m-d', strtotime($value['last_update']));
            $list_data[] = $date;
        }

        $data_raw = array_count_values($list_data);
        $result = [];
        foreach ($data_raw as $key => $value)
        {
            $result[] = ['data' => $key, 'count' => $value];
        }

        $provider = new ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 30,
            ],
            'sort' => [
                'attributes' => ['data', ],
            ],
        ]);
        
        return $this->render('statistic', ['dataProvider' => $provider,]);
    }
    public function actionSport()
    {
        $time_from = strtotime('-10 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $query = Word::find()->orderBy(['rand()' => SORT_DESC, new \yii\db\Expression('last_update IS NULL ASC')])
                                                ->where(['is', 'last_update', new \yii\db\Expression('null')])
                                                ->orWhere(['<=', 'last_update', $delta_from])
                                                ->limit(5)
                                                ->asArray()->all();

        return $this->render('sport', [
            'query' => $query,           
        ]);
    }

    public function actionLearnsport()
    {
        $speed_array=Yii::$app->request->post('speed');
        $array_word = explode(",", $speed_array);
        foreach($array_word as $id){
            $model = Word::findOne((int)$id);//make a typecasting
            if ($model != null)
            {
                $model->last_update = new Expression('NOW()');
                $model->save(false); 
            }
       }
       return $this->redirect(['word/sport',]);       
    }

    public function actionTelegramLearn()
    {
        $telegram_array=Yii::$app->request->post('telegram');
        $array_word = explode(",", $telegram_array);
        foreach($array_word as $id)
        {
            $model = Word::findOne((int)$id);//make a typecasting
            if ($model != null)
            {
                $model->last_update = new Expression('NOW()');
                $model->send_telegram = false;
                $model->save(false); 
            }
       }
       
       return $this->redirect(['word/telegram',]);  
    }

    public function actionTelegram()
    {
        $query = Word::find()->where(['=', 'send_telegram', 1])->limit(30)->asArray()->all();
        return $this->render('telegram', [
            'query' => $query,           
        ]);
    }

    public function actionSpeedlearn()
    {
        $time_from = strtotime('-10 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $query = Word::find()->orderBy(['rand()' => SORT_DESC, new \yii\db\Expression('last_update IS NULL ASC')])
                                                ->where(['is', 'last_update', new \yii\db\Expression('null')])
                                                ->orWhere(['<=', 'last_update', $delta_from])
                                                ->limit(30)
                                                ->asArray()->all();

        return $this->render('speedlearn', [
            'query' => $query,           
        ]);
    }

    public function actionLearnspeed()
    {
        $speed_array=Yii::$app->request->post('speed');
        $array_word = explode(",", $speed_array);
        foreach($array_word as $id){
            $model = Word::findOne((int)$id);//make a typecasting
            if ($model != null)
            {
                /*
                $category = Category::findOne((int)$model->category_id);
                if ($category != null)
                {
                    $category->last_update = new Expression('NOW()');
                    $category->save(false); 
                }
                */

                $model->last_update = new Expression('NOW()');
                $model->save(false); 
            }

       }

       return $this->redirect(['word/speedlearn',]);       
    }
    /** 
    * Your controller action to fetch the list
    */
    public function actionWordList($q = null) {
        $query = new Query();
    
        $query->select(['word', 'translation'])
            ->from('word')//Таблица тоже называется word
            ->where('word LIKE "%' . $q .'%"')
            ->orderBy('word');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['word'] . ' = ' . $d['translation']];
        }
        echo Json::encode($out);
    }
 
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
        {
            return false;
        }

        if (!Yii::$app->user->isGuest)
        {
            return true;
        }
        else
        {
            Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
            //для перестраховки вернем false
            return false;
        }
    }
}
