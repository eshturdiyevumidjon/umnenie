<?php

namespace app\controllers;

use Yii;
use app\models\BlockUser;
use app\models\BlockUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * BlockUserController implements the CRUD actions for BlockUser model.
 */
class BlockUserController extends Controller
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
     * Lists all BlockUser models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new BlockUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single BlockUser model.
     * @param integer $id
     * @return mixed
     */
    // public function actionView($id)
    // {   
    //     $request = Yii::$app->request;
    //     if($request->isAjax){
    //         Yii::$app->response->format = Response::FORMAT_JSON;
    //         return [
    //                 'title'=> "BlockUser #".$id,
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

    // /**
    //  * Creates a new BlockUser model.
    //  * For ajax request will return json object
    //  * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
    //  * @return mixed
    //  */
    // public function actionCreate()
    // {
    //     $request = Yii::$app->request;
    //     $model = new BlockUser();  

    //     if($request->isAjax){
    //         /*
    //         *   Process for ajax request
    //         */
    //         Yii::$app->response->format = Response::FORMAT_JSON;
    //         if($request->isGet){
    //             return [
    //                 'title'=> "Create new BlockUser",
    //                 'content'=>$this->renderAjax('create', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                             Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
    //             ];         
    //         }else if($model->load($request->post()) && $model->save()){
    //             return [
    //                 'forceReload'=>'#crud-datatable-pjax',
    //                 'title'=> "Create new BlockUser",
    //                 'content'=>'<span class="text-success">Create BlockUser success</span>',
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                         Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
    //             ];         
    //         }else{           
    //             return [
    //                 'title'=> "Create new BlockUser",
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

    // /**
    //  * Updates an existing BlockUser model.
    //  * For ajax request will return json object
    //  * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
    //  */
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
    //                 'title'=> "Update BlockUser #".$id,
    //                 'content'=>$this->renderAjax('update', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                             Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
    //             ];         
    //         }else if($model->load($request->post()) && $model->save()){
    //             return [
    //                 'forceReload'=>'#crud-datatable-pjax',
    //                 'title'=> "BlockUser #".$id,
    //                 'content'=>$this->renderAjax('view', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                         Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
    //             ];    
    //         }else{
    //              return [
    //                 'title'=> "Update BlockUser #".$id,
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
     * Delete an existing BlockUser model.
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
            return ['forceClose'=>true,'forceReload'=>'#crudblock-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing BlockUser model.
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
            return ['forceClose'=>true,'forceReload'=>'#crudblock-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the BlockUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlockUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlockUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
