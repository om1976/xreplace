<?php

class Editor_actions extends Xreplace_Controller {

    /********************************************
    *               Actions router              *
    ********************************************/

    public function action()
    {
        //Bot check
        if ($this->input->post('areyouabot'))
        {
            redirect(base_url('index.php/editor'));
        }

        $data = explode('/', $this->input->post('action'));

        $action = array_shift($data);

        $args = empty($data) ? array() : $data;

        //Not set $_POST['text'] means that this is AJAX request, so no need to rewrite the history
        if (isset($_POST['text']))
        {
            $this->history->set('text', $this->input->post('text'));
        }

        if (strlen(session_encode()) > $this->config->item('max_memory_size') and $action !== 'cancel')
        {
            $this->session->set_flashdata('history_message', 'Memory leak! To proceed clean the history, please');
            $this->cancel();
            exit;
        }


        if (! empty($action) and method_exists($this, $action))
        {
            call_user_func_array(array($this, $action), $args);
        }
        else
        {
            //TODO: not found page
            redirect(base_url('index.php/editor/not_found'));
        }
    }

     /***********************************
     *         Common actions           *
     ***********************************/

    public function toggle_language()
    {
        $new_language = $this->input->cookie('lang') === 'russian' ? 'english' : 'russian';
        setcookie('lang', $new_language, time() + 315360000, '/');

        $path = $this->input->cookie('path');
        setcookie('path', '', time() - 1000000, '/');

        $uri = $path ? $path : base_url('index.php/editor');

        redirect($uri);
    }

     /***********************************
     *         Category actions         *
     ***********************************/

    private function select_category()
    {
        $category_id = $this->category->get_category_id($this->input->post('category_id'), $this->_user->session_id);

        $uri = $category_id ? '?category_id='. $category_id : '';

        redirect(base_url('index.php/editor' . $uri));
    }

    private function open_add_category_form()
    {
        redirect(base_url('index.php/editor?action=add_category'));
    }

    private function open_update_category_form()
    {
        redirect(base_url('index.php/editor?action=update_category'));
    }

    private function open_add_group_form()
    {
        redirect(base_url('index.php/editor?action=add_group'));
    }

    private function open_update_group_form($group_id)
    {
        redirect(base_url('index.php/editor?action=edit_group&group=' . $group_id . '#group-' . $group_id));
    }

    private function open_add_rule_form($group_id)
    {
        redirect(base_url('index.php/editor?action=add_rule&group=' . $group_id . '#group-' . $group_id));
    }

    private function open_update_rule_form($rule_id)
    {
        redirect(base_url('index.php/editor?action=update_rule&rule=' . $rule_id . '#' . $rule_id));
    }

    private function close_form()
    {
        redirect(base_url('index.php/editor'));
    }

    private function add_category()
    {
        $category_name = $this->input->post('category_name');
        $category_info = $this->input->post('category_info');

        if ($this->form_validation->run('category') === true)
        {
            $category_id = $this->category->add_category($category_name, $category_info, $this->_user->session_id);

            redirect(base_url('index.php/editor?category_id=' . $category_id));
        }
        else
        {
            $category = array(
                'category_name' => $category_name,
                'category_info' => $category_info,
                'category_message' => validation_errors(),
            );

            $this->session->set_flashdata('flash_data', $category);

            redirect(base_url('index.php/editor?action=add_category'));
        }
    }

    private function update_category()
    {
        $category_id = (int)$this->input->post('category_id');
        $category_name = $this->input->post('category_name');
        $category_info = $this->input->post('category_info');

        if ($this->form_validation->run('category') === true)
        {
            $this->category->update_category($category_id, $category_name, $category_info, $this->_user->session_id);

            redirect(base_url('index.php/editor?category=' . $category_id));
        }
        else
        {
            $category = array(
                'category_name' => $category_name,
                'category_info' => $category_info,
                'category_message' => validation_errors(),
            );

            $this->session->set_flashdata('flash_data', $category);

            redirect(base_url('index.php/editor?action=update_category'));
        }
    }


    private function delete_category() {
        $category_id = (int)$this->input->post('category_id');

        if ($category_id)
        {
            $this->category->delete_category($category_id, $this->_user->session_id);
        }

        redirect(base_url('index.php/editor'));
    }

    private function make_category_snapshot($category_id)
    {
        $link = sha1($category_id . microtime());

        $sample_text = $this->input->post('text');

        if ($this->category->make_category_snapshot($category_id, $link, $this->_user->session_id, $sample_text))
        {
            $this->session->set_flashdata('link', $link);
            redirect(base_url('index.php/editor/snapshot/' . $link));
        }
        else
        {
            redirect(base_url('index.php/editor/not_found'));
        }
    }

    protected function copy_sample_category()
    {
        $this->category->copy_sample_category($this->_user->session_id, $this->config->item('sample_category'));

        $sample_category_data = $this->category->get_category_data($category_id, 'snapshot');

        if ( ! empty($sample_category_data['sample_text']))
        {
            $this->history->create_new_record();
            $this->history->set('text', $sample_category_data['sample_text']);
        }

        redirect(base_url('index.php/editor'));
        exit;
    }

    //TODO: move russian text to lang files, add corresponding eng text to lang files
    public function download_categories()
    {
        if ($categories = $this->category->get_categories($this->_user->session_id) and is_array($categories))
        {
            $out = '';

            foreach($categories as $i => $rule)
            {
                if( ! isset($categories[$i-1]['cname']) or $categories[$i-1]['cname'] !== $categories[$i]['cname'])
                {
                    $out .= "        /******************** ";
                    $out .= "  " . $categories[$i]['cname'];
                    $out .= "  *********************/\r\n\r\n";
                    $out .= "    // " . $categories[$i]['gname'];
                    $out .= "\r\n\r\n";
                }
                elseif ($categories[$i-1]['cname'] === $categories[$i]['cname'] and $categories[$i-1]['gname'] !== $categories[$i]['gname'])
                {
                    $out .= "    // " . $categories[$i]['gname'];
                    $out .= "\r\n\r\n";
                }

                $out .= "# Описание правила:\r\n";
                $out .= $rule['description'];
                $out .= "\r\n";

                $out .= "# Тип правила:\r\n";
                $out .= $rule['type'] === 'regex' ? 'регулярное выражение' : 'простое';
                $out .= "\r\n";

                if ($rule['type'] === 'regex')
                {
                    $out .= "# Шаблон:\r\n";
                    $out .= "'" . $rule['separator'] . $rule['pattern'] . $rule['separator'] . $rule['modifiers'] . "'";
                    $out .= "\r\n";
                }
                else
                {
                    $out .= "# Шаблон:\r\n";
                    $out .= "'" . $rule['pattern'] . "'";
                    $out .= "\r\n";
                }

                $out .= "# Замена:\r\n";
                $out .= "'" . $rule['replacement'] . "'";
                $out .= "\r\n\r\n";
            }

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=regex_backup.txt');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($out));

            echo $out;
        }
    }

    /***********************************
     *           Group actions          *
     ***********************************/

    public function apply_group($group_id)
    {
        if ( ! $this->group->group_exists($group_id, $this->_user->session_id))
        {
            redirect(base_url('index.php/editor'));
            exit;
        }
        else
        {
            $rules = $this->group->get_rules_data($group_id);

            if ( ! $rules or ! is_array($rules))
            {
                redirect(base_url('index.php/editor'));
                exit;
            }

            $this->form_validation->set_rules('text', 'lang:result_text', 'max_length[50000]');

            if ($this->form_validation->run() !== TRUE)
            {
                $this->session->set_flashdata('history_message', 'Text too long. Please limit it to 50&nbsp;000 bytes');
                $this->cancel();
                exit;
            }

            $text = $this->input->post('text');
            $group = $this->group->get_group_data($group_id, $this->_user->session_id);


            $this->benchmark->mark('apply_group_start');

            $this->history->create_new_record();
            $this->history->set('text', $text);

            foreach ($rules as $rule)
            {
                if (strlen(session_encode()) > $this->config->item('max_memory_size'))
                {
                    $this->session->set_flashdata('history_message', 'Memory leak! To proceed clean the history, please');
                    $this->cancel();
                    exit;
                }

                if ($rule['type'] === 'regex')
                {
                    //echo $rule['id'] . '!!!!!<br/>';


                    $this->rule->apply_regex_rule(
                        $rule['separator'],
                        $rule['modifiers'],
                        $rule['pattern'],
                        str_replace(array('\r\n', '\n', '\r'), array("\r\n", "\n", "\r"), $rule['replacement']),
                        $rule['id'],
                        $rule['order'],
                        $group['name']
                    );
                }
                else
                {
                    $this->rule->apply_simple_rule(
                        $rule['pattern'],
                        $rule['replacement'],
                        $rule['id'],
                        $rule['order'],
                        $group['name']
                    );
                }

                //exit;

            }

            $this->benchmark->mark('apply_group_end');
            $benchmark = $this->benchmark->elapsed_time('apply_group_start', 'apply_group_end');
            $this->history->set('benchmark', number_format($benchmark, 4 , ',', ''));
            $this->history->set('replace_flag', 'group_replace');

            redirect(base_url('index.php/editor?#group-' . $group_id));
        }

    }

    private function add_group()
    {
        $category_id = (int)$this->input->post('category_id');
        $group_type = $this->input->post('group_type');
        $group_global = $this->input->post('group_global') === 'global' ? 'global' : NULL;
        $group_name = $this->input->post('group_name');

        switch ($group_type) {
            case 'compact':
                break;

            case 'norules':
                break;

            default:
                $group_type = 'expanded';
                break;
        }

        if ($this->form_validation->run('group') === true)
        {
            $group_id = $this->category->add_group($category_id, $group_type, $group_global, $group_name, $this->_user->session_id);
            redirect(base_url('index.php/editor#group-' . $group_id));
        }
        else
        {
            $group = array(
                'group_type' => $group_type,
                'group_global' => $group_global,
                'group_name' => $group_name,
                'group_message' => validation_errors(),
            );

            $this->session->set_flashdata('flash_data', $group);

            redirect(base_url('index.php/editor?action=add_group'));
        }

    }
    
    private function update_group()
    {
        $group_id = (int)$this->input->post('group_id');
        $group_type = $this->input->post('group_type');
        $group_global = $this->input->post('group_global') === 'global' ? 'global' : NULL;
        $group_name = $this->input->post('group_name');

        switch ($group_type) {
            case 'compact':
                break;

            case 'norules':
                break;

            default:
                $group_type = 'expanded';
                break;
        }

        if ($this->form_validation->run('group') === true)
        {
            $group_data = $this->group->get_group_data($group_id, $this->_user->session_id);

            if ($group_data)
            {
                $this->group->update_group($group_id, $group_type, $group_global, $group_name, $this->_user->session_id);
            }
            redirect(base_url('index.php/editor#group-' . $group_id));
        }
        else
        {
            $group = array(
                'group_id'   => $group_id,
                'group_type' => $group_type,
                'group_global' => $group_global,
                'group_name' => $group_name,
                'group_message' => validation_errors(),
            );

            $this->session->set_flashdata('flash_data', $group);

            redirect(base_url('index.php/editor?action=edit_group&group=' . $group_id . '#group-' . $group_id));
        }

    }

    private function delete_group($group_id) {

        $group_id = (int)$group_id;

        if ($group_id)
        {
            $this->group->delete_group($group_id, $this->_user->session_id);
        }

        redirect(base_url('index.php/editor'));
    }



     /***********************************
     *          Rule actions            *
     ***********************************/

    //called via Ajax
    public function test_regex_rule()
    {
        error_reporting(E_ALL);

        $regex = htmlspecialchars_decode($this->input->post('regex'));

        preg_match($regex, '');
    }

    private function get_rule_data($rule_id)
    {
        $rule = $this->rule->get_rule_data($rule_id, $this->_user->session_id);

        print json_encode($rule, JSON_UNESCAPED_UNICODE);

    }

    public function apply_rule($rule_id)
    {
        if ($this->form_validation->run('apply_rule') !== TRUE)
        {
            $this->session->set_flashdata('history_message', validation_errors());

            $this->cancel();
            exit;
        }

        $text = $this->input->post('text');
        $rule = $this->rule->get_rule_data($rule_id, $this->_user->session_id);
        $group = $this->group->get_group_data($rule['group_id'], $this->_user->session_id);

        $uri = '';

        if ( ! empty($rule))
        {

            $this->history->create_new_record();
            $this->history->set('text', $text);


            if ($rule['type'] === 'regex')
            {
                $this->rule->apply_regex_rule(
                    $rule['separator'],
                    $rule['modifiers'],
                    $rule['pattern'],
                    str_replace(array('\r\n', '\n', '\r'), array("\r\n", "\n", "\r"), $rule['replacement']),
                    $rule['id'],
                    $rule['order'],
                    $group['name']
                );
            }
            else
            {
                $this->rule->apply_simple_rule(
                    $rule['pattern'],
                    $rule['replacement'],
                    $rule['id'],
                    $rule['order'],
                    $group['name'],
                    $rule['id']
                );
            }

            $this->history->set('replace_flag', 'rule_replace');


            $uri = '?#' . $rule_id;
        }

        redirect(base_url('index.php/editor' . $uri));
    }

    /*
     * Applying rule form without saving - to test the rule (either being edited or added)
     */
    private function apply_rule_form($form_type = 'add', $id = null)
    {
        //form type - add ($id = rule id), update ($id = group id)

        if ($form_type === 'update')
        {
            $uri = 'index.php/editor?action=update_rule&rule=' . $id . '#' . $id;
        }
        else
        {
            $uri = 'index.php/editor?action=add_rule&group=' . $id . '#group-' . $id;
        }

        $rule_message = '';

        $group_id = $this->input->post('group_id');
        $rule_id = $this->input->post('rule_id');
        $rule_type = $this->input->post('rule_type');
        $rule_description = $this->input->post('rule_description');
        $rule_separator = $this->input->post('rule_separator');
        $rule_modifiers = $this->input->post('rule_modifiers');
        $rule_pattern = $this->input->post('rule_pattern');
        $rule_replacement = $this->input->post('rule_replacement');
        $rule_order = $this->input->post('rule_order');
        $text = $this->input->post('text');

        if ($this->form_validation->run('rule') === true)
        {
            $this->history->create_new_record();
            $this->history->set('text', $text);

            if ($rule_type === 'regex')
            {
                $this->rule->apply_regex_rule(
                    $rule_separator,
                    $rule_modifiers,
                    $rule_pattern,
                    str_replace(array('\r\n', '\n', '\r'), array("\r\n", "\n", "\r"), $rule_replacement),
                    $rule_id,
                    $rule_order
                );
            }
            else
            {
                $this->rule->apply_simple_rule(
                    $rule_pattern,
                    $rule_replacement,
                    $rule_id,
                    $rule_order
                );
            }

            $this->history->set('replace_flag', 'rule_replace');

            $rule_message = '';
        }
        else
        {
            $rule_message = validation_errors();
        }

        $data = array(
            'group_id' => $group_id,
            'rule_id' => $rule_id,
            'rule_type' => $rule_type,
            'rule_description' => $rule_description,
            'rule_separator' => $rule_separator,
            'rule_modifiers' => $rule_modifiers,
            'rule_pattern' => $rule_pattern,
            'rule_replacement' => $rule_replacement,
            'rule_message' => $rule_message
        );

        $this->session->set_flashdata('flash_data', $data);


        redirect(base_url($uri), 'refresh');
    }


    private function add_rule($group_id)
    {
        if ( ! $this->group->group_exists($group_id, $this->_user->session_id))
        {
            redirect(base_url('index.php/editor'));
            exit;
        }

        $rule_message = '';

        $rule_type = $this->input->post('rule_type');
        $rule_description = $this->input->post('rule_description');
        $rule_separator = $this->input->post('rule_separator');
        $rule_modifiers = $this->input->post('rule_modifiers');
        $rule_pattern = $this->input->post('rule_pattern');
        $rule_replacement = $this->input->post('rule_replacement');

        if ($this->form_validation->run('rule') == true)
        {
            $rule_id = $this->rule->add_rule(
                $group_id,
                $rule_type,
                $rule_description,
                $rule_separator,
                $rule_modifiers,
                $rule_pattern,
                $rule_replacement,
                $this->_user->session_id
            );

            redirect(base_url('index.php/editor#' . $rule_id), 'refresh');
        }
        else
        {
            $rule_message = validation_errors();
        }

        $data = array(
            'rule_type' => $rule_type,
            'rule_description' => $rule_description,
            'rule_separator' => $rule_separator,
            'rule_modifiers' => $rule_modifiers,
            'rule_pattern' => $rule_pattern,
            'rule_replacement' => $rule_replacement,
            'rule_message' => $rule_message
        );

        $this->session->set_flashdata('flash_data', $data);

        redirect(base_url('index.php/editor?action=add_rule&group=' . $group_id . '#group-' . $group_id));
    }

    private function update_rule($rule_id)
    {
        $group_id = $this->input->post('group_id');

        if ( ! $this->group->group_exists($group_id, $this->_user->session_id))
        {
            redirect(base_url('index.php/editor'));
            exit;
        }

        $rule_message = '';

        $rule_id = $this->input->post('rule_id');
        $rule_type = $this->input->post('rule_type');
        $rule_description = $this->input->post('rule_description');
        $rule_separator = $this->input->post('rule_separator');
        $rule_modifiers = $this->input->post('rule_modifiers');
        $rule_pattern = $this->input->post('rule_pattern');
        $rule_replacement = $this->input->post('rule_replacement');

        if ($this->form_validation->run('rule') == true)
        {
            if ($this->rule->get_rule_group($rule_id) === $group_id)
            {
                $this->rule->update_rule(
                    $rule_id,
                    $rule_type,
                    $rule_description,
                    $rule_separator,
                    $rule_modifiers,
                    $rule_pattern,
                    $rule_replacement,
                    $this->_user->session_id
                );
            }
            else
            {
                $this->rule->delete_rule($rule_id, $this->_user->session_id);

                $rule_id = $this->rule->add_rule(
                    $group_id,
                    $rule_type,
                    $rule_description,
                    $rule_separator,
                    $rule_modifiers,
                    $rule_pattern,
                    $rule_replacement,
                    $this->_user->session_id
                );
            }

            redirect(base_url('index.php/editor#' . $rule_id), 'refresh');
        }
        else
        {
            $rule_message = validation_errors();
        }

        $data = array(
            'rule_type' => $rule_type,
            'rule_description' => $rule_description,
            'rule_separator' => $rule_separator,
            'rule_modifiers' => $rule_modifiers,
            'rule_pattern' => $rule_pattern,
            'rule_replacement' => $rule_replacement,
            'rule_message' => $rule_message
        );

        $this->session->set_flashdata('flash_data', $data);

        redirect(base_url('index.php/editor?action=update_rule&rule=' . $rule_id . '#' . $rule_id));
    }

    private function delete_rule($rule_id)
    {
        $this->rule->delete_rule($rule_id, $this->_user->session_id);
        redirect(base_url('index.php/editor'));
    }

    private function reset_stats($rule_id)
    {
        $this->rule->reset_stats($rule_id, $this->_user->session_id);
        redirect(base_url('index.php/editor#' . $rule_id));
    }

    public function validate_rule_pattern ($pattern)
    {
        if (strlen($pattern) === 0)
        {
            $this->form_validation->set_message('validate_rule_pattern', lang('rule_pattern_empty'));
            return FALSE;
        }

        $type = $this->input->post('rule_type');
        $separator = $this->input->post('rule_separator');
        $modifiers = $this->input->post('rule_modifiers');

        //TODO        if ($type === 'regex' or $type === 'callback')
        if ($type === 'regex')
        {
            //Checking delimiter
            if (strlen($separator) !== 1 or preg_match('/(?!_)[\d\w\s]/u', $separator))
            {
                $this->form_validation->set_message('validate_rule_pattern', lang('rule_delimiter_invalid'));
                return FALSE;
            }

            //Checking modifiers
            if (preg_match('/(?-i)[^imsxuADSUXJ\s]|([imsxuADSUXJ]).*(\1)/', $modifiers))
            {
                $this->form_validation->set_message('validate_rule_pattern', lang('rule_modifiers_invalid'));
                return FALSE;
            }



            if (@preg_match($separator . $pattern . $separator . $modifiers, '') === FALSE)
            {
                $this->form_validation->set_message('validate_rule_pattern', lang('rule_pattern_invalid'));
                return FALSE;
            }
        }

        return TRUE;
    }

    //called via AJAX
    private function json_change_rule_order($json)
    {
        //id, order
        $data = json_decode($json, true);
        print_r($data);

        $this->rule->change_rule_order($data['id'], $data['order'], $this->_user->session_id);
    }

     /***********************************
     *          Result actions          *
     ***********************************/

    //For both cancelling last action or resetting all history
    public function cancel($records = NULL)
    {
        $flash_data = $this->input->post();
        $flash_data['rule_message'] = '';

        if ($records === 'all')
        {
            $this->history->delete_history();
            $this->session->set_flashdata('history_message', lang('result_history_been_reset'));
        }
        elseif($records === 'last')
        {
            $this->history->delete_current_record();
            $this->session->set_flashdata('history_message', lang('result_last_action_cancelled'));
        }

        $this->session->set_flashdata('flash_data', $flash_data);

        $action_data = explode('/', $this->input->post('current_action'));

        $action = array_shift($action_data);

        $id = (int)array_shift($action_data);

        $uri = '';

        if ( ! empty($id) and is_numeric($id))
        {
            switch ($action) {
                case 'open_add_rule_form':
                    $uri = '?action=add_rule&group=' . $id . '#group-' . $id;
                    break;
                case 'open_update_rule_form':
                    $uri = '?action=update_rule&rule=' . $id . '#' . $id;
                    break;
                default:
                    break;
            }
        }

        redirect(base_url('index.php/editor' . $uri));
    }

}