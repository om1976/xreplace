<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Editor Lang - English
*
* Author: Oleksandr Melnyk
* 		  oleksandr.melnyk@gmail.com
*         @o_melnyk
*
* Location: http://github.com/___
*
* Created:  29.08.2013
*
* Description:  English language file for X-replace editor views
*
*/

// Header

$lang['header_language_button_title']       = 'Переключиться на русский';
$lang['header_language_button_text']        = 'Рус';
$lang['header_language']                    = 'Language: Eng';
$lang['header_auth_login']                  = 'Login/Sign up';
$lang['header_auth_logout']                 = 'Logout';

//Page

$lang['page_not_found']                     = 'Page not found';
// Category

$lang['category_label']                     = 'Category';
$lang['category_name']                      = 'Category name';
$lang['category_info']                      = 'Info';
$lang['category_add_button_title']          = 'New category';
$lang['category_add_button_text']           = 'C';
$lang['category_add_form_heading']          = 'New category';
$lang['category_edit_form_heading']         = 'Edit category';
$lang['category_edit_button_title']         = 'Edit category';
$lang['category_delete_button_title']       = 'Delete category';
$lang['category_choose_button_title']       = 'Select category';
$lang['category_show_info']                 = 'Show info';
$lang['category_hide_info']                 = 'Hide info';
$lang['category_show_stats']                = 'Show stats';
$lang['category_hide_stats']                = 'Hide stats';
$lang['category_show_global_groups']        = 'Show global groups';
$lang['category_hide_global_groups']        = 'Hide global groups';
$lang['category_copy_sample']               = 'Copy sample category';
$lang['category_empty_placeholder']         = 'No categories yet...';
$lang['category_save']                      = 'Save category and close';
$lang['category_save_data']                 = 'Save my data';
$lang['category_download']                  = 'Download rules as txt';
$lang['category_confirm_delete']            = 'All corresponding groups and rules will also be deleted. Are you sure?';
$lang['category_highlight_result']          = 'Show whitespaces and linebreaks';
$lang['category_get_snapshot_link']         = 'Category snapshot';

// Group

$lang['group_add_button_title']             = 'New group';
$lang['group_group']                        = 'Group';
$lang['group_add_button_text']              = 'G';
$lang['group_add_form_heading']             = 'New group';
$lang['group_edit_form_heading']            = 'Edit group';
$lang['group_delete_button_title']          = 'Delete group';
$lang['group_show_global_label']            = 'Show global groups';
$lang['group_hide_global_label']            = 'Hide global groups';
$lang['group_name_label']                   = 'Group name:';
$lang['group_global_title']                 = 'Global group';
$lang['group_apply']                        = 'Apply group';
$lang['group_edit']                         = 'Edit group';
$lang['group_delete']                       = 'Delete group';
$lang['group_save']                         = 'Save changes and close';
$lang['group_type_expanded']                = 'Expanded rules';
$lang['group_type_compact']                 = 'Compact rules';
$lang['group_type_norules']                 = 'Hidden rules';
$lang['group_confirm_delete']               = 'All corresponding rules will also be deleted. Are you sure?';
$lang['group_empty']                        = 'This group has no rules';

//Rule

$lang['rule_edit_form_apply']               = 'Apply rule without saving';
$lang['rule_save']                          = 'Save rule';
$lang['rule_form_close']                    = 'Close the form without saving';
$lang['rule_description']                   = 'Description';
$lang['rule_delimiter_and_modifiers']       = 'Delimiter and modifiers';
$lang['rule_pattern']                       = 'Pattern';
$lang['rule_replacement']                   = 'Replacement';
$lang['rule_apply']                         = 'Apply rule';
$lang['rule_edit']                          = 'Edit rule';
$lang['rule_edit_form_heading']             = 'Rule amendment';
$lang['rule_delete']                        = 'Delete rule';
$lang['rule_add']                           = 'New rule';
$lang['rule_order_sign']                    = 'No.';
$lang['rule_add_form_heading']              = 'New rule';
$lang['rule_pattern_empty']                 = 'The Pattern field can not be empty';
$lang['rule_pattern_invalid']               = 'Invalid pattern';
$lang['rule_modifiers_invalid']             = 'Invalid modifiers. Allowed PCRE modifiers: imsxuADSUXJ. No duplicates allowed';
$lang['rule_delimiter_invalid']             = 'Invalid delimiter. A delimiter can be any non-alphanumeric, non-backslash, non-whitespace character';
$lang['rule_stats_reset']                   = 'Reset stats';
$lang['rule_new']                           = 'New';
$lang['rule_new_rule']                      = 'New rule';
$lang['rule_applied_success']               = 'Rule has been applied successfully';
$lang['rule_rule_from_group']               = 'Rule No.%d from group "%s"';
$lang['rule_simple']                        = 'simple';
$lang['rule_regex']                         = 'regex';

//Result
$lang['result_cancel']                      = 'Cancel';
$lang['result_line_rule']                   = 'Rule No.';
$lang['result_line_found']                  = 'Found';
$lang['result_line_replaced']               = 'Replaced with';
$lang['result_line_total']                  = '&Sigma;';
$lang['result_history_been_reset']          = 'History reset';
$lang['result_last_action_cancelled']       = 'Last replacement action cancelled';
$lang['result_no_match']                    = 'No match';
$lang['result_byte']                        = 'B';

// Register

$lang['register_heading']                   = 'Sign up';
$lang['register_login']                     = 'Login';
$lang['register_password']                  = 'Password';
$lang['register_email']                     = 'E-mail';
$lang['register_submit']                    = 'Sign up!';
$lang['register_success_message']           = 'You\'ve been successfully registered! Redirecting to homepage...';


// Login

$lang['login_heading']                      = 'Log in';
$lang['login_login']                        = 'Login';
$lang['login_password']                     = 'Password';
$lang['login_remember']                     = 'Remember me';
$lang['login_submit']                       = 'Enter';
$lang['login_wanna_signup']                 = 'Sign up';
$lang['login_forgot_password']              = 'Forgot password';
$lang['login_save_data_info']               = 'Check this checkbox if you have already created any categories/groups/rules and wish to save them';

//Forgot password
$lang['forgot_password_heading']            = 'Password restore';
$lang['forgot_password_email_label']        = 'Enter your email:';
$lang['forgot_password_code_label']         = 'Enter reset password code:';
$lang['forgot_password_no_code']            = 'You have not entered the password code';
$lang['forgot_password_code_invalid']       = 'The password code you entered is invalid';
$lang['forgot_password_new_label']          = 'Enter new password:';


//Datetime
$lang['year']                               = 'year';
$lang['years1']                             = 'years';
$lang['years2']                             = 'years';
$lang['month']                              = 'month';
$lang['months1']                            = 'months';
$lang['months2']                            = 'months';
$lang['week']                               = 'week';
$lang['weeks1']                             = 'weeks';
$lang['weeks2']                             = 'weeks';
$lang['day']                                = 'day';
$lang['days1']                              = 'days';
$lang['days2']                              = 'days';
$lang['today']                              = 'today';
$lang['ms']                                 = ' ms';
$lang['dec_point']                          = '.';
$lang['ago']                                = ' ago';
$lang['jan']                                = 'January';
$lang['feb']                                = 'February';
$lang['mar']                                = 'March';
$lang['apr']                                = 'April';
$lang['may']                                = 'May';
$lang['jun']                                = 'June';
$lang['jul']                                = 'July';
$lang['aug']                                = 'August';
$lang['sep']                                = 'September';
$lang['oct']                                = 'October';
$lang['nov']                                = 'November';
$lang['dec']                                = 'December';

//Common
$lang['common_and']                         = 'and';
$lang['back_to_top']                        = 'Back to top';