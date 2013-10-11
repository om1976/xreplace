<?php

class Group_model extends CI_Model {

    public function group_exists($group_id, $user_id)
    {
        $sql = '
            SELECT `id`
            FROM `ed_groups`
            WHERE `added_by` = ? AND `id` = ?;
            ';
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $group_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($group = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            return $group['id'];
        }
        return FALSE;
    }


    public function get_group_data($group_id, $user_id)
    {
        $sql = '
            SELECT `id`, `type`, `name`, `global`
            FROM `ed_groups`
            WHERE `added_by` = ? AND `id` = ?;
            ';
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $group_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($group = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            return $group;
        }
        return array();
    }

    public function get_rules_data($group_id)
    {
        $result = $this->db->conn_id->query('
            SELECT
            `ed_rules`.*,
            FLOOR((UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(`used_at`))/86400) AS `used_days_ago`,
            `count`.`count`
            FROM `ed_rules`
                LEFT JOIN
            (SELECT COUNT(*) AS `count`
            FROM `ed_rules`
            WHERE `group_id` = '. (int)$group_id .'
            GROUP BY null) `count`
            ON 0 = 0
            WHERE `ed_rules`.`group_id` = '. (int)$group_id .' ORDER BY `ed_rules`.`order`;');
        if ($result)
        {
            $rules = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($rules)
                return $rules;
        }
        return array();
    }

    public function get_group_list($category_id, $user_id)
    {
        $group_list = array();

        $stmt = $this->db->conn_id->prepare('
            SELECT `g`.`id`, `g`.`name`, `g`.`global`, `c`.`name` AS `category_name`
            FROM `ed_groups` `g` JOIN `ed_categories` `c`
            ON `g`.`category_id` = `c`.`id`
            WHERE (`c`.`id` = ? OR `g`.`global` = "global") AND `g`.`added_by` = ?
            ORDER BY `g`.`global` DESC, `g`.`name`;');
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->execute();

        if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC))
        {
            foreach ($result as $group)
            {
                $group_list[$group['id']] = htmlspecialchars($group['name'] . ' (' . $group['category_name'] . ')', ENT_NOQUOTES);
            }
        }

//        print_r($group_list);
//        exit;

        return $group_list;
    }

    public function update_group($group_id, $group_type, $group_global, $group_name, $user_id)
    {
        $stmt = $this->db->conn_id->prepare("
            UPDATE `ed_groups`
            SET 
                `name` = ?,
                `type` = ?,
                `global` = ?,
                `edited_at` = NOW(),
                `edited_by` = `added_by`
            WHERE
                `id` = ? AND `added_by` = ?;");
        
        $stmt->bindParam(1, $group_name, PDO::PARAM_STR);
        $stmt->bindParam(2, $group_type, PDO::PARAM_STR);
        $stmt->bindParam(3, $group_global, PDO::PARAM_STR);
        $stmt->bindParam(4, $group_id, PDO::PARAM_INT);
        $stmt->bindParam(5, $user_id, PDO::PARAM_STR);
        $stmt->execute();
    }


    public function delete_group($group_id, $user_id)
    {
        $stmt = $this->db->conn_id->prepare('
            DELETE FROM `ed_groups`
            WHERE `id` = ?
            AND `added_by` = ?');
        $stmt->bindParam(1, $group_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->execute();
    }
}