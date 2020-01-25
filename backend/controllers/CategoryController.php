<?php
namespace backend\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use common\models\Category;
use common\models\Word;
use backend\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\db\Expression;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $category = $this->findModel($id);
        $query = $category->getWords($id);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'last_update' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $provider,           
        ]);
    }

    public function actionSpeedCategoryLearn($id)
    {

        $time_from = strtotime('-10 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $category = $this->findModel($id);
        $query = $category->getWords($id);
        $words = $query->orderBy(['rand()' => SORT_DESC, new \yii\db\Expression('last_update IS NULL ASC')])
                                                ->where(['is', 'last_update', new \yii\db\Expression('null')])
                                                ->orWhere(['<=', 'last_update', $delta_from])
                                                ->limit(30)
                                                ->asArray()->all();

        return $this->render('speedlearn', [
            'query' => $words,           
        ]);
    }

    /**
     * Выводит слова, которые не повторялись уже 
     * больше 20 дней
     */
    public function actionRusty()
    {
        $time = strtotime('-20 day', time());
        $delta = date('Y-m-d H:i:s', $time);
    
        $query = Word::find()->where(['<=', 'last_update', $delta]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'last_update' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('rusty', [
            'dataProvider' => $provider,           
        ]);
    }

    public function actionShortperiod()
    {
        $time_from = strtotime('-1 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $time_to = strtotime('-4 day', time());
        $delta_to = date('Y-m-d H:i:s', $time_to);

        $query = Word::find()->where(['<=', 'last_update', $delta_from])->andFilterWhere(['>=', 'last_update', $delta_to]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'last_update' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('shortperiod', [
            'dataProvider' => $provider,           
        ]);        
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $id id of the parent category
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $categories = Category::find()->all();
        $model = new Category();
        $model->parent_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }
    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $categories = Category::find()->all();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }
    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
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

       return $this->redirect(['index',]);       
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    
}