 <?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'О компании';
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
        <h4 class="header-text">О компании</h4>
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
    
    <p class="about-container-text-1">Мы хотим, чтобы наши клиенты каждый день убеждались, что сделали правильный выбор. Как этого добиться? Очень просто. Надо строить дома, в которые можно по-настоящему влюбиться. Это наша философия. В <span>2015</span> году мы решили, что наше доступное жилье должно подняться на новый уровень.</p>
    
    
    <div class="about-container-gallery">
        <div class="about-container-gallery-slider owl-carousel owl-theme owl-loaded">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    <div class="owl-item">
                    </div>
                    <div class="owl-item">
                    </div>
                    <div class="owl-item">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <p class="about-container-text-2">Саларьево парк. Новый город в Новой Москве — проект небывалого масштаба Специальные цены</p>
    
    <div class="container-finished-object container-finished-object-about">
        <h3 class="container-finished-object-title">Готовые объекты</h3>
        <div class="container-finished-object-blocks">
           <div class="container-finished-object-blocks-1">
                <div class="container-finished-object-block container-finished-object-block-1">
                    <i class="container-finished-object-block-icon container-finished-object-block-1-icon"></i>
                    <h4 class="container-finished-object-block-1-title">Надежность</h4>
                    <p class="container-finished-object-block-1-text">Дом без внутренних отделочных работ, под чистовую отделку, что позволит в кратчайшие сроки воплотить ваши дизайнерские фантазии. <br> В дом заведен газ и электричество,</p>
                </div>
                <div class="container-finished-object-block container-finished-object-block-2">
                    <i class="container-finished-object-block-icon container-finished-object-block-2-icon"></i>
                    <h4 class="container-finished-object-block-1-title">Контроль качества</h4>
                    <p class="container-finished-object-block-1-text">Дом без внутренних отделочных работ, под чистовую отделку, что позволит в кратчайшие сроки воплотить ваши дизайнерские фантазии. <br> В дом заведен газ и электричество,</p>
                </div>
            </div>
            <div class="container-finished-object-blocks-2">
                <div class="container-finished-object-block container-finished-object-block-3">
                    <i class="container-finished-object-block-icon container-finished-object-block-3-icon"></i>
                    <h4 class="container-finished-object-block-1-title">Рабство</h4>
                    <p class="container-finished-object-block-1-text">Дом без внутренних отделочных работ, под чистовую отделку, что позволит в кратчайшие сроки воплотить ваши дизайнерские фантазии. <br> В дом заведен газ и электричество,</p>
                </div>
                <div class="container-finished-object-block container-finished-object-block-4">
                    <i class="container-finished-object-block-icon container-finished-object-block-4-icon"></i>
                    <h4 class="container-finished-object-block-1-title">Мировой уровень</h4>
                    <p class="container-finished-object-block-1-text">Дом без внутренних отделочных работ, под чистовую отделку, что позволит в кратчайшие сроки воплотить ваши дизайнерские фантазии. <br> В дом заведен газ и электричество,</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="about-container-finished-object">
        <div class="about-container-finished-object-slider owl-carousel owl-theme owl-loaded">
            <div class="owl-stage-outer">
               <p class="owl-stage-outer-text">Готовые объекты</p>
                <div class="owl-stage">
                    <div class="owl-item owl-item-1"></div>
                    <div class="owl-item owl-item-2"></div>
                    <div class="owl-item owl-item-3"></div>
                    <div class="owl-item owl-item-4"></div>
                    <div class="owl-item owl-item-5"></div>
                    <div class="owl-item owl-item-6"></div>
                </div>
            </div>
        </div>
    </div>