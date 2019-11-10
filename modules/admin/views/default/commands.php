 <?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax; 
/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Команда';
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
        <h4 class="header-text">Команда</h4>
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
    
    <div class="container-team-blocks container-team-blocks-1">
        <div class="container-team-block">
            <div class="container-team-block-left">
                <div class="container-team-block-left-texts">
                    <h4 class="container-object-block-wrap-texts-title">Mirabad <br> Avenue</h4>
                    <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                </div>
            </div>
            <div class="container-team-block-right">
                <img class="container-team-block-right-img" src="/frontend/img/team-img.png" alt="team-img">
                <p class="container-team-block-right-text">Envato is the leading marketplace for creative assets and creative people. Millions of people around the world choose our marketplace, studio and courses to buy files, hire freelancers, or learn the skills needed to build websites, videos, apps, graphics and more.</p>
            </div>
        </div>
        <div class="container-team-block">
            <div class="container-team-block-left">
                <div class="container-team-block-left-texts">
                    <h4 class="container-object-block-wrap-texts-title">Mirabad <br> Avenue</h4>
                    <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                </div>
            </div>
            <div class="container-team-block-right">
                <img class="container-team-block-right-img" src="/frontend/img/team-img.png" alt="team-img">
                <p class="container-team-block-right-text">Envato is the leading marketplace for creative assets and creative people. Millions of people around the world choose our marketplace, studio and courses to buy files, hire freelancers, or learn the skills needed to build websites, videos, apps, graphics and more.</p>
            </div>
        </div>
    </div>
    <div class="container-team-blocks container-team-blocks-2">
        <div class="container-team-block">
            <div class="container-team-block-left">
                <div class="container-team-block-left-texts">
                    <h4 class="container-object-block-wrap-texts-title">Mirabad <br> Avenue</h4>
                    <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                </div>
            </div>
            <div class="container-team-block-right">
                <img class="container-team-block-right-img" src="/frontend/img/team-img.png" alt="team-img">
                <p class="container-team-block-right-text">Envato is the leading marketplace for creative assets and creative people. Millions of people around the world choose our marketplace, studio and courses to buy files, hire freelancers, or learn the skills needed to build websites, videos, apps, graphics and more.</p>
            </div>
        </div>
        <div class="container-team-block">
            <div class="container-team-block-left">
                <div class="container-team-block-left-texts">
                    <h4 class="container-object-block-wrap-texts-title">Mirabad <br> Avenue</h4>
                    <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                </div>
            </div>
            <div class="container-team-block-right">
                <img class="container-team-block-right-img" src="/frontend/img/team-img.png" alt="team-img">
                <p class="container-team-block-right-text">Envato is the leading marketplace for creative assets and creative people. Millions of people around the world choose our marketplace, studio and courses to buy files, hire freelancers, or learn the skills needed to build websites, videos, apps, graphics and more.</p>
            </div>
        </div>
    </div>
    <div class="container-team-blocks container-team-blocks-3">
        <div class="container-team-block">
            <div class="container-team-block-left">
                <div class="container-team-block-left-texts">
                    <h4 class="container-object-block-wrap-texts-title">Mirabad <br> Avenue</h4>
                    <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                </div>
            </div>
            <div class="container-team-block-right">
                <img class="container-team-block-right-img" src="/frontend/img/team-img.png" alt="team-img">
                <p class="container-team-block-right-text">Envato is the leading marketplace for creative assets and creative people. Millions of people around the world choose our marketplace, studio and courses to buy files, hire freelancers, or learn the skills needed to build websites, videos, apps, graphics and more.</p>
            </div>
        </div>
        <div class="container-team-block">
            <div class="container-team-block-left">
                <div class="container-team-block-left-texts">
                    <h4 class="container-object-block-wrap-texts-title">Mirabad <br> Avenue</h4>
                    <p class="container-object-block-wrap-texts-text">Идёт строительство</p>
                </div>
            </div>
            <div class="container-team-block-right">
                <img class="container-team-block-right-img" src="/frontend/img/team-img.png" alt="team-img">
                <p class="container-team-block-right-text">Envato is the leading marketplace for creative assets and creative people. Millions of people around the world choose our marketplace, studio and courses to buy files, hire freelancers, or learn the skills needed to build websites, videos, apps, graphics and more.</p>
            </div>
        </div>
    </div>
