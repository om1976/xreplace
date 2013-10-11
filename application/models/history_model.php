<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History_model extends CI_Model {
    
    private $history;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        
        $this->history = $this->session->userdata('history');

        if (! is_array($this->history))
        {
            $this->history = array();
        };
    }

    public function create_new_record()
    {
        array_push($this->history, array());
        $this->session->set_userdata('history', $this->history);
    }

    public function set($key, $value)
    {
        $current_history_record = array_pop($this->history);
        $current_history_record[$key] = $value;

        if (empty($this->history))
        {
            $this->history = array();
        }
        
        array_push($this->history, $current_history_record);

        //TODO: check the history size and prompt user to delete previuos history if it's too large
        
        $this->session->set_userdata('history', $this->history);
    }

    public function get($key)
    {
        $current_history_record = array_pop($this->history);
        array_push($this->history, $current_history_record);
        return isset($current_history_record[$key]) ? $current_history_record[$key] : null;
    }

    public function previous_record_exists()
    {
        end($this->history);
        
        if (prev($this->history) !== FALSE)
        {
            end($this->history);
            return TRUE;
        }
        
        return FALSE;
    }

    public function current_record_exists()
    {
        if ( ! $this->previous_record_exists() and empty($this->history[0]))
        {
            return FALSE;
        }
        return TRUE;
    }

    //undo
    public function delete_current_record()
    {
        if ($this->previous_record_exists())
        {
            array_pop($this->history);
        
            $this->session->set_userdata('history', $this->history);
        }
//        elseif (isset($this->history['text']))
//        {
//            $text = $this->history['text'];
//            $this->history = array();
//            $this->history['text'] = $text;
//        }
//        else
//        {
//            $this->history = array();
//        }

    }

    public function delete_history ()
    {
        $this->session->set_userdata('history', NULL);
    }

//    public function countUsedRules() {
//        $founds = $this->input->get('founds');
//        $rule_count = 0;
//        if ($founds and is_array($founds))
//        {
//            foreach ($founds as $item)
//            {
//                if (isset($rule_count[$item['rule_id']]))
//                {
//                    $rule_count[$item['rule_id']] += 1;
//                }
//                else
//                {
//                    $rule_count[$item['rule_id']] = isset($item['count']) ? $item['count'] : 1;
//                }
//            }
//        }
//        return $rule_count;
//    }

}
