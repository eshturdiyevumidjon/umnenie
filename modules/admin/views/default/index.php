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

$this->title = 'Главная';
// $this->params['breadcrumbs'][] = $this->title;

// CrudAsset::register($this);
?>
<div class="header">
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
        <div class="header-bottom">
            <div class="header-bottom-icons wow bounceInLeft">
                <i class="header-bottom-icons-google"></i>
                <i class="header-bottom-icons-instagram"></i>
                <i class="header-bottom-icons-facebook"></i>
                <i class="header-bottom-icons-twitter"></i>
            </div>
            <div class="header-bottom-price wow bounceInRight">
                <div class="header-bottom-price-icon-block">
                    <i class="header-bottom-price-icon"></i>
                </div>
                <div class="header-bottom-price-text-block">
                    <p class="header-bottom-price-text"><span class="header-bottom-price-text-orange">Специальные цены.</span> Ограниченное количество квартир</p>
                </div>
            </div>
        </div>
        <div class="header-slider owl-carousel owl-theme owl-loaded">
            <div class="header-slider-item">
            <div class="owl-item-text">Саларьево парк. Новый город в Новой Москве — проект небывалого масштаба Специальные цены</div>
            <button class="owl-item-button">Подробнее<i class="owl-item-button-icon"></i></button></div>
            <div class="header-slider-item">
            <div class="owl-item-text">Саларьево парк. Новый город в Новой Москве — проект небывалого масштаба Специальные цены</div>
            <button class="owl-item-button">Подробнее<i class="owl-item-button-icon"></i></button></div>
            <div class="header-slider-item">
            <div class="owl-item-text">Саларьево парк. Новый город в Новой Москве — проект небывалого масштаба Специальные цены</div>
            <button class="owl-item-button">Подробнее<i class="owl-item-button-icon"></i></button></div>
        </div>
    </div>
    
    <div class="container-gallery">
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
    
    <div class="container-object">
        <div class="container-object-top">
            <h4 class="container-object-top-text">Готовые объекты</h4>
            <button class="container-object-top-button">Подробнее<i class="container-object-top-button-icon"></i></button>
        </div>
        
        <div class="container-object-blocks">
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
    </div>
    
    <div class="container-finished-object">
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
    
    <div class="container-images">
       <div class="container-images-blocks-1">
        <div class="container-images__item container-images__item--1">
            <a data-fancybox="gallery" href="img/x1.jpg"><img src="/frontend/img/img-1.png" class="container-images__img container-images__img-1" alt="Image 1"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
        <div class="container-images__item container-images__item--2">
            <a data-fancybox="gallery" href="img/x2.jpg"><img src="/frontend/img/img-2.png" class="container-images__img container-images__img-2" alt="Image 2"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
        <div class="container-images__item container-images__item--3">
            <a data-fancybox="gallery" href="img/x3.jpg"><img src="/frontend/img/img-3.png" class="container-images__img container-images__img-3" alt="Image 3"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
        <div class="container-images__item container-images__item--4">
            <a data-fancybox="gallery" href="img/x4.jpg"><img src="/frontend/img/img-4.png" class="container-images__img container-images__img-4" alt="Image 4"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
        <div class="container-images__item container-images__item--5">
            <a data-fancybox="gallery" href="img/x5.jpg"><img src="/frontend/img/img-5.png" class="container-images__img container-images__img-5" alt="Image 5"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
        <div class="container-images__item container-images__item--6">
            <a data-fancybox="gallery" href="img/x1.jpg"><img src="/frontend/img/img-6.png" class="container-images__img container-images__img-6" alt="Image 6"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
       </div>
       <div class="container-images-blocks-2">
           <div class="container-images__item container-images__item--7">
            <a data-fancybox="gallery" href="img/x1.jpg"><img src="/frontend/img/img-7.png" class="container-images__img container-images__img-7" alt="Image 6"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
            </div>
            <div class="container-images__item container-images__item--8">
                <a data-fancybox="gallery" href="img/x2.jpg"><img src="/frontend/img/img-1.png" class="container-images__img container-images__img-8" alt="Image 6"></a>
                <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
            </div>
            <div class="container-images__item container-images__item--9">
                <a data-fancybox="gallery" href="img/x3.jpg"><img src="/frontend/img/img-2.png" class="container-images__img container-images__img-9" alt="Image 6"></a>
                <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
            </div>
            <div class="container-images-blocks-4">
            <div class="container-images-block-3 container-images__item--10">
                <h4 class="container-images-block-3-title">Глазами наших жителей</h4>
                <p class="container-images-block-3-text">Отправьте заявку онлайн сразу в несколько банков и сократите время <br> оформления ипотеки.</p>
                <button class="container-images-block-3-button">Смотреть все<i class="container-images-block-3-button-icon"></i></button>
            </div>
        </div>
        </div>
       <div class="container-images-blocks-3">
           <div class="container-images__item container-images__item--11">
            <a data-fancybox="gallery" href="img/x4.jpg"><img src="/frontend/img/img-3.png" class="container-images__img container-images__img-10" alt="Image 6"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
        <div class="container-images__item container-images__item--12">
            <a data-fancybox="gallery" href="img/x5.jpg"><img src="/frontend/img/img-4.png" class="container-images__img container-images__img-11" alt="Image 6"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
        <div class="container-images__item container-images__item--13">
            <a data-fancybox="gallery" href="img/x1.jpg"><img src="/frontend/img/img-5.png" class="container-images__img container-images__img-12" alt="Image 6"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
        <div class="container-images__item container-images__item--14">
            <a data-fancybox="gallery" href="img/x2.jpg"><img src="/frontend/img/img-6.png" class="container-images__img container-images__img-13" alt="Image 6"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
        <div class="container-images__item container-images__item--15">
            <a data-fancybox="gallery" href="img/x3.jpg"><img src="/frontend/img/img-7.png" class="container-images__img container-images__img-14" alt="Image 6"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
        <div class="container-images__item container-images__item--16">
            <a data-fancybox="gallery" href="img/x4.jpg"><img src="/frontend/img/img-3.png" class="container-images__img container-images__img-16" alt="Image 6"></a>
            <div class="container-images__item-hover">
                    <div class="container-images__item-hover-left">
                        <img src="/frontend/img/insta-face.png" alt="">
                        <p>@drjro74_37</p>
                    </div>
                    <div class="container-images__item-hover-right">
                        <p>326</p>
                        <img src="/frontend/img/like.png" alt="">
                    </div>
                </div>
        </div>
       </div>
    </div>