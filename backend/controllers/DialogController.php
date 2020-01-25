<?php

namespace backend\controllers;

use yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use common\models\Dialogname;
use common\models\Dialogdetail;

class DialogController extends Controller
{
    public function actionIndex()
    {
        $query = Dialogname::find()->orderBy('parent_id ASC, id ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreateDialog($id = null)
    {
        $model = new Dialogdetail();
        $model->dialog_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreate($id = null)
    {
        $model = new Dialogname();
        $model->parent_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create_dialog_name', [
                'model' => $model,

            ]);
        }
    }
    
    public function actionLearn()
    {
        $action=Yii::$app->request->post('action');
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        
        if ($action === 'Delete')
        {
            foreach($selection as $id)
            {
                $model = Dialogdetail::findOne((int)$id);
                $model->delete();
            }
        }

        if ($action === 'Learn')
        {
            foreach($selection as $id){
                $model = Dialogdetail::findOne((int)$id);//make a typecasting
                $category = Dialogname::findOne((int)$model->dialog_id);
                $category->last_update = new Expression('NOW()');
                $category->save(false); 
    
                $model->last_update = new Expression('NOW()');
                $model->count = $model->count + 1;
                $model->save(false); 
           }
        }

       return $this->redirect(['dialog/index',]);
    }

    public function actionView($id)
    {
        $category = $this->findModel($id);
        $query = $category->getDialog($id);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'step' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $provider,           
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Dialogname::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }  
}