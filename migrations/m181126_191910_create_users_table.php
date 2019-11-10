<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m181126_191910_create_users_table extends Migration
{
    /** 
     * {@inheritdoc}   
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            //-------------Общий и Администратор проекта ---------------
            'type' => $this->integer()->comment('Роль пользователя'),
            'facebook_user_id' => $this->string(500)->comment('Регистрация Facebook'),
            'vk_user_id' => $this->string(500)->comment('Регистрация VK'),
            'registry_date' => $this->date()->comment('Дата регистрации'),
            'foto' => $this->string(255)->comment('Аватар/ Фото профиля/ Логотип'),
            'logo' => $this->string(255)->comment('Фото – обложка / брендированный фон'),
            'comments'=> $this->text()->comment('О себе'),
            'gender' => $this->integer()->comment('Пол'), 
            'facebook' => $this->string(255)->comment('Facebook'),
            'telegram' => $this->string(255)->comment('Telegram'),
            'twitter' => $this->string(255)->comment('Twitter'),
            'site' => $this->string(255)->comment('Ссылка на сайт'),
            'email' => $this->string(255)->comment('Email'),
            'category_id' => $this->text()->comment('Категория'),
            'phone' => $this->string(255)->comment('Телефон'),
            'address' => $this->text()->comment('Страна/Город'),
            'fio' => $this->string(255)->comment('Ф.И.О'),
            'specialization_id' => $this->text()->comment('Специализация'),
            'username' => $this->string(255)->comment('Имя пользователя'),
            'password' => $this->string(255)->comment('Пароль'),
            'verified' => $this->boolean()->comment('Утвержденный'),
            'profi_status' => $this->boolean()->comment('Cтатус профи'),
            //------------------- Физическое лицо ---------------------
            
            'birthday'=> $this->date()->comment('Дата рождения'),
            //------------------- Юридическое лицо ---------------------
            
            'org_name' => $this->string(255)->comment('Название организации'),
            'factual_address' => $this->text()->comment('Фактический адрес'),
            'mobile_phone' => $this->string(255)->comment('Мобильный номер для клиентов'),
            
            //----------------------------------------------------------
            

            
        ]);

        $this->insert('users',array(
            'fio' => 'Иванов Иван Иванович',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '+99899-999-99-99',
            'password' => Yii::$app->security->generatePasswordHash('admin'),
            'type' => 3,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
