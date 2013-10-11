<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Class responsible for rendering pages and working with the views
 */

class Editor extends Xreplace_Controller {

    private $category_id = array();
    private $buttons = array();
    private $info = '';

/********************************************
 *          Rendering editor web-page       *
 ********************************************/

    public function index()
    {
        /*
         * Header
         */
        
        $this->_load_header();
        
        /*
         * Category (left side)
         */

        $this->_load_category();

        /*
         * Result (textarea and result - right side)
         */

        $this->_load_result();
        
        /*
         * Footer (plus javascript)
         */

        $this->_load_footer();   
    }

    public function snapshot($snapshot_link = '') {

        $saved_link = $this->session->flashdata('link');

        $category_id = $this->category->get_category_id_by_link($snapshot_link);

        //if the flashdata link equals the link from the address bar then just render the main page
        if ($saved_link === $snapshot_link)
        {
           $this->index();
        }
        elseif ($category_id)
        {
            $this->category->copy_sample_category($this->_user->session_id, $category_id);

            $sample_category_data = $this->category->get_category_data($category_id, 'snapshot');

            if ( ! empty($sample_category_data['sample_text']))
            {
                $this->history->create_new_record();
                $this->history->set('text', $sample_category_data['sample_text']);
            }

            redirect(base_url('index.php/editor'));
            exit;
        }
        else
        {
             $this->not_found();
        }
    }

    public function faq()
    {
        $this->_render_page('faq', array());
    }
   
    /*
     * Rendering category
     */
    private function _load_category ()
    {
        /*
         * Category top
         */

        //Category buttons
        $this->buttons['category_buttons'] = array(
            'delete'                => '',
            'choose'                => '',
            'copy_sample'           => '',
            'edit'                  => '',
            'add_c'                 => '',
            'add_g'                 => '',
            'toggle_info'           => '',
            'toggle_global_groups'  => '',
            'toggle_stats'          => '',
            'category_download'     => '',
            'get_snapshot_link'     => ''
            );

        $this->category_id = $this->category->get_category_id($this->input->get_post('category_id'), $this->_user->session_id);

        $category_list = $this->category->get_category_list($this->_user->session_id);

        $category = $this->category->get_category_data($this->category_id, $this->_user->session_id);

        $this->info = ! empty($category['info']) ? $category['info'] : '';

        $global_groups_data = $this->category->get_global_groups_data($this->category_id, $this->_user->session_id);

        $local_groups_data = $this->category->get_groups_data($this->category_id, $this->_user->session_id);

        $groups_data = array_merge($global_groups_data, $local_groups_data);

        
        //if no category exists
        if ( ! $category_list)
        {
            $this->buttons['category_buttons']['choose']               = 'disabled';
            $this->buttons['category_buttons']['edit']                 = 'disabled';
            $this->buttons['category_buttons']['delete']               = 'disabled';
            $this->buttons['category_buttons']['add_g']                = 'disabled';
            $this->buttons['category_buttons']['toggle_info']          = 'disabled';
            $this->buttons['category_buttons']['toggle_global_groups'] = 'disabled';
        }

        //If selected category contains no data
        if ( ! $groups_data)
        {
            $this->buttons['category_buttons']['toggle_stats']          = 'disabled';
            $this->buttons['category_buttons']['get_snapshot_link']     = 'disabled';
        }
        
        /*
         * Loading one/or none of the forms
         */

        $action = $this->input->get('action');

        $form = '';

        switch ($action)
        {

            /*
            * Add category form
            */

            case 'add_category':

                $flash_data = $this->session->flashdata('flash_data');

                $this->buttons['category_buttons']['add_c'] = 'disabled';

                if ( ! $flash_data )
                {
                    $category_data = array(
                        'category_form_heading' => lang('category_add_form_heading'),
                        'category_action' => 'add_category',
                        'category_name' => '',
                        'category_info' => '',
                        'category_message' => '');
                }
                else
                {
                    $category_data = array(
                        'category_form_heading' => lang('category_add_form_heading'),
                        'category_action' => 'add_category',
                        'category_name' => $flash_data['category_name'],
                        'category_info' => $flash_data['category_info'],
                        'category_message' => $flash_data['category_message']);
                }



                $form = $this->load->view('editor/category_form', $category_data, true);
                break;

            /*
            * Edit category form
            */

            case 'update_category':

                $flash_data = $this->session->flashdata('flash_data');

                $this->buttons['category_buttons']['edit'] = 'disabled';


                if ( ! $flash_data )
                {
                    $category_data = array(
                    'category_form_heading' => lang('category_edit_form_heading'),
                    'category_action' => 'update_category',
                    'category_name' => $category['name'],
                    'category_info' => $category['info'],
                    'category_message' => '');

                }
                else
                {
                    $category_data = array(
                        'category_form_heading' => lang('category_edit_form_heading'),
                        'category_action' => 'update_category',
                        'category_name' => $flash_data['category_name'],
                        'category_info' => $flash_data['category_info'],
                        'category_message' => $flash_data['category_message']);
                }

                $form = $this->load->view('editor/category_form', $category_data, true);
                break;

            /*
             * Add group form
             */

            case 'add_group':

                $flash_data = $this->session->flashdata('flash_data');

                $this->buttons['category_buttons']['add_g'] = 'disabled';

                if ( ! $flash_data)
                {
                    $group_data = array(
                        'group_type' => 'expanded',
                        'group_name' => '',
                        'group_global' => '',
                        'group_message' => ''
                    );
                }
                else
                {
                    $group_data = $flash_data;
                }
                
                $group_data['group_id'] = '';
                $group_data['group_form_heading'] = lang('group_add_form_heading');
                $group_data['group_form_action'] = 'add_group';

                $form = $this->load->view('editor/group_form', $group_data, true);

                break;

            default:
                break;

        }

        /*
        * Loading groups
        */

        $groups = '';

        foreach ($groups_data as $group_data) {
            $groups .= $this->_load_group($group_data);
        }

        if ( ! $groups)
        {
            $this->buttons['category_buttons']['category_download'] = 'disabled';
        }

        //if not logged in and no data exists loading welcome page to the left panel
        if ( ! $this->ion_auth->logged_in() and ! $this->category_id and ! $form)
        {
            $groups = $this->load->view('editor/' . $this->config->item('language') . '/welcome', array(), true);
        }

        $data = array(
            'category_id'               => $this->category_id,
            'category_list'             => $category_list,
            'form'                      => $form,
            'groups'                    => $groups,
            'button_status'             => $this->buttons['category_buttons']
            );

        $this->load->view('editor/category', $data);       
    }

    /*
     * Rendering group
     */

    private function _load_group ($group)
    {

        //Group buttons
        $this->buttons['group_buttons'] = array(
            'apply'                 => '',
            'delete'                => '',
            'edit'                  => '',
            'add_r'                 => '',
            'global'                => ''
            );


        /*
         * Loading one or none of the forms
         */

        $action = $this->input->get('action');
        
        $form = '';

        /*
         * Group edit form
         */

        if ($action === 'edit_group' and $this->input->get('group') === $group['id'])
        {
            $flash_data = $this->session->flashdata('flash_data');

            $this->buttons['group_buttons']['edit'] = 'disabled';

            if ( ! $flash_data)
            {
                $group_data = array(
                    'group_id' => $group['id'],
                    'button_status' => $this->buttons['group_buttons'],
                    'group_type' => $group['type'],
                    'group_name' => $group['name'],
                    'group_global' => $group['global'],
                    'group_message' => ''
                );
            }
            else
            {
                $group_data = $flash_data;
            }
            $group_data['button_status'] = $this->buttons['group_buttons'];
            $group_data['group_form_heading'] = lang('group_edit_form_heading');
            $group_data['group_form_action'] = 'update_group';

            $form = $this->load->view('editor/group_form', $group_data, true);
        }

        /*
         * Rule add form
         */
        
        if ($action === 'add_rule' and $this->input->get('group') === $group['id'])
        {
            $flash_data = $this->session->flashdata('flash_data');
            
            $this->buttons['group_buttons']['add_r'] = 'disabled';

            if ( ! $flash_data)
            {
                $data = array(
                    'rule_type' => 'simple',
                    'rule_description' => '',
                    'rule_pattern' => '',
                    'rule_separator' => '~',
                    'rule_modifiers' => 'u',
                    'rule_replacement' => '',
                    'rule_message' => ''
                );
            }
            else
            {
                $data = array(
                    'rule_type' => $flash_data['rule_type'],
                    'rule_description' => $flash_data['rule_description'],
                    'rule_pattern' => $flash_data['rule_pattern'],
                    'rule_separator' => $flash_data['rule_separator'],
                    'rule_modifiers' => $flash_data['rule_modifiers'],
                    'rule_replacement' => $flash_data['rule_replacement'],
                    'rule_message' => $flash_data['rule_message']
                );
            }

            $data['group_id'] = $group['id']; 

            $form = $this->load->view('editor/rule_add_form', $data, true);
        }


        $rules = $this->group->get_rules_data($group['id']);

        $num_of_rules = count($rules);
        
        $group_stats = $num_of_rules ? '' : lang('group_empty');

        $group_title = ($group['global'] === 'global') ? lang('group_global_title') : '';

        //If no rules exist
        if ( ! $rules)
        {
            $this->buttons['group_buttons']['apply']      = 'disabled';
        }

        /*
         * Loading rules
         */

        switch ($group['type'])
        {
            case 'expanded':    $rules = $this->_load_expanded_rules($rules);
                break;
            //TODO: ordered insert
            case 'compact':     $rules = $this->_load_compact_rules($rules);
                break;
            default:            $rules = $this->_load_no_rules($rules);
                break;
        }

        //no need to show category name for local groups
        if ($group['global'] !== 'global')
        {
            $group['category_name'] = '';
        }

        $data = array(
            'form' => $form,
            'category_id' => $group['category_id'],
            'category_name' => $group['category_name'],
            'group_id' => $group['id'],
            'group_global' => $group['global'],
            'group_type' => $group['type'],
            'group_name' => $group['name'],
            'group_title' => $group_title,
            'group_stats' => $group_stats,
            'rules' => $rules,
            'button_status' => $this->buttons['group_buttons']
        );

        return $this->load->view('editor/group', $data, true);
    }
    
    /*
     * Rendering expanded rules
     */
    
    private function _load_expanded_rules ($rules_data)
    {
        $rules = '';

        foreach ($rules_data as $rule_data)
        {
             $rules .= $this->_load_rule($rule_data);
        }

        return $rules;
    }

    private function _load_rule($rule)
    {

        /*
         * Getting the statistics for the rule
         */

        $rule_used_ago = $this->editor->how_long_ago($rule['used_at']);

        if ($rule['times_used'] > 0 and $rule['total_time'] !== '0')
        {
            //TODO: set_locale globally and get rid of lang('dec_point')
            $rule_average_duration = 
                number_format(($rule['total_time']/$rule['times_used'] * 1000), 1, lang('dec_point'), '') . lang('ms');
            $rule_times_used = $rule['times_used'];
        }
        else
        {
            $rule_average_duration = '--';
            $rule_times_used = '--';
        }

        $data = array(
            'rule_id' => $rule['id'],
            'rule_order' => $rule['order'],
            'rule_times_used' => $rule_times_used,
            'rule_average_duration' => $rule_average_duration,
            'rule_used_ago' => $rule_used_ago,
            'rule_type' => $rule['type'],
            'rule_description' => $rule['description'],
            'rule_pattern' => $rule['pattern'],
            'rule_separator' => $rule['separator'],
            'rule_modifiers' => $rule['modifiers'],
            'rule_replacement' => $rule['replacement'],
            'rule_message' => ''
        );

        /*
         * Rule edit form
         */
        
        if ($this->input->get('action') === 'update_rule' and $this->input->get('rule') === $rule['id'])
        {
            $flash_data = $this->session->flashdata('flash_data');
            $group_id = $rule['group_id'];

            //group list is needed for making moving rules between groups possible
            $group_list = $this->group->get_group_list($this->category_id, $this->_user->session_id);

            if ($flash_data)
            {
                $data = array(
                    'rule_id' => $rule['id'],
                    'rule_order' => $rule['order'],
                    'rule_times_used' => $rule_times_used,
                    'rule_average_duration' => $rule_average_duration,
                    'rule_used_ago' => $rule_used_ago,
                    'rule_type' => $flash_data['rule_type'],
                    'rule_description' => $flash_data['rule_description'],
                    'rule_pattern' => $flash_data['rule_pattern'],
                    'rule_separator' => $flash_data['rule_separator'],
                    'rule_modifiers' => $flash_data['rule_modifiers'],
                    'rule_replacement' => $flash_data['rule_replacement'],
                    'rule_message' => $flash_data['rule_message']
                );
            }

            $data['group_id'] = $rule['group_id'];
            $data['group_list'] = $group_list;

            $rule_view = 'editor/rule_edit_form';
        }
        else
        {
            $rule_view = 'editor/rule';
        }

       return $this->load->view($rule_view, $data, true);
    }

    /*
     * Rendering compact rule list - just list of pattern - replacement pairs
     */
    private function _load_compact_rules ($rules_data)
    {
        return $this->load->view('editor/rule_list', array('rules_data' => $rules_data), true);
    }
    
    /*
     * For groups with hidden rules
     */
    private function _load_no_rules ($rules_data)
    {
        //TODO: maybe load some statistics
    }

    /*
     * Rendering result
     */
    private function _load_result ()
    {
        $this->buttons['result_buttons'] = array(
            'result_cancel'         => '',
            'result_reset_history'  => ''
        );

        $history_message = $this->session->flashdata('history_message');

        $console_message = '';

        $text = $this->history->get('text');
        
        $replace_flag = $this->history->get('replace_flag');

        if ($replace_flag)
        {            
            $group_name = $this->history->get('group_name');
            $benchmark_message = $this->history->get('benchmark') . ' сек.';
            $result = $this->history->get('result');
            
            if ($replace_flag === 'rule_replace')
            {
                $rule_order = $this->history->get('rule_order');
                if ($rule_order)
                {
                    $console_message = sprintf(lang('rule_rule_from_group'), $rule_order, $group_name);
                }
                else
                {
                    $console_message = lang('rule_new_rule');
                }
            }
            else
            {
                $console_message = lang('group_group') . ' "' . html_escape($group_name) . '"';
            }

        
            $result_list = $this->load->view('editor/result_list', array('result' => $result), true);

        }
        else
        {
            $benchmark_message = '';
            $console_message = '';
            $result_list = '';
        }

        //nothing to cancel if previous entry not exists
        if ( ! $this->history->previous_record_exists())
        {            
            $this->buttons['result_buttons']['result_cancel'] = 'disabled';
        }

        //nothing to reset if no current data exists
        if ( ! $this->history->current_record_exists())
        {
            $this->buttons['result_buttons']['result_reset_history'] = 'disabled';
        }

        //persentage of available memory used
        $memory_used = round(strlen(session_encode())/$this->config->item('max_memory_size')*100);


        $data = array(
                'text' => $text,
                'benchmark_message' => $benchmark_message,
                'console_message' => $console_message,
                'memory_used' =>  $memory_used < 100 ? $memory_used : 100,
                'history_message' => $history_message,
                'info' => $this->info,
                'result_list' => $result_list,
                'button_status' => $this->buttons['result_buttons']
        );

        $this->load->view('editor/result', $data);
    }

}