<?php

use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset; 
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use app\models\Users;

CrudAsset::register($this);
$model = Users::findOne(Yii::$app->user->identity->id);

// if (!file_exists('avatars/'.$model->foto) || $model->foto == '') {
//     $path = 'http://' . $_SERVER['SERVER_NAME'].'/extra/images/users/avatar.jpg';
// } else {
//     $path = 'http://' . $_SERVER['SERVER_NAME'].'/avatars/'.$model->foto;
// }
$this->title = 'Профиль';
?>

<?php Pjax::begin(['enablePushState' => false, 'id' => 'profile-pjax']) ?>
<div class="row">
    <div class="">
        <!-- CONTACT ITEM -->
        <div class="profile-container content-center">
            <div class="panel panel-default">
                <div class="panel-body profile">
                    <div class="profile-image">
                        <?php if ($model->foto == '') {?>
                        <img src="/extra/images/users/avatar.jpg" alt="Nadia Ali">
                        <?php } else {?>
                        <?= ($model->foto)?Html::img('/uploads/user/foto/'.$model->foto,['style'=>'min-width: 50px;min-height: 50px']):null;?>
                        <?php }?>
                    </div>
                    <div class="profile-data">
                        <div class="profile-data-name"><?=$model->fio?></div>
                        <div class="profile-data-title"><?=$model->getTypeDescription()?></div>
                    </div>
                    <div class="profile-controls">
                        <?= Html::a('<span class="fa fa-pencil"></span>', ['/users/change', 'id' => $model->id], [ 'role' => 'modal-remote', 'title'=> 'Профиль','class'=>'profile-control-left']); ?>
                        <?= Html::a('<span class="fa fa-download"></span>', ['/users/avatar'], [ 'role' => 'modal-remote', 'title'=> 'Загрузить аватар','class'=>'profile-control-right']); ?>
                    </div>
                </div>                                
                <div class="panel-body"> 
                    <div class="row">
                        <div class="col-md-4">                                    
                        <div class="contact-info">
                            <p><small>ФИО</small><br><?=$model->fio?></p> 
                            <p><small>Email</small><br><?=$model->email?></p> 
                            <p><small>address</small><br><?=$model->phone?></p>      
                        </div>
                        </div>
                        <div class="col-md-3">                                    
                        <div class="contact-info">
                            <p><small>Facebook</small><br><?=$model->facebook?></p> 
                            <p><small>Telegram</small><br><?=$model->telegram?></p> 
                            <p><small>Twitter</small><br><?=$model->twitter?></p>      
                        </div>
                        </div>
                        <div class="col-md-5">                                    
                        <div class="contact-info">
                            <p><small>Имя пользователя</small><br><?=$model->username?></p> 
                            <p><small>Ссылка на сайт</small><br><?=$model->site?></p> 
                            <p><small>Страна/Город</small><br><?=$model->address?></p>      
                        </div>
                        </div>
                    </div>
                </div>                                
            </div>
    </div>
        <!-- END CONTACT ITEM -->
    </div>                       
</div>
<?php Pjax::end() ?>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "options" => [
        "tabindex" => false,
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>