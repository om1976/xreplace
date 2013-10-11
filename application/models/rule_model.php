<?php

class Rule_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->model('history_model', 'history');
        $this->load->helper('my_string_helper');
        $this->load->helper('my_date_helper');
        $this->load->library('session');
    }

    public function get_rule_data($id, $user_id)
    {
        $stmt = $this->db->conn_id->prepare('
            SELECT * FROM `ed_rules` WHERE `id` = ? and `added_by` = ?
        ');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->execute();

        if ($rule = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            return $rule;
        }

        return array();
    }

    public function get_rule_group($rule_id)
    {
        $stmt = $this->db->conn_id->prepare('
            SELECT `group_id` FROM `ed_rules` WHERE `id` = ?
        ');
        $stmt->bindParam(1, $rule_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($rule = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            return $rule['group_id'];
        }

        return NULL;
    }

    public function add_rule(
        $group_id,
        $rule_type,
        $rule_description,
        $rule_separator,
        $rule_modifiers,
        $rule_pattern,
        $rule_replacement,
        $user_id
    )
    {        
        $stmt = $this->db->conn_id->prepare("
            INSERT INTO `ed_rules` (
                `group_id`,
                `type`,
                `description`,
                `separator`,
                `modifiers`,
                `pattern`,
                `replacement`,
                `added_at`,
                `added_by`,
                `order`)
            VALUES
                (
                 ?,
                 ?,
                 ?,
                 ?,
                 ?,
                 ?,
                 ?,
                 NOW(),
                 ?,
                 (IFNULL((SELECT `z`.`order`
                          FROM `ed_rules` `z`
                          WHERE `z`.`group_id` = ?
                          ORDER BY `z`.`order`
                          DESC LIMIT 1), 0) + 1));
        ");
        $stmt->bindParam(1, $group_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $rule_type, PDO::PARAM_STR);
        $stmt->bindParam(3, $rule_description, PDO::PARAM_STR);
        $stmt->bindParam(4, $rule_separator, PDO::PARAM_STR);
        $stmt->bindParam(5, $rule_modifiers, PDO::PARAM_STR);
        $stmt->bindParam(6, $rule_pattern, PDO::PARAM_STR);
        $stmt->bindParam(7, $rule_replacement, PDO::PARAM_STR);
        $stmt->bindParam(8, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(9, $group_id, PDO::PARAM_INT);

        $stmt->execute();

        $rule_id = $this->db->conn_id->lastInsertId();
        return $rule_id;
    }

    public function update_rule(
        $rule_id,
        $rule_type,
        $rule_description,
        $rule_separator,
        $rule_modifiers,
        $rule_pattern,
        $rule_replacement,
        $user_id
    )
    {
        //TODO: add possibility to move rules between groups

        $stmt = $this->db->conn_id->prepare("
            UPDATE `ed_rules`
            SET
                `type` = ?,
                `description` = ?,
                `separator` = ?,
                `modifiers` = ?,
                `pattern` = ?,
                `replacement` = ?,
                `edited_at` = NOW(),
                `edited_by` = ?
           WHERE `id` = ? AND `added_by` = ?;
        ");
        $stmt->bindParam(1, $rule_type, PDO::PARAM_STR);
        $stmt->bindParam(2, $rule_description, PDO::PARAM_STR);
        $stmt->bindParam(3, $rule_separator, PDO::PARAM_STR);
        $stmt->bindParam(4, $rule_modifiers, PDO::PARAM_STR);
        $stmt->bindParam(5, $rule_pattern, PDO::PARAM_STR);
        $stmt->bindParam(6, $rule_replacement, PDO::PARAM_STR);
        $stmt->bindParam(7, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(8, $rule_id, PDO::PARAM_INT);
        $stmt->bindParam(9, $user_id, PDO::PARAM_STR);
        
        $stmt->execute();
    }

    public function delete_rule($rule_id, $user_id)
    {
        $stmt = $this->db->conn_id->prepare("
            UPDATE `ed_rules` `r1`,
                    (SELECT `group_id`, `order` from `ed_rules` WHERE `id` = ?) `r2`
            SET `r1`.`order` = `r1`.`order` - 1
            WHERE `r1`.`order` > `r2`.`order`
            AND `r1`.`group_id` = `r2`.`group_id`
            AND `r1`.`added_by` = ? ;");
        $stmt->bindParam(1, $rule_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->execute();
        unset($stmt);

        $stmt = $this->db->conn_id->prepare("DELETE FROM `ed_rules` WHERE `id` = ? AND `added_by` = ?;");
        $stmt->bindParam(1, $rule_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function change_rule_order($id, $order, $user_id)
    {

        $id_1 = (int)$id;
        $order_2 = (int)$order;

        $result = $this->db->conn_id->query('
            SELECT `order`, `group_id`, `added_by` FROM `ed_rules` WHERE `id` = ' . $id_1);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        if ($row and $user_id !== $row['added_by'])
        {
            //if it's not your own group, exit TODO: error message
            return;
        }


        $order_1 = $row['order'];
        $group_id = $row['group_id'];

        $result = $this->db->conn_id->query('
            SELECT `id` FROM `ed_rules` WHERE `group_id` = ' . $group_id . ' AND `order` = ' . $order_2);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        $id_2 = $row['id'];
        
        if (empty($id_2))
            return;
        
        if ($order_1 > $order)
        {
            $sql = '
UPDATE `ed_rules` SET `order` = `order` + 1 WHERE `order` >= ' . $order_2 . ' AND `order` < ' . $order_1 . ' AND `group_id` = ' . $group_id . '; ';

        }
        elseif ($order_1 < $order)
        {
            $sql =
'UPDATE `ed_rules` SET `order` = `order` - 1 WHERE `order` > ' . $order_1 . ' AND `order` <= ' . $order_2 . ' AND `group_id` = ' . $group_id . '; ';
        }
        else
        {
            return;
        }
        $sql .= ' UPDATE `ed_rules` SET `order` = ' . $order_2 . ' WHERE `id` = ' . $id_1;

        $this->db->conn_id->exec($sql);
    }

    public function apply_regex_rule(
        $rule_separator,
        $rule_modifiers,
        $rule_pattern,
        $rule_replacement,
        $rule_id = NULL,
        $rule_order = NULL,
        $group_name = ''
    )
    {
        $callback_flag = FALSE;

        $this->benchmark->mark( 'apply_regex_rule_start' );

        $text = $this->history->get('text');    

        $rule_pattern = $rule_separator . $rule_pattern . $rule_separator . $rule_modifiers;

        $founds = array();

        $result = array();

        preg_match_all($rule_pattern, $text, $founds, PREG_SET_ORDER);

        $func_placeholders_array = $this->config->item('func_placeholders');

        $func_placeholders = implode('|', $func_placeholders_array);

        if (preg_match('/{{(' . $func_placeholders . ')[\x20]\$\d}}/ux', $rule_replacement))
        {
            $callback_flag = TRUE;
        }
        
        $callback_replacement = preg_replace_callback(
            '/{{(\w+)[\x20]\$(\d+)}}|(?<!\\\\)\$(\d+)/ux',
            function($match) use ($func_placeholders_array)
            {
                if ( ! empty($match[1]))
                {
                    $func_name = array_search($match[1], $func_placeholders_array);

                    if ($func_name)
                    {
                        return "' . $func_name(\$match[" . $match[2] . "]) . '";
                    }
                    else
                    {
                        return "'.'{{" . $match[1] . " '.\$match[" . $match[2] . "] . '}}";
                    }
                }
                else
                {
                    return "' . \$match[" . $match[3] . "] . '";
                }
            },
            $rule_replacement
        );
        
        $captured = array();

        $new_text = @preg_replace_callback($rule_pattern, function($match) use ($callback_replacement, &$captured) {
                        $replaced = eval("return '" . $callback_replacement . "';");
                        $captured[] = $replaced;
                        return $replaced;

                        }, $text);

        $error = preg_last_error();

        if ($error !== PREG_NO_ERROR)
        {
            switch ($error)
            {
                case PREG_INTERNAL_ERROR:
                    $message = 'Ошибка! Произошла внутренняя ошибка PCRE.';
                    break;
                case PREG_BACKTRACK_LIMIT_ERROR:
                    $message = 'Ошибка! Был исчерпан лимит обратных ссылок.';
                    break;
                case PREG_RECURSION_LIMIT_ERROR:
                    $message = 'Ошибка! Был исчерпан лимит рекурсии.';
                    break;
                case PREG_BAD_UTF8_ERROR:
                    $message = 'Ошибка! Поврежденные данные UTF-8.';
                    break;
                case PREG_BAD_UTF8_OFFSET_ERROR:
                    $message = 'Ошибка! Смещение не соответствует началу корректной кодовой точки UTF-8.';
                    break;
                default:
                    $message = 'Неизвестная ошибка!';
                    break;
            }
            $this->session->set_flashdata('history_message', $message);
            $new_text = $text;
        }

        $count = count($founds);
        for ($i = 0; $i < $count; $i++)
        {
            $result[$i]['rule_order'] = $rule_order ? $rule_order : lang('rule_new');
            $result[$i]['found'] = $founds[$i][0];
            $result[$i]['replaced'] = $captured[$i];

            if (isset($result[$i - 1]) and
                $result[$i]['rule_order'] === $result[$i - 1]['rule_order'] and
                $result[$i]['found'] === $result[$i - 1]['found'] and
                $result[$i]['replaced'] === $result[$i - 1]['replaced'])
            {
                $result[$i]['total'] = $result[$i - 1]['total'] + 1;
                unset($result[$i - 1]);
            }
            else
            {
                $result[$i]['total'] = 1;
            }
        }

        $stored_result = $this->history->get('result');
        $new_result = array_merge((array)$stored_result, $result);

        $this->history->set('text', $new_text);
        $this->history->set('group_name', $group_name);
        $this->history->set('rule_order', $rule_order);
        $this->history->set('result', $new_result);

        $this->benchmark->mark( 'apply_regex_rule_end' );
        $benchmark = $this->benchmark->elapsed_time('apply_regex_rule_start', 'apply_regex_rule_end');
        $this->history->set('benchmark', number_format($benchmark, 5 , ',', ''));
        
        $this->save_stats($rule_id, $count, $benchmark);
    }

    public function apply_simple_rule(
        $rule_pattern,
        $rule_replacement,
        $rule_id = NULL,
        $rule_order = NULL,
        $group_name = ''
    )
    {
        $this->benchmark->mark( 'apply_simple_rule_start' );

        $text = $this->history->get('text');

        $result = array();

        $count = substr_count($text, $rule_pattern);

        if ($count)
        {
            $text = strtr($text, array($rule_pattern => $rule_replacement));
            $result[0]['rule_order'] = $rule_order ? $rule_order : lang('rule_new');
            $result[0]['found'] = $rule_pattern;
            $result[0]['replaced'] = $rule_replacement;
            $result[0]['total'] = $count;
        }
                

        $stored_result = $this->history->get('result');
        $new_result = array_merge((array)$stored_result, $result);

        $this->history->set('text', $text);
        $this->history->set('group_name', $group_name);
        $this->history->set('rule_order', $rule_order);
        $this->history->set('result', $new_result);

        $this->benchmark->mark( 'apply_simple_rule_end' );
        $benchmark = $this->benchmark->elapsed_time('apply_simple_rule_start', 'apply_simple_rule_end');
        $this->history->set('benchmark', number_format($benchmark, 5 , ',', ''));

        $this->save_stats($rule_id, $count, $benchmark);
    }

    private function save_stats($rule_id, $count, $benchmark)
    {
        $used_at = $count ? 'NOW()' : '`used_at`';
        $count = $count ? $count : 0;

        $stmt = $this->db->conn_id->prepare('
            UPDATE `ed_rules`
            SET
            `times_used` = IFNULL(`times_used`, 0) + ?,
            `total_time` = IFNULL(`total_time`, 0) + ?,
            `used_at` = ' . $used_at . '
            WHERE `id` = ?
        ');
        $stmt->bindParam(1, $count, PDO::PARAM_INT);
        $stmt->bindParam(2, $benchmark, PDO::PARAM_INT);
        $stmt->bindParam(3, $rule_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function reset_stats($rule_id)
    {
        $stmt = $this->db->conn_id->prepare('
            UPDATE `ed_rules`
            SET
            `times_used` = 0,
            `total_time` = 0,
            `used_at` = NULL
            WHERE `id` = ?
        ');
        $stmt->bindParam(1, $rule_id, PDO::PARAM_INT);
        $stmt->execute();
    }
}