<?php

namespace app\controllers;

use Yii;
use app\models\Polls;
use app\models\PollsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response; 
use yii\helpers\Html;
use yii\web\UploadedFile; 
use app\models\PollItems;  
use app\models\Chat;
use app\models\Answers;
use yii\data\ActiveDataProvider;  
use app\models\SubscribeToPollSearch;
use app\models\LikeSearch;
/**
 * PollsController implements the CRUD actions for Polls model.
 */
class PollsController extends Controller
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

    /**
     * Lists all Polls models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new PollsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $subsearchModel = new SubscribeToPollSearch();
        $subdataProvider = $subsearchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

            'subsearchModel' => $subsearchModel,
            'subdataProvider' => $subdataProvider,
        ]);
    }

    public function actionStatistics()
    {    
        return $this->render('statistics', []);
    }
    /**
     * Displays a single Polls model.
     * @param integer $id 
     * @return mixed 
     */
    public function actionClose($id)
    {
        $request = Yii::$app->request;
        $model= Chat::findOne($id);
        if($model->deleted == 0){
            $model->deleted = 1; 
        }
        elseif($model->deleted == 1){
            $model->deleted = 0; 
        }
        $model->save();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#inbox-pjax'];
        }else{
            return $this->redirect(['index']);
        }
    }
    public function actionView($id)
    {   
        $subsearchModel = new SubscribeToPollSearch(['poll_id'=>$id]);
        $subdataProvider = $subsearchModel->search(Yii::$app->request->queryParams);
        
        $likesearchModel = new LikeSearch(['poll_id'=>$id]);
        $likedataProvider = $likesearchModel->search(Yii::$app->request->queryParams);
        //======================== Chat ==================================================
        $query = Chat::find()->where(['type'=>2,'chat_id' => '#poll-'.$id,'deleted' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),
        ]);
        //================================================================================
        $pollitems = PollItems::find()->where(['poll_id'=>$id])->all();
        $request = Yii::$app->request;
        $model = $this->findModel($id);  
        $type=$model->type;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Опросы",
                    'size'=>'normal',
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Изменить',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
                'pollitems' => $pollitems,
                'dataProvider' => $dataProvider,
                'type' => $type,
                'id' => $id,
                'answersall' => $answersall,
                'subsearchModel' => $subsearchModel,
                'subdataProvider' => $subdataProvider,
                'likesearchModel' => $likesearchModel,
                'likedataProvider' => $likedataProvider,
            ]);
        }
    }

    /**
     * Creates a new Polls model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Polls();  
        $post = $request->post(); 
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Опросы",
                    'size'=>'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){

                $result1 = ''; 
                $i = 1; 
                foreach ($post['Polls']['category_id'] as $value) {
                    if($i == 1) $result1 = $value;
                    else $result1 .= ',' . $value;
                    $i++;
                }
                $model->image = UploadedFile::getInstance($model,'image');
                if(!empty($model->image))
                {
                    $model->image->saveAs('uploads/polls/' . $model->id.'.'.$model->image->extension);
                    Yii::$app->db->createCommand()->update('polls', ['image' => $model->id.'.'.$model->image->extension], [ 'id' => $model->id ])->execute();
                }
                $model->category_id = $result1;
                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Опросы",
                    'size'=>'large',
                    'content'=>'<span class="text-success">Успешно завершено</span>',
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Создать ещё',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Опросы",
                    'size'=>'large',
                    'content'=>$this->renderAjax('create', [
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
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Polls model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
        $old=$this->findModel($id); 
        $post = $request->post(); 
        $oldresult1=$model->category_id;
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Опросы",
                    'size'=>'large',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                $result1 = $oldresult1; 
                $i = 1; 
                foreach ($post['Polls']['category_id'] as $value) {
                    if($i == 1) $result1 = $value;
                    else $result1 .= ',' . $value;
                    $i++;
                }
                $model->image = UploadedFile::getInstance($model,'image');
                if(!empty($model->image))
                {
                    $model->image->saveAs('uploads/polls/' . $model->id.'.'.$model->image->extension);
                    Yii::$app->db->createCommand()->update('polls', ['image' => $model->id.'.'.$model->image->extension], [ 'id' => $model->id ])->execute();
                }else{
                     $model->image =$old->image;
                }
                $model->category_id = $result1;
                $model->save();
                return $this->redirect(['view','id'=>$id]); 
            }else{
                 return [
                    'title'=> "Опросы",
                    'size'=>'large',
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
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Polls model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = Polls::findOne($id);
        $imageName = $model->image;
        Yii::$app->db->createCommand()->delete('polls', ['id' => $id])->execute();
        unlink(getcwd().'/uploads/polls/'.$imageName);

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
     * Delete multiple existing Polls model.
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
            $model = Polls::findOne($pk);
            $imageName = $model->image;
            Yii::$app->db->createCommand()->delete('polls', ['id' => $id])->execute();
            unlink(getcwd().'/uploads/polls/'.$imageName);
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
     * Finds the Polls model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Polls the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Polls::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
