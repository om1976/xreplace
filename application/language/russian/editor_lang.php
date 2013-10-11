<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Editor Lang - Russian
*
* Author: Oleksandr Melnyk
* 		  oleksandr.melnyk@gmail.com
*         @o_melnyk
*
* Location: http://github.com/___
*
* Created:  29.08.2013
*
* Description:  Russian language file for X-replace editor views
*
*/

// Header

$lang['header_language_button_title']       = 'View in English';
$lang['header_language_button_text']        = 'Eng';
$lang['header_language']                    = 'Язык: Рус';
$lang['header_auth_login']                  = 'Вход/регистрация';
$lang['header_auth_logout']                 = 'Выход';

//Page

$lang['page_not_found']                     = 'Страница не найдена';

// Category

$lang['category_label']                     = 'Категория';
$lang['category_name']                      = 'Название категории';
$lang['category_info']                      = 'Информация';
$lang['category_add_button_title']          = 'Добавить категорию';
$lang['category_add_button_text']           = 'К';
$lang['category_add_form_heading']          = 'Новая категория';
$lang['category_edit_form_heading']         = 'Изменение категории';
$lang['category_edit_button_title']         = 'Редактировать категорию';
$lang['category_delete_button_title']       = 'Удалить категорию';
$lang['category_choose_button_title']       = 'Выбрать категорию';
$lang['category_show_info']                 = 'Показать информацию';
$lang['category_hide_info']                 = 'Скрыть информацию';
$lang['category_show_stats']                = 'Показать статистику';
$lang['category_hide_stats']                = 'Скрыть статистику';
$lang['category_show_global_groups']        = 'Показать общие группы';
$lang['category_hide_global_groups']        = 'Скрыть общие группы';
$lang['category_copy_sample']               = 'Скопировать категорию-образец';
$lang['category_empty_placeholder']         = 'Категорий еще нет...';
$lang['category_save']                      = 'Сохранить и закрыть';
$lang['category_save_data']                 = 'Сохранить мои данные';
$lang['category_download']                  = 'Скачать правила в формате txt';
$lang['category_confirm_delete']            = 'Все соответствующие группы и правила также будут удалены. Удалить?';
$lang['category_highlight_result']          = 'Показывать пробелы и переносы строк';
$lang['category_get_snapshot_link']         = 'Создать снимок категории';

// Group

$lang['group_add_button_title']             = 'Добавить группу';
$lang['group_group']                        = 'Группа';
$lang['group_add_button_text']              = 'Г';
$lang['group_add_form_heading']             = 'Новая группа';
$lang['group_edit_form_heading']            = 'Редактирование группы';
//$lang['group_delete_button_title']          = 'Удалить группу';
$lang['group_show_global_label']            = 'Показать общие группы';
$lang['group_hide_global_label']            = 'Скрыть общие группы';
$lang['group_name_label']                   = 'Название группы:';
$lang['group_global_title']                 = 'Общая группа';
$lang['group_apply']                        = 'Применить группу';
$lang['group_edit']                         = 'Редактировать группу';
$lang['group_delete']                       = 'Удалить группу';
$lang['group_save']                         = 'Сохранить и закрыть форму';
$lang['group_type_expanded']                = 'Развернутые правила';
$lang['group_type_compact']                 = 'Правила списком';
$lang['group_type_norules']                 = 'Скрытые правила';
$lang['group_confirm_delete']               = 'Все соответствующие правила также будут удалены. Удалить?';
$lang['group_empty']                        = 'У этой группы правил нет';


//Rule

$lang['rule_edit_form_apply']               = 'Применить правило, не сохраняя';
$lang['rule_save']                          = 'Сохранить правило и закрыть форму';
$lang['rule_description']                   = 'Описание';
$lang['rule_delimiter_and_modifiers']       = 'Разделители и модификаторы';
$lang['rule_pattern']                       = 'Искомый шаблон';
$lang['rule_replacement']                   = 'Замена';
$lang['rule_apply']                         = 'Применить правило';
$lang['rule_edit']                          = 'Редактировать правило';
$lang['rule_edit_form_heading']             = 'Изменение правила';
$lang['rule_delete']                        = 'Удалить правило';
$lang['rule_add']                           = 'Добавить правило';
$lang['rule_order_sign']                    = '№';
$lang['rule_add_form_heading']              = 'Новое правило';
$lang['rule_pattern_empty']                 = 'Шаблон не может быть пустым.';
$lang['rule_pattern_invalid']               = 'Шаблон содержит ошибки.';
$lang['rule_modifiers_invalid']             = 'Модификаторы некорректны либо дублируются. Разрешенные модификаторы PCRE: imsxuADSUXJ';
$lang['rule_delimiter_invalid']             = 'Некорректный разделитель. Разделителем может быть любой символ, не являющийся буквой, цифрой, обратной косой чертой или пробельным символом';
$lang['rule_new']                           = 'Новое';
$lang['rule_new_rule']                      = 'Новое правило';
$lang['rule_applied_success']               = 'Правило применено успешно';

$lang['rule_stats_reset']                   = 'Сбросить статистику';
$lang['rule_rule_from_group']               = 'Правило №%d группы "%s"';
$lang['rule_simple']                        = 'простое';
$lang['rule_regex']                         = 'рег.выражение';

//Result
$lang['result_cancel']                      = 'Отменить';
$lang['result_line_rule']                   = '№ правила';
$lang['result_line_found']                  = 'Найдено';
$lang['result_line_replaced']               = 'Заменено на';
$lang['result_line_total']                  = '&Sigma;';
$lang['result_history_been_reset']          = 'История сброшена';
$lang['result_last_action_cancelled']       = 'Последнее действие отменено';
$lang['result_no_match']                    = 'Совпадений нет';
$lang['result_byte']                        = 'Б';

// Register

$lang['register_heading']                   = 'Регистрация';
$lang['register_login']                     = 'Логин';
$lang['register_password']                  = 'Пароль';
$lang['register_email']                     = 'Эл.почта';
$lang['register_submit']                    = 'Зарегистрироваться';
$lang['register_success_message']           = 'Вы успешно зарегистрированы! Перенаправление на главную...';

// Login

$lang['login_heading']                      = 'Вход';
$lang['login_login']                        = 'Логин';
$lang['login_password']                     = 'Пароль';
$lang['login_remember']                     = 'Запомнить';
$lang['login_submit']                       = 'Войти';
$lang['login_wanna_signup']                 = 'Регистрация';
$lang['logout_button']                      = 'Log out';
$lang['login_forgot_password']              = 'Забыли пароль?';
$lang['login_save_data_info']               = 'Если вы уже создали какие-либо категории, группы или правила, и хотите их сохранить, отметьте этот флажок';

//Forgot password
$lang['forgot_password_heading']            = 'Восстановление пароля';
$lang['forgot_password_email_label']        = 'Введите адрес вашей эл. почты:';
$lang['forgot_password_code_label']         = 'Введите код восстановления пароля:';
$lang['forgot_password_no_code']            = 'Вы не ввели код восстановления пароля';
$lang['forgot_password_code_invalid']       = 'Введенный код восстановления пароля недействителен';
$lang['forgot_password_new_label']          = 'Введите новый пароль:';

// Form


$lang['form_close']                         = 'Закрыть форму, не сохраняя';

//Date
$lang['year']                               = 'год';
$lang['years1']                             = 'года';
$lang['years2']                             = 'лет';
$lang['month']                              = 'месяц';
$lang['months1']                            = 'месяца';
$lang['months2']                            = 'месяцев';
$lang['week']                               = 'неделя';
$lang['weeks1']                             = 'недели';
$lang['weeks2']                             = 'недель';
$lang['day']                                = 'день';
$lang['days1']                              = 'дня';
$lang['days2']                              = 'дней';
$lang['today']                              = 'сегодня';
$lang['ms']                                 = ' мс';
$lang['dec_point']                          = ',';
$lang['ago']                                = ' назад';
$lang['jan']                                = 'января';
$lang['feb']                                = 'февраля';
$lang['mar']                                = 'марта';
$lang['apr']                                = 'апреля';
$lang['may']                                = 'мая';
$lang['jun']                                = 'июня';
$lang['jul']                                = 'июля';
$lang['aug']                                = 'августа';
$lang['sep']                                = 'сентября';
$lang['oct']                                = 'октября';
$lang['nov']                                = 'ноября';
$lang['dec']                                = 'декабря';



//Common
$lang['common_and']                         = 'и';
$lang['back_to_top']                        = 'К началу';
