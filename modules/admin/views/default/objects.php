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

$this->title = 'Объекты';
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
        <h4 class="header-text">Объекты</h4>
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
    
    <div class="container-object container-object-objectshtml">
        <div class="container-object-blocks container-object-blocks-objects">
            <div class="container-object-block container-object-block-1">
                <div class="container-object-block-wrap">
                    <div class="container-object-block-wrap-house">
                        <i class="container-object-block-wrap-house-icon"></i>
                        <p class="container-object-block-wrap-house-text">99</p>
                    </div>
                    <div class="container-object-block-wrap-meters">
                        <p class="container-object-block-wrap-meters-text">Квартиры от 61 до 171 м²</p>
                    </div>
                    <div class="container-object-block-wrap-texts">
                        <h4 class="container-object-block-wrap-texts-title">Mirabad Avenue</h4>
                        <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                    </div>
                </div>
            </div>
            <div class="container-object-block container-object-block-2">
                <div class="container-object-block-wrap">
                    <div class="container-object-block-wrap-house">
                        <i class="container-object-block-wrap-house-icon"></i>
                        <p class="container-object-block-wrap-house-text">99</p>
                    </div>
                    <div class="container-object-block-wrap-meters">
                        <p class="container-object-block-wrap-meters-text">Квартиры от 61 до 171 м²</p>
                    </div>
                    <div class="container-object-block-wrap-texts">
                        <h4 class="container-object-block-wrap-texts-title">Mirabad Avenue</h4>
                        <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-object-blocks">
            <div class="container-object-block container-object-block-3">
                <div class="container-object-block-wrap">
                    <div class="container-object-block-wrap-house">
                        <i class="container-object-block-wrap-house-icon"></i>
                        <p class="container-object-block-wrap-house-text">99</p>
                    </div>
                    <div class="container-object-block-wrap-meters">
                        <p class="container-object-block-wrap-meters-text">Квартиры от 61 до 171 м²</p>
                    </div>
                    <div class="container-object-block-wrap-texts">
                        <h4 class="container-object-block-wrap-texts-title">Mirabad Avenue</h4>
                        <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                    </div>
                </div>
            </div>
            <div class="container-object-block container-object-block-4">
                <div class="container-object-block-wrap">
                    <div class="container-object-block-wrap-house">
                        <i class="container-object-block-wrap-house-icon"></i>
                        <p class="container-object-block-wrap-house-text">99</p>
                    </div>
                    <div class="container-object-block-wrap-meters">
                        <p class="container-object-block-wrap-meters-text">Квартиры от 61 до 171 м²</p>
                    </div>
                    <div class="container-object-block-wrap-texts">
                        <h4 class="container-object-block-wrap-texts-title">Mirabad Avenue</h4>
                        <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-object-blocks">
            <div class="container-object-block container-object-block-5">
                <div class="container-object-block-wrap">
                    <div class="container-object-block-wrap-house">
                        <i class="container-object-block-wrap-house-icon"></i>
                        <p class="container-object-block-wrap-house-text">99</p>
                    </div>
                    <div class="container-object-block-wrap-meters">
                        <p class="container-object-block-wrap-meters-text">Квартиры от 61 до 171 м²</p>
                    </div>
                    <div class="container-object-block-wrap-texts">
                        <h4 class="container-object-block-wrap-texts-title">Mirabad Avenue</h4>
                        <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                    </div>
                </div>
            </div>
            <div class="container-object-block container-object-block-6">
                <div class="container-object-block-wrap">
                    <div class="container-object-block-wrap-house">
                        <i class="container-object-block-wrap-house-icon"></i>
                        <p class="container-object-block-wrap-house-text">99</p>
                    </div>
                    <div class="container-object-block-wrap-meters">
                        <p class="container-object-block-wrap-meters-text">Квартиры от 61 до 171 м²</p>
                    </div>
                    <div class="container-object-block-wrap-texts">
                        <h4 class="container-object-block-wrap-texts-title">Mirabad Avenue</h4>
                        <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-object-blocks">
            <div class="container-object-block container-object-block-5">
                <div class="container-object-block-wrap">
                    <div class="container-object-block-wrap-house">
                        <i class="container-object-block-wrap-house-icon"></i>
                        <p class="container-object-block-wrap-house-text">99</p>
                    </div>
                    <div class="container-object-block-wrap-meters">
                        <p class="container-object-block-wrap-meters-text">Квартиры от 61 до 171 м²</p>
                    </div>
                    <div class="container-object-block-wrap-texts">
                        <h4 class="container-object-block-wrap-texts-title">Mirabad Avenue</h4>
                        <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                    </div>
                </div>
            </div>
            <div class="container-object-block container-object-block-6">
                <div class="container-object-block-wrap">
                    <div class="container-object-block-wrap-house">
                        <i class="container-object-block-wrap-house-icon"></i>
                        <p class="container-object-block-wrap-house-text">99</p>
                    </div>
                    <div class="container-object-block-wrap-meters">
                        <p class="container-object-block-wrap-meters-text">Квартиры от 61 до 171 м²</p>
                    </div>
                    <div class="container-object-block-wrap-texts">
                        <h4 class="container-object-block-wrap-texts-title">Mirabad Avenue</h4>
                        <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-gallery container-gallery-objectshtml">
        <div class="container-gallery-slider owl-carousel owl-theme owl-loaded">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    <div class="owl-item">
                        <i class="container-gallery-slider-img"></i>
                        <div class="container-gallery-slider-text">Саларьево парк. Новый город в Новой Москве — проект небывалого масштаба Специальные цены</div>
                    </div>
                    <div class="owl-item">
                        <i class="container-gallery-slider-img"></i>
                        <div class="container-gallery-slider-text">Саларьево парк. Новый город в Новой Москве — проект небывалого масштаба Специальные цены</div>
                    </div>
                    <div class="owl-item">
                        <i class="container-gallery-slider-img"></i>
                        <div class="container-gallery-slider-text">Саларьево парк. Новый город в Новой Москве — проект небывалого масштаба Специальные цены</div>
                    </div>
                </div>
            </div>
        </div>
    </div>