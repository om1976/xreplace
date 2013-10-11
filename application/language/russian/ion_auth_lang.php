<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - Russian (UTF-8)
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
* Translation:  Petrosyan R.
*             for@petrosyan.rv.ua
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.26.2010
*
* Description:  Russian language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Учетная запись успешно создана';
$lang['account_creation_unsuccessful'] 	 	 = 'Невозможно создать учетную запись';
$lang['account_creation_duplicate_email'] 	 = 'Электронная почта используется или некорректна';
$lang['account_creation_duplicate_username'] 	 = 'Имя пользователя существует или некорректно';

// Password
$lang['password_change_successful'] 	 	 = 'Пароль успешно изменен';
$lang['password_change_unsuccessful'] 	  	 = 'Пароль невозможно изменить';
$lang['forgot_password_successful'] 	 	 = 'Пароль сброшен. На электронную почту отправлен код восстановления пароля';
$lang['forgot_password_unsuccessful'] 	 	 = 'Невозможен сброс пароля. Проверьте правильность адреса эл. почты';

// Activation
$lang['activate_successful'] 		  	 = 'Учетная запись активирована. Переадресация...';
$lang['activate_unsuccessful'] 		 	 = 'Не удалось активировать учетную запись';
$lang['activate_unsuccessful_already_active']    = 'Учетная запись уже активирована';
$lang['deactivate_successful'] 		  	 = 'Учетная запись деактивирована';
$lang['deactivate_unsuccessful'] 	  	 = 'Невозможно деактивировать учетную запись';
$lang['activation_email_successful'] 	  	 = 'Сообщение об активации отправлено';
$lang['activation_email_unsuccessful']   	 = 'Сообщение об активации невозможно отправить';

// Activation Email
$lang['email_activation_subject']                = 'Активация учетной записи';
$lang['email_activate_heading']                  = 'Активация учетной записи';
$lang['email_activate_subheading']               = 'Чтобы активировать свою учетную запись, перейдите по следующей %s';
$lang['email_activate_link']                     = 'ссылке.';
$lang['email_activate_disclaimer']               = 'Если вы не регистрировались на сайте www.xreplace.com, проигнорируйте данное письмо. Спасибо.';

// Forgot Password Email
$lang['email_forgotten_password_subject']        = 'Forgotten Password Verification';
$lang['email_forgot_password_heading']           = 'Восстановление пароля';
$lang['email_forgot_password_subheading']        = 'Для того чтобы восстановить свой пароль, перейдите по этой %s.';
$lang['email_forgot_password_link']              = 'ссылке';
$lang['email_forgot_password_subheading_manual'] = 'В качестве альтернативы, вы можете ввести следующий код восстановления<br /><b><i>%s</i></b><br />вручную на странице восстановления пароля:<br />';

// New Password Email
$lang['email_new_password_subject']          = 'New Password';
$lang['email_new_password_heading']    = 'New Password for %s';
$lang['email_new_password_subheading'] = 'Your password has been reset to: %s';

// Login / Logout
$lang['login_successful'] 		  	 = 'Авторизация прошла успешно';
$lang['login_unsuccessful'] 		  	 = 'Логин/пароль не верен';
$lang['login_unsuccessful_not_active'] 		 = 'Учетная запись не активирована';
$lang['login_timeout']                           = 'Доступ временно отсутствует. Попробуйте еще раз.';
$lang['logout_successful'] 		 	 = 'Выход успешный';

// Account Changes
$lang['update_successful'] 		 	 = 'Учетная запись успешно обновлена';
$lang['update_unsuccessful'] 		 	 = 'Невозможно обновить учетную запись';
$lang['delete_successful'] 		 	 = 'Учетная запись удалена';
$lang['delete_unsuccessful'] 		 	 = 'Невозможно удалить учетную запись';

// Email Subjects - TODO Please Translate
$lang['email_forgotten_password_subject']    = 'Проверка забытого пароля';
$lang['email_new_password_subject']          = 'Новый пароль';