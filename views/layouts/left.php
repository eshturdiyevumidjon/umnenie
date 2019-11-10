<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset; 
use yii\helpers\Url;
use app\models\Users;
use yii\widgets\Pjax;
$model = Users::findOne(Yii::$app->user->identity->id);
$pathInfo = Yii::$app->request->pathInfo;
?>
<ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="<?= Yii::$app->homeUrl ?>"><?= Yii::$app->name ?></a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <!--   KICHIK LOGO UCHUN VA PROFIL BOSHLANDI -->
                    <li class="xn-profile">  
                        <a href="#" class="profile-mini">
                            <?php if ($model->foto == '') {?>
                                    <img src="/extra/images/users/avatar.jpg" alt="Nadia Ali">
                            <?php } else {?>
                                <?= ($model->foto)?Html::img('/uploads/user/foto/'.$model->foto,['style'=>'']):null;?>
                            <?php }?>
                        </a>  
                        <div class="profile">
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
                                
                                <?= Html::a('<span class="fa fa-info"></span>', ['/users/profile'], ['title'=> '','class'=>'profile-control-left']); ?>
                                <a href="#" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                            </div>
                        </div>
                                                                    
                    </li>
                    <?php 
                        $class="";
                        if( $pathInfo == 'poll-category/index' || $pathInfo == 'specialization/index' || $pathInfo == 'poll-items/index'|| $pathInfo == 'answers/index'|| $pathInfo == 'block-user/index'|| $pathInfo == 'complaints/index'|| $pathInfo == 'mailing/index'|| $pathInfo == 'subscribe-to-user/index'|| $pathInfo == 'subscribes/index')
                            $class="active";
                    ?>
                    <li <?=(Yii::$app->request->pathInfo == 'site/dashboard' ? 'class="active"' : '')?>>
                        <?= Html::a('<span class="fa fa-desktop"></span> <span class="xn-text">Рабочий стол</span>', ['/site/dashboard'], []); ?>
                    </li>
                    <li <?=(Yii::$app->request->pathInfo == 'polls/index' ? 'class="active"' : '')?>>
                        <?= Html::a('<span class="fa fa-archive"></span> <span class="xn-text">Опросы</span>', ['/polls/index'], []); ?>
                    </li>
                    <li <?=(Yii::$app->request->pathInfo == 'users/index' ? 'class="active"' : '')?>>
                        <?= Html::a('<span class="fa fa-user"></span> <span class="xn-text">Пользователи</span>', ['/users/index'], []); ?>
                    </li>
                    <li <?=(Yii::$app->request->pathInfo == 'chat/index' ? 'class="active"' : '')?>>
                        <?= Html::a('<span class="fa fa-comment"></span> <span class="xn-text">Чат</span>', ['/chat/index'], []); ?>
                    </li>
                    <li <?=(Yii::$app->request->pathInfo == 'chat/admin' ? 'class="active"' : '')?>>
                        <?= Html::a('<span class="fa fa-comment"></span> <span class="xn-text">Чат с админам</span>', ['/chat/admin'], []); ?>
                    </li>
                    <li <?=(Yii::$app->request->pathInfo == 'settings/index' ? 'class="active"' : '')?>>
                        <?= Html::a('<span class="fa fa-wrench"></span> <span class="xn-text">Настройки</span>', ['/settings/index'], []); ?>
                    </li>
                    <li class="xn-openable <?=$class?>">
                        <a href="#"><span class="fa fa-list"></span><span class="xn-text">Справочник</span></a>
                        <ul>
                            <li <?= ($pathInfo == 'poll-category/index' ? 'class="active"' : '')?>><a href="/poll-category/index"><span class="fa fa-bars"></span> Категория опроса</a></li>
                            <li <?= ($pathInfo == 'specialization/index' ? 'class="active"' : '')?>><a href="/specialization/index"><span class="fa fa-bars"></span> Специализация</a></li>
                            <!-- <li <?= ($pathInfo == 'poll-items/index' ? 'class="active"' : '')?>><a href="/poll-items/index"><span class="fa fa-bars"></span> Пункты опроса</a></li> -->
                            <!-- <li <?= ($pathInfo == 'answers/index' ? 'class="active"' : '')?>><a href="/answers/index"><span class="fa fa-bars"></span> Ответы на опроса</a></li> -->
                            <!-- <li <?= ($pathInfo == 'block-user/index' ? 'class="active"' : '')?>><a href="/block-user/index"><span class="fa fa-bars"></span> Заблокировать пользователя</a></li> -->
                            <li <?= ($pathInfo == 'complaints/index' ? 'class="active"' : '')?>><a href="/complaints/index"><span class="fa fa-bars"></span> Жалобы</a></li>
                            <li <?= ($pathInfo == 'mailing/index' ? 'class="active"' : '')?>><a href="/mailing/index"><span class="fa fa-bars"></span> Рассылка</a></li>
                            <!-- <li><a href="/subscribe-to-poll/index"><span class="fa fa-bars"></span>  Подписаться на опрос</a></li> -->
                            <!-- <li <?= ($pathInfo == 'subscribe-to-user/index' ? 'class="active"' : '')?>><a href="/subscribe-to-user/index"><span class="fa fa-bars"></span> Подписаться на пользователя</a></li> -->
                            <!-- <li <?= ($pathInfo == 'subscribes/index' ? 'class="active"' : '')?>><a href="/subscribes/index"><span class="fa fa-bars"></span> Подписчики</a></li> -->
                        </ul>
                    </li> 
                    
                    
        </ul>