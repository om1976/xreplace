<?php

class Category_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper('form');
    }


    public function get_category_id($category_id = null, $user_id)
    {
        $category_id = $category_id ? $category_id : $this->input->post('category');

        if ($category_id and $this->category_exists($category_id, $user_id))
        {
            $this->select_category($category_id, $user_id);

            return (int)$category_id;
        }
        else
        {
            return $this->select_any_category($user_id);
        }
    }

    public function make_category_snapshot($category_id, $link, $user_id, $sample_text = '')
    {
        if ($this->category_exists($category_id, $user_id))
        {
            //inserting 'snapshot' instead of $user_id making new category detached (owned by nobody)
            //this way we can find snapshots and delete old ones at any time
            $new_category_id = $this->copy_sample_category('snapshot', $category_id);

            $stmt = $this->db->conn_id->prepare("
                UPDATE `ed_categories`
                SET
                    `link` = ?,
                    `edited_at` = NOW(),
                    `edited_by` = ?,
                    `sample_text` = ?
                WHERE `id` = ?;");
            $stmt->bindParam(1, $link, PDO::PARAM_STR);
            $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
            $stmt->bindParam(3, $sample_text, PDO::PARAM_STR);
            $stmt->bindParam(4, $new_category_id, PDO::PARAM_INT);
            $stmt->execute();

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function get_category_id_by_link ($link)
    {
        $stmt = $this->db->conn_id->prepare('
            SELECT `id`
            FROM `ed_categories`
            WHERE `link` = ?');
        $stmt->bindParam(1, $link, PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            return $row['id'];
        }
    }


    public function select_category($category_id, $user_id)
    {
        $stmt = $this->db->conn_id->prepare(
                'UPDATE `ed_categories`
                    SET `selected` = IF(`id` = ?, "selected", "")
                 WHERE `added_by` = ?;');
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function select_any_category($user_id)
    {
        $stmt = $this->db->conn_id->prepare('
            SELECT `id`
            FROM `ed_categories`
            WHERE `added_by` = ?
            ORDER BY `selected` DESC
            LIMIT 1;');
        $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $this->select_category($row['id'], $user_id);
            return $row['id'];
        }
    }


    public function get_category_list($user_id)
    {
        $category_list = array();

        $stmt = $this->db->conn_id->prepare('
            SELECT `id`, `name`
            FROM `ed_categories`
            WHERE added_by = ?
            ORDER BY `name`;');
        $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
        $stmt->execute();

        if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC))
        {
            foreach ($result as $category)
            {
                $category_list[$category['id']] = htmlspecialchars($category['name'], ENT_NOQUOTES);
            }
        }
        
        return $category_list;
    }

    public function get_category_data($category_id, $user_id)
    {
        $stmt = $this->db->conn_id->prepare('
            SELECT *
            FROM `ed_categories`
            WHERE `id` = ?
            AND `added_by` = ?;');
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /*
     *
     */

    public function get_groups_data($category_id, $user_id)
    {
        $sql = '
            SELECT `g`.`id`, `g`.`type`, `g`.`name`, `g`.`global`, `g`.`category_id` , `c`.`name` as `category_name`
            FROM `ed_groups` `g`
            JOIN `ed_categories` `c` ON `g`.`category_id` = `c`.`id`
            WHERE `g`.`added_by` = ? AND `g`.`category_id` = ?
            ORDER BY `g`.`order`;
             ';        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $category_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($groups = $stmt->fetchAll(PDO::FETCH_ASSOC))
        {
//            print_r($groups);
//            exit;
            return $groups;
        }
        return array();
    }

    /*
     *
     */

    public function get_global_groups_data($category_id, $user_id)
    {       
        $sql = '
            SELECT `g`.`id`, `g`.`type`, `g`.`name`, `g`.`global`, `g`.`category_id` , `c`.`name` as `category_name`
            FROM `ed_groups` `g`
            JOIN `ed_categories` `c` ON `g`.`category_id` = `c`.`id`
            WHERE `g`.`added_by` = ? AND `g`.`global` = "global" AND `g`.`category_id` <> ?
            ORDER BY `c`.`name`, `g`.`order`;
            ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $category_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($groups = $stmt->fetchAll(PDO::FETCH_ASSOC))
        {
            return $groups;
        }
        return array();
    }




    public function get_group_list($category_id, $user_id)
    {
        $stmt = $this->db->conn_id->prepare("
            SELECT `id`, `name`, `c`.`name` as `category` 
            FROM `ed_groups` `g`
            JOIN `ed_categories` `c` ON `g`.`category_id` = `c`.`id`
            WHERE (`c`.`id` = ? OR `global` = 'global')
            AND `added_by` = ?
            ORDER BY `c`.`name`;
            ");
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt)
        {
            $group_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($group_list)
                return $group_list;
        }
        return array();
    }

    public function update_category($category_id, $category_name, $category_info, $user_id)
    {
        $stmt = $this->db->conn_id->prepare("
            UPDATE `ed_categories`
            SET
                `name` = ?,
                `edited_at` = NOW(),
                `edited_by` = ?,
                `info` = ?
            WHERE `id` = ?;");
        $stmt->bindParam(1, $category_name, PDO::PARAM_STR);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(3, $category_info, PDO::PARAM_STR);
        $stmt->bindParam(4, $category_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function add_category($category_name, $category_info, $user_id)
    {
        //`name`, `language`, `timezone`, `selected`, `added_at`, `added_by`, `edited_at`, `edited_by`, `info`

        $stmt = $this->db->conn_id->prepare("
            INSERT INTO `ed_categories`
                (`name`, `added_at`, `added_by`, `info`)
            VALUES
                (?, NOW(), ?, ?);");
        $stmt->bindParam(1, $category_name, PDO::PARAM_STR);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(3, $category_info, PDO::PARAM_STR);
        $stmt->execute();

        $category_id = $this->db->conn_id->lastInsertId();
        return $category_id;
    }

    public function delete_category($category_id, $user_id)
    {
        $stmt = $this->db->conn_id->prepare('
            DELETE FROM `ed_categories`
            WHERE `id` = ?
            AND `added_by` = ?');
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->execute();
        
        $this->select_any_category($user_id);
    }

    public function category_exists($category_id, $user_id)
    {
        $stmt = $this->db->conn_id->prepare('
            SELECT `id`
            FROM `ed_categories`
            WHERE `id` = ?
            AND `added_by` = ?');
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->fetch())
        {
            return true;
        }
    }


    public function add_group($category_id, $group_type, $group_global, $group_name, $user_id)
    {
        if ($this->category_exists($category_id, $user_id))
        {
            $stmt = $this->db->conn_id->prepare("
                INSERT INTO `ed_groups`
                    (`name`, `type`, `global`, `category_id`, `added_at`, `added_by`)
                VALUES
                    (?, ?, ?, ?, NOW(), ?);");
            $stmt->bindParam(1, $group_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $group_type, PDO::PARAM_STR);
            $stmt->bindParam(3, $group_global, PDO::PARAM_STR);
            $stmt->bindParam(4, $category_id, PDO::PARAM_INT);
            $stmt->bindParam(5, $user_id, PDO::PARAM_STR);
            $stmt->execute();

            $group_id = $this->db->conn_id->lastInsertId();

            return $group_id;
        }
        
        return FALSE;
    }

    public function copy_sample_category($user_id, $category_id)
    {
        $stmt = $this->db->conn_id->prepare('CALL copy_sample_category(?, ?, @new_category_id)');
        $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $category_id, PDO::PARAM_INT);
        $stmt->execute();

        $output = $this->db->conn_id->query("select @new_category_id")->fetch(PDO::FETCH_ASSOC);
        $this->select_category($output['@new_category_id'], $user_id);
        
        return $output['@new_category_id'];
    }

    //get all categories, groups and rules
    public function get_categories($user_id)
    {
        $stmt = $this->db->conn_id->prepare(
            "SELECT `c`.`name` as `cname`,
                    `g`.`name` as `gname`,
                    `r`.`type`,
                    `r`.`description`,
                    `r`.`separator`,
                    `r`.`modifiers`,
                    `r`.`pattern`,
                    `r`.`replacement`
             FROM `ed_categories` `c`
             JOIN `ed_groups` `g` ON `c`.`id` = `g`.`category_id`
             JOIN `ed_rules` `r` ON `g`.`id` = `r`.`group_id`
             WHERE `c`.`added_by` = ?
             ORDER BY `c`.`id`, `g`.`id`, `r`.`id`;"
        );
        $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
        $stmt->execute();
        if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC))
        {
            return $result;
        }

        return array();
    }

    public function save_data($not_logged_id, $logged_id)
    {
        $stmt = $this->db->conn_id->prepare("
            UPDATE `ed_categories` `c`
            JOIN `ed_groups` `g`
                ON `c`.`id` = `g`.`category_id`
            JOIN `ed_rules` `r`
                ON `g`.`id` = `r`.`group_id`
            SET
                `c`.`added_by` = ?,
                `g`.`added_by` = ?,
                `r`.`added_by` = ?
            WHERE `c`.`added_by` = ?;");
        $stmt->bindParam(1, $logged_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $logged_id, PDO::PARAM_STR);
        $stmt->bindParam(3, $logged_id, PDO::PARAM_STR);
        $stmt->bindParam(4, $not_logged_id, PDO::PARAM_STR);
        $stmt->execute();
    }
}
