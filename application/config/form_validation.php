<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| EDITOR FORM VALIDATION
| -------------------------------------------------------------------------
| This file sets validation rules for editor forms
|
*/

$config = array(

    'category' => array(
        array(
                'field' => 'category_name',
                'label' => 'lang:category_name',
                'rules' => 'required|max_length[45]'
        ),
        array(
                'field' => 'category_info',
                'label' => 'lang:category_info',
                'rules' => 'max_length[10000]'
        ),
    ),

    'group' => array(
        array(
                'field' => 'group_name',
                'label' => 'lang:group_name',
                'rules' => 'required|max_length[45]'
        ),
    ),

    'rule' => array(
        array(
                'field' => 'text',
                'label' => 'lang:result_text',
                'rules' => 'max_length[50000]'
        ),
        array(
                'field' => 'rule_type',
                'label' => 'lang:rule_type',
                'rules' => 'required'
        ),
        array(
                'field' => 'rule_description',
                'label' => 'lang:rule_description',
                'rules' => 'max_length[100]'
        ),
        array(
                'field' => 'rule_separator',
                'label' => 'lang:rule_separator',
                'rules' => 'max_length[1]'
        ),
        array(
                'field' => 'rule_modifiers',
                'label' => 'lang:rule_modifiers',
                'rules' => 'max_length[11]'
        ),
        array(
                'field' => 'rule_pattern',
                'label' => 'lang:rule_pattern',
                'rules' => 'max_length[50000]|callback_validate_rule_pattern'
        ),
        array(
                'field' => 'rule_replacement',
                'label' => 'lang:rule_replacement',
                'rules' => 'max_length[200]'
        ),
    ),
    
    'apply_rule' => array(
        array(
                'field' => 'text',
                'label' => 'lang:result_text',
                'rules' => 'max_length[50000]'
        ),
    )
);


/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */
