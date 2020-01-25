<?php
 
namespace backend\controllers;
 
use yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;

use yii\web\Response;
use yii\filters\AccessControl;

use common\models\Word;
use common\models\Link;

use yii\db\Expression;

 
class WordrestController extends ActiveController
{
    public $modelClass = 'common\models\Word';
 
    public function init()
    {
        parent::init();
        // отключаем механизм сессий в api
        //Yii::$app->user->enableSession = false;
    }
    /*
    public function behaviors()
    {
        $behaviors = parent::behaviors();
 
        $behaviors['authenticator'] = [            
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
            'except' => ['options','login'],
        ];
        
        return $behaviors;
    }
   */

  /**
   * Example url: http://localhost/english/backend/web/api/wordrests/search?word=hang%20around
  */
  public function actionSearch()
  {
      if (!empty($_GET)) {
          $model = new $this->modelClass;
          foreach ($_GET as $key => $value) {
              if (!$model->hasAttribute($key)) {
                  throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
              }
          }
          try {
              $provider = new ActiveDataProvider([
                  'query' => $model->find()->where($_GET),
                  'pagination' => false
              ]);
          } catch (Exception $ex) {
              throw new \yii\web\HttpException(500, 'Internal server error');
          }
  
          if ($provider->getCount() <= 0) {
              throw new \yii\web\HttpException(404, 'No entries found with this query string');
          } else {
              return $provider;
          }
      } else {
          throw new \yii\web\HttpException(400, 'There are no query string');
      }
   }

   /**
    * Url example: http://localhost/english/backend/web/api/wordrests/learn JSON: [{"id":"1"}]
    */
   public function actionLearn()
   {
        $data_json = Yii::$app->request->getRawBody();
        $data_array = json_decode($data_json, true);
        $id = $data_array[0]['id'];

        $model = Word::findOne((int)$id);//make a typecasting
        $model->last_update = new Expression('NOW()');
        //$model->count = $model->count + 1;
        //$model->save(false);
        if ($model->save(false)) {   
            //$this->setHeader(200);
            echo json_encode(array('status'=>1,));          
        } 
        else
        {
            $this->setHeader(400);
            echo json_encode(array('status'=>0,'error_code'=>400,'errors'=>$model->errors),JSON_PRETTY_PRINT);
        }  
   }

   public function actionLink()
   {
        $data_json = Yii::$app->request->getRawBody();
        $data_array = json_decode($data_json, true);
        $link = $data_array['link'];
        $json = json_encode($data_array['id_word']);

        $model = new Link();
        $model->link = $link;
        $model->id_word = $json;

        if ($model->save(false)) {   
            //$this->setHeader(200);
            echo json_encode(array('status'=>1,));          
        } 
        else
        {
            $this->setHeader(400);
            echo json_encode(array('status'=>0,'error_code'=>400,'errors'=>$model->errors), JSON_PRETTY_PRINT);
        } 

   }

    public function actionAdd()
    {

        return 0;
    } 
}