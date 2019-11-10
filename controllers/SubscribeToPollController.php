<?php

namespace app\controllers;

use Yii;
use app\models\SubscribeToPoll;
use app\models\SubscribeToPollSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * SubscribeToPollController implements the CRUD actions for SubscribeToPoll model.
 */
class SubscribeToPollController extends Controller
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
     * Lists all SubscribeToPoll models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new SubscribeToPollSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single SubscribeToPoll model.
     * @param integer $id
     * @return mixed
     */
    // public function actionView($id)
    // {   
    //     $request = Yii::$app->request;
    //     if($request->isAjax){
    //         Yii::$app->response->format = Response::FORMAT_JSON;
    //         return [
    //                 'title'=> "SubscribeToPoll #".$id,
    //                 'content'=>$this->renderAjax('view', [
    //                     'model' => $this->findModel($id),
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                         Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
    //             ];    
    //     }else{
    //         return $this->render('view', [
    //             'model' => $this->findModel($id),
    //         ]);
    //     }
    // }

    /**
     * Creates a new SubscribeToPoll model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $request = Yii::$app->request;
    //     $model = new SubscribeToPoll();  

    //     if($request->isAjax){
    //         /*
    //         *   Process for ajax request
    //         */
    //         Yii::$app->response->format = Response::FORMAT_JSON;
    //         if($request->isGet){
    //             return [
    //                 'title'=> "Create new SubscribeToPoll",
    //                 'content'=>$this->renderAjax('create', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                             Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
    //             ];         
    //         }else if($model->load($request->post()) && $model->save()){
    //             return [
    //                 'forceReload'=>'#crud-datatable-pjax',
    //                 'title'=> "Create new SubscribeToPoll",
    //                 'content'=>'<span class="text-success">Create SubscribeToPoll success</span>',
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                         Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
    //             ];         
    //         }else{           
    //             return [
    //                 'title'=> "Create new SubscribeToPoll",
    //                 'content'=>$this->renderAjax('create', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                             Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
    //             ];         
    //         }
    //     }else{
    //         /*
    //         *   Process for non-ajax request
    //         */
    //         if ($model->load($request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         } else {
    //             return $this->render('create', [
    //                 'model' => $model,
    //             ]);
    //         }
    //     }
       
    // }

    // *
    //  * Updates an existing SubscribeToPoll model.
    //  * For ajax request will return json object
    //  * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
     
    // public function actionUpdate($id)
    // {
    //     $request = Yii::$app->request;
    //     $model = $this->findModel($id);       

    //     if($request->isAjax){
    //         /*
    //         *   Process for ajax request
    //         */
    //         Yii::$app->response->format = Response::FORMAT_JSON;
    //         if($request->isGet){
    //             return [
    //                 'title'=> "Update SubscribeToPoll #".$id,
    //                 'content'=>$this->renderAjax('update', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                             Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
    //             ];         
    //         }else if($model->load($request->post()) && $model->save()){
    //             return [
    //                 'forceReload'=>'#crud-datatable-pjax',
    //                 'title'=> "SubscribeToPoll #".$id,
    //                 'content'=>$this->renderAjax('view', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                         Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
    //             ];    
    //         }else{
    //              return [
    //                 'title'=> "Update SubscribeToPoll #".$id,
    //                 'content'=>$this->renderAjax('update', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                             Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
    //             ];        
    //         }
    //     }else{
    //         /*
    //         *   Process for non-ajax request
    //         */
    //         if ($model->load($request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         } else {
    //             return $this->render('update', [
    //                 'model' => $model,
    //             ]);
    //         }
    //     }
    // }

    /**
     * Delete an existing SubscribeToPoll model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crudsub-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing SubscribeToPoll model.
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
            return ['forceClose'=>true,'forceReload'=>'#crudsub-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the SubscribeToPoll model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SubscribeToPoll the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SubscribeToPoll::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
