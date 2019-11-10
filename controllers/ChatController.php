<?php

namespace app\controllers;

use Yii;
use app\models\Chat;
use app\models\ChatSearch; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\web\HttpException;
use app\models\Rules;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
 
/**
 * ChatController implements the CRUD actions for Chat model.
 */
class ChatController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }
   
    public function actionIndex()
    {    
        $searchModel1 = new ChatSearch(['type'=>1]);
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
     
        return $this->render('index', [
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
        ]);
    }

    public function actionAdmin()
    {    
        $searchModel1 = new ChatSearch(['type' => 3]);
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
     
        return $this->render('index', [
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
        ]);
    }

    public function actionSends($chat_id)
    {    
        $request = Yii::$app->request;
        if($request->post()) {
            $array = explode('_', $chat_id);
            $chat = new Chat();
            $chat->chat_id = $chat_id;
            $chat->type = 3;
            $chat->from = Yii::$app->user->identity->id;
            $chat->to = $array[2];
            $chat->text = $request->post()['msg'];
            $chat->save();
        }
        $query = Chat::find()->where(['chat_id' => $chat_id, 'deleted' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),
        ]);
        return $this->render('sends', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionClose($id)  
    {
        $request = Yii::$app->request;
        $model= Chat::findOne($id);
        // $model= Chat::find()->where(['id'=>2])->one();
        $model->deleted = 1; 
        $model->save();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'forceClose'=>true,
            'forceReload'=>'#chat-pjax'
        ];    
    }
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->is_read = 1;
        $model->save();
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> $model->title,
                    'forceReload'=>'#inbox-pjax',
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-info pull-right','data-dismiss'=>"modal"])
                    
                            
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    public function actionDownloadFile($id)
    {
        $model = Chat::findOne($id);
        return \Yii::$app->response->sendFile('uploads/chat/'.$model->file);
    }
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#chat-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model= Chat::findOne($id);    

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Изменить",
                    'size'=> 'normal',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#chat-pjax',
                    'title'=> "Изменить ",
                    'size'=> 'normal',
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];    
            }else{
                 return [
                    'title'=> "Изменить",
                    'size'=> 'normal',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['send', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    public function actionCheckDelete($id)
    {
        $request = Yii::$app->request;
        $inbox = Chat::findOne($id);
        $inbox->is_read = 1;
        $inbox->deleted = 1;
        $inbox->save();
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#inbox-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

     /**
     * Delete multiple existing Chat model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Chat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
