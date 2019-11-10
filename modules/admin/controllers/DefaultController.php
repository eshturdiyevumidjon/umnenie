<?php

namespace app\modules\admin\controllers;

use yii\web\Controller; 
use app\models\Contacts;
use app\models\Commands;
use app\models\Partners;
use app\models\Vacancy;
use app\models\PartnersData; 
use app\models\UserData;
/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionContacts()
    {   
        $model =  Contacts::find()->where(['id'=>1])->one();
        return $this->render('contacts', [
            'model' => $model,
        ]);
    }
    public function actionCommands()
    {   
        $model =  Commands::find()->all();
        return $this->render('commands', [
            'model' => $model,
        ]);
    }
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionObjects()
    {
        return $this->render('objects');
    }
    public function actionPartners()
    {
        $partners =  Partners::find()->all();
        return $this->render('partners', [
            'partners' => $partners,
        ]);

    }
    public function actionJobs()
    {
        $vacancy =  Vacancy::find()->all();
        return $this->render('jobs', [
            'vacancy' => $vacancy,
        ]);
    }
    public function actionSendJobs()
    {
        $vacancy=new UserData();
        if (isset($_GET['fio'])) {
            $vacancy->fio=$_GET['fio'];
            $vacancy->email=$_GET['email'];
            $vacancy->name=$_GET['name'];
            $vacancy->message=$_GET['message'];
            $vacancy->phone=$_GET['phone'];
            $vacancy->vacancy_id=$_GET['vacancy_id'];
            $vacancy->save();
        }

        return $this->redirect(['jobs']);
    }
    public function actionSend()
    {
        $partners=new PartnersData();
        if (isset($_GET['fio'])) {
            $partners->fio=$_GET['fio'];
            $partners->email=$_GET['email'];
            $partners->name=$_GET['name'];
            $partners->message=$_GET['message'];
            $partners->phone=$_GET['phone'];
            $partners->partner_id=$_GET['partner_id'];
            $partners->save();
        }

        return $this->redirect(['partners']);
    }
}
