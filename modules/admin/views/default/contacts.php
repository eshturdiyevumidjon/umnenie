 <?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\date\DatePicker;
use katzz0\yandexmaps\Map;
use katzz0\yandexmaps\JavaScript; 
use katzz0\yandexmaps\objects\Placemark;
use katzz0\yandexmaps\Polyline;
use katzz0\yandexmaps\Point;
use katzz0\yandexmaps\Canvas as YandexMaps;
use yii\widgets\Pjax; 
/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Контакты';
// $this->params['breadcrumbs'][] = $this->title;

// CrudAsset::register($this);
?>
 <div class="header about-header">
        <div class="header-top">
            <div id="navbar-left" class="header-menu">
                <ul class="header-menu-ul">
                    <li class="header-menu-li"><a href="<?=Url::toRoute(['default/index'])?>">Главная</a></li>
                    <li class="header-menu-li"><a href="<?=Url::toRoute(['default/about'])?>">О компании</a></li>
                    <li class="header-menu-li"><a href="<?=Url::toRoute(['default/objects'])?>">Объекты</a></li>
                    <li class="header-menu-li"><a href="<?=Url::toRoute(['default/contacts'])?>">Контакты</a></li>
                </ul>
            </div> 
            <i class="header-logo wow bounceInDown"></i>
            <div id="navbar-right" class="header-feedback">
                <div class="hamburger-menu">
                    <input id="menu__toggle" type="checkbox" />
                    <label class="menu__btn" for="menu__toggle">
                        <span></span>
                    </label>
                    <ul class="menu__box">
                        <li><a class="menu__item" href="<?=Url::toRoute(['default/index'])?>">Главная</a></li>
                        <li><a class="menu__item" href="<?=Url::toRoute(['default/about'])?>">О компании</a></li>
                        <li><a class="menu__item" href="<?=Url::toRoute(['default/objects'])?>">Объекты</a></li>
                        <li><a class="menu__item" href="<?=Url::toRoute(['default/contacts'])?>">Контакты</a></li>
                    </ul>
                </div>
                <p class="header-feedback-number">+998 94 355 55 55</p>
                <button class="header-feedback-button">Обратная связь</button>
            </div>
        </div>
        <h4 class="header-text">Контакты</h4>
        <div class="about-header-bottom">
            <div class="header-bottom-left">
                <p class="header-bottom-left-text">Главная &nbsp; /    &nbsp; О компании</p>
            </div>
            <div class="header-bottom-right">
                <ul class="header-bottom-ul">
                    <li class="header-menu-li header-bottom-li"><a href="<?=Url::toRoute(['default/about'])?>">О компании</a></li>
                    <li class="header-menu-li header-bottom-li"><a href="<?=Url::toRoute(['default/commands'])?>">Команда</a></li>
                    <li class="header-menu-li header-bottom-li"><a href="<?=Url::toRoute(['default/jobs'])?>">Вакансии</a></li>
                    <li class="header-menu-li header-bottom-li"><a href="<?=Url::toRoute(['default/partners'])?>">Партнерам</a></li>
                    <li class="header-menu-li header-bottom-li"><a href="<?=Url::toRoute(['default/contacts'])?>">Контакты</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="container-contacts">
        <div class="container-contacts-text">
        <h4>Адрес</h4>
        <p><?=$model->address_ru?></p>
        <h4>Телефон</h4>
        <p><?=$model->phone?></p>
        <h4>E-mail</h4>
        <p><?=$model->email?></p>
        <h4>Факс</h4>
        <p><?=$model->fax?></p>
        </div>
        <div class="col-md-9">
            <?= YandexMaps::widget([
                    'htmlOptions' => [
                        'style' => 'height: 530px;',
                    ],
                    'map' => new Map('yandex_map', [
                        'center' => [$model->coordinate_x, $model->coordinate_y],
                        'zoom' => 11,
                        'controls' => [Map::CONTROL_ZOOM],
                        'behaviors' => [Map::BEHAVIOR_DRAG],
                        'type' => "yandex#map",
                    ],
                    [
                        'objects' => [new Placemark(new Point($model->coordinate_x, $model->coordinate_y), [], [
                            'draggable' => false,
                            'preset' => 'islands#dotIcon',
                            'iconColor' => '#2E9BB9',
                            'events' => [
                                'dragend' => 'js:function (e) {
                                    console.log(e.get(\'target\').geometry.getCoordinates());
                                }'
                            ]
                        ])]
                    ])
                ]) ?>
        </div>
    </div>    
