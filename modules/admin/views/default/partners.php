<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\UserData */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Партнёрам';
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
        <h4 class="header-text">Партнёрам</h4>
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
       <p class="partners-container-gallery-text">У нас открыта вакансия Главный менеджер по продажам!</p>
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
    
    <p class="about-container-text-2 about-container-text-2-partners">Хотите классную работу? <br>
У нас открыта вакансия Главный менеджер по продажам! <br>
Мы регулярно запускаем новые проекты и очень быстро растем.</p>
    
    <div class="accordion">
        <?php foreach ($partners as $model) {?>
        <ul>
          <li> 
            <input type="checkbox" checked>
            <div class="accordion-icon-wrap"></div>
            <i></i>
            <h2 class="title_block"><?=$model->name?></h2>
            <div class="msg">
                <?=$model->text?>
                <form class="form" action="send" method="get">
                    <input type="hidden" value="<?php echo $model->id ?>" name="partner_id">
                    <fieldset class="form-field form-field-1">
                        <label class="form-label" for=""></label>
                        <input class="form-input form-input-1" id="fio" name="fio" required="" type="name" placeholder="Ф.И.О"/>
                    </fieldset>
                    <fieldset class="form-field form-field-2"> 
                        <label class="form-label" for=""></label>
                        <input class="form-input form-input-2" id="email" name="email" required="" type="email" placeholder="Email"/>
                    </fieldset>
                    <fieldset class="form-field form-field-1-3">
                        <label class="form-label" for=""></label>
                        <input class="form-input form-input-3" id="name" name="name" required="" type="text" placeholder="Название компании"/>
                    </fieldset>
                    <fieldset class="form-field form-field-4">
                        <label class="form-label" for=""></label>
                        <textarea class="form-textarea" placeholder="Сообщение" id="message" name="message"></textarea>
                    </fieldset>
                    <fieldset class="form-field form-field-5">
                        <label class="form-label" for=""></label>
                        <input class="form-input form-input-4" id="phone" name="phone" type="text" placeholder="Номер телефона"/>
                    </fieldset>
                    <fieldset class="form-field form-field-6">
                        <label class="form-label" for="" style="margin-left: 65px;margin-top: 40px">
                            <div class="g-recaptcha" data-sitekey="6Lc6GqwUAAAAAKnAoJ8EcqYmIXRqUK2AWfv4_6FB"></div>
                            <div class="text-danger" id="recaptchaError"></div>
                        </label>
                    </fieldset>
                    <fieldset class="form-field form-field-7">
                        <button class="form-button" type="submit">Отправить <span class="form-button-icon"></span></button>
                    </fieldset>
                </form>
            </div>
          </li>          
        </ul>
        <?php }?>
   </div>
    


<div class="user-data-form">
<script src='https://www.google.com/recaptcha/api.js'></script>

   
    
</div>
