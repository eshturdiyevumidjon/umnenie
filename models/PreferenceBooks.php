<?php

namespace app\models;

use Yii;

class PreferenceBooks
{
    public function getMonthName($name)
    {
        if($name == '') return $name;
        if($name == 1) return 'Январь';
        if($name == 2) return 'Февраль';
        if($name == 3) return 'Март';
        if($name == 4) return 'Апрель';
        if($name == 5) return 'Май';
        if($name == 6) return 'Июнь';
        if($name == 7) return 'Июль';
        if($name == 8) return 'Август';
        if($name == 9) return 'Сентябрь';
        if($name == 10) return 'Октябрь';
        if($name == 11) return 'Ноябрь';
        if($name == 12) return 'Декабрь';
    }

    public function getMonthNumber($name)
    {
        if($name == 'Янв') return '01';
        if($name == 'Фев') return '02';
        if($name == 'Мар') return '03';
        if($name == 'Апр') return '04';
        if($name == 'Май') return '05';
        if($name == 'Июн') return '06';
        if($name == 'Июл') return '07';
        if($name == 'Авг') return '08';
        if($name == 'Сен') return '09';
        if($name == 'Окт') return '10';
        if($name == 'Ноя') return '11';
        if($name == 'Дек') return '12';
    }

    public static function sendMessageToEmail($to, $subject, $text)
    {
        $from = 'alltender.uz@gmail.com';

        $message = Yii::$app->mailer->compose()
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($text);

        try{
            Yii::$app->mailer->send($message);
            return true;
        } catch(\Swift_TransportException $e) {
            Yii::$app->session->setFlash('warning', 'Сообщение не был отправлен. Ошибка: '.$e->getMessage());
            return $e->getMessage();
        } catch(\Exception $e){
            Yii::$app->session->setFlash('error', 'Сообщение не был отправлен. Ошибка: '.$e->getMessage());
            return $e->getMessage();
        }

    }

}