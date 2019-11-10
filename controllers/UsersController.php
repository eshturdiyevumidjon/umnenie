<?php

namespace app\controllers;

use Yii;
use app\models\Users;  
use app\models\UsersSearch; 
use yii\web\Controller; 
use yii\web\NotFoundHttpException; 
use yii\filters\VerbFilter;
use \yii\web\Response;   
use yii\helpers\Html;
use yii\web\UploadedFile; 
use app\models\Specialization; 
use app\models\SubscribeToUserSearch; 
use app\models\BlockUserSearch;
use app\models\ElectedSearch;
/**   
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDel()
    {
        $model = Users::findOne(47);
        $model->delete();
    }


    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $subsearchModel = new SubscribeToUserSearch(['user_to' => $id]);
        $subdataProvider = $subsearchModel->search(Yii::$app->request->queryParams);
        
        $subsearchModel2 = new SubscribeToUserSearch(['user_id'=>$id]);
        $subdataProvider2 = $subsearchModel2->search(Yii::$app->request->queryParams);

        $blocksearchModel = new BlockUserSearch(['user_from'=>$id]);
        $blockdataProvider = $blocksearchModel->search(Yii::$app->request->queryParams);

        $selectedsearchModel = new ElectedSearch(['user_id'=>$id]);
        $selecteddataProvider = $selectedsearchModel->search(Yii::$app->request->queryParams);

        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Пользователь",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Изменить',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),

                'subsearchModel' => $subsearchModel,
                'subdataProvider' => $subdataProvider,

                'subsearchModel2' => $subsearchModel2,
                'subdataProvider2' => $subdataProvider2,
                
                'blocksearchModel' => $blocksearchModel,
                'blockdataProvider' => $blockdataProvider,

                'selectedsearchModel' => $selectedsearchModel,
                'selecteddataProvider' => $selecteddataProvider,
            ]);
        }
    }

    /** 
     * Creates a new Users model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionChange($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                
                return [
                    'forceClose' => true,
                    'forceReload'=>'#profile-pjax',
                ];    
            }else{
                 return [
                    'title'=> "Изменить",
                    'size' => "large",
                    'content'=>$this->renderAjax('change', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-primary pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-info','type'=>"submit"])
                ];        
            }
        }
        else{ 
            echo "ddd";
        }
    }

    public function actionProfile()
    {
        $request = Yii::$app->request;
        return $this->render('profile', [
        ]);        
    }  
    
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Users();  
        $post = $request->post(); 
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Создать нового пользователя",
                    'size'=>'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->validate() && $model->save() ){

                $result1 = ''; 
                $i = 1; 
                foreach ($post['Users']['category_id'] as $value) {
                    if($i == 1) $result1 = $value;
                    else $result1 .= ',' . $value;
                    $i++;
                }

                $result = ''; 
                $i = 1; 
                foreach ($post['Users']['specialization_id'] as $value) {
                    if($i == 1) $result = $value;
                    else $result .= ',' . $value;
                    $i++;
                }

                $model->foto = UploadedFile::getInstance($model,'foto');
                if(!empty($model->foto))
                {
                    $model->foto->saveAs('uploads/user/foto/' . $model->id.'.'.$model->foto->extension);
                    Yii::$app->db->createCommand()->update('users', ['foto' => $model->id.'.'.$model->foto->extension], [ 'id' => $model->id ])->execute();
                }
                $model->logo = UploadedFile::getInstance($model,'logo');
                if(!empty($model->logo))
                {
                    $model->logo->saveAs('uploads/user/logo/' . $model->id.'.'.$model->logo->extension);
                    Yii::$app->db->createCommand()->update('users', ['logo' => $model->id.'.'.$model->logo->extension], [ 'id' => $model->id ])->execute();
                }
                $model->category_id = $result1;
                $model->specialization_id = $result;
                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'size'=>'large',
                    'title'=> "Создать нового пользователя",
                    'content'=>'<span class="text-success">Успешно завершено</span>',
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Создать ещё',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Создать нового пользователя",
                    'size'=>'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
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
     * Updates an existing Users model.
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
        $oldresult=$model->specialization_id;
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Пользователь",
                    'size'=>'large',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post())  && $model->validate() && $model->save()){

                $result1 = $oldresult1; 
                $i = 1; 
                foreach ($post['Users']['category_id'] as $value) {
                    if($i == 1) $result1 = $value;
                    else $result1 .= ',' . $value;
                    $i++;
                }

                $result = $oldresult; 
                $i = 1; 
                foreach ($post['Users']['specialization_id'] as $value) {
                    if($i == 1) $result = $value;
                    else $result .= ',' . $value;
                    $i++;
                }

                $model->foto = UploadedFile::getInstance($model,'foto');
                if(!empty($model->foto))
                {
                    $model->foto->saveAs('uploads/user/foto/' . $model->id.'.'.$model->foto->extension);
                    Yii::$app->db->createCommand()->update('users', ['foto' => $model->id.'.'.$model->foto->extension], [ 'id' => $model->id ])->execute();
                }else{
                     $model->foto =$old->foto;
                }
                $model->logo = UploadedFile::getInstance($model,'logo');
                if(!empty($model->logo))
                {
                    $model->logo->saveAs('uploads/user/logo/' . $model->id.'.'.$model->logo->extension);
                    Yii::$app->db->createCommand()->update('users', ['logo' => $model->id.'.'.$model->logo->extension], [ 'id' => $model->id ])->execute();
                }else{
                     $model->logo =$old->logo;
                }
                $model->category_id = $result1;
                $model->specialization_id = $result;
                $model->save();
                return $this->redirect(['view','id'=>$model->id]);  
            }else{
                 return [
                    'title'=> "Изменить пользователя",
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
                $result1 = $oldresult1; 
                $i = 1; 
                foreach ($post['Users']['category_id'] as $value) {
                    if($i == 1) $result1 = $value;
                    else $result1 .= ',' . $value;
                    $i++;
                }

                $result = $oldresult; 
                $i = 1; 
                foreach ($post['Users']['specialization_id'] as $value) {
                    if($i == 1) $result = $value;
                    else $result .= ',' . $value;
                    $i++;
                }
                $model->category_id = $result1;
                $model->specialization_id = $result;
                $model->save();                                                     
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    public function actionAvatar()
    {
        if(Yii::$app->user->identity->type == 3){
        $request = Yii::$app->request;
        $id = Yii::$app->user->identity->id;
        $model = Users::findOne(Yii::$app->user->identity->id);  

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->validate()){

                $model->other_foto = UploadedFile::getInstance($model, 'other_foto');
                if(!empty($model->other_foto)){
                    $model->other_foto->saveAs('uploads/user/foto/'.$id.'.'.$model->other_foto->extension);
                    Yii::$app->db->createCommand()->update('users', ['foto' => $id.'.'.$model->other_foto->extension], [ 'id' => $id ])->execute();
                }

                return [
                    'forceReload'=>'#profile-pjax',
                    'size' => 'normal',
                    'title'=> "Аватар",
                    'forceClose' => true,     
                ];         
            }else{           
                return [
                    'title'=> "Аватар",
                    'size' => 'small',
                    'content'=>$this->renderAjax('avatar', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-primary pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-info','type'=>"submit"])
        
                ];         
            }
        }
        }else
        {
            return $this->redirect('/admin/default/error');
        }
       
    }
    /**
     * Delete an existing Users model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {   
        $request = Yii::$app->request;
        $model = Users::findOne($id);

        $imageName = $model->foto;
        $imageName2 = $model->logo;
        Yii::$app->db->createCommand()->delete('users', ['id' => $id])->execute();
        unlink(getcwd().'/uploads/user/foto/'.$imageName);
        unlink(getcwd().'/uploads/user/logo/'.$imageName2);

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
     * Delete multiple existing Users model.
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
            $model = Users::findOne($pk);
            $imageName = $model->foto;
            $imageName2 = $model->logo;
            Yii::$app->db->createCommand()->delete('users', ['id' => $id])->execute();
            unlink(getcwd().'/uploads/user/foto/'.$imageName);
            unlink(getcwd().'/uploads/user/logo/'.$imageName2);
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
