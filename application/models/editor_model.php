<?php

class Editor_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->helper('my_string_helper');
 
    }

    public function get_menu($user_group, $language = 'russian')
    {
        $title = $language === 'russian' ? 'ru_title' : 'en_title';

        $stmt = $this->db->conn_id->prepare('
            SELECT `id`, `pid`, `section`, `'.$title.'` as `title`, `link`
            FROM `ed_menu`
            WHERE `display` >= ?
            ORDER BY `order`;');
        $stmt->bindParam(1, $user_group, PDO::PARAM_INT);
        $stmt->execute();
        if ($menu = $stmt->fetchAll(PDO::FETCH_ASSOC))
        {
            $html = "";

            foreach ($menu as $item) {
                $html .=    '<li><a href="'.base_url().'index.php/'.$item['link'].'">'.$item['title']."</a></li>\n";
            };

            return $html;
        }
    }

    public function how_long_ago($date_time, $format = 'Y-m-d H:i:s')
    {
        $ago = '--';

        if ($date_time)
        {
            $then = DateTime::createFromFormat($format, $date_time);
            $now = new DateTime('now');
            $interval = $now->diff($then);
            
            switch (TRUE)
            {
                case ($interval->y > 0):
                    $ago = $interval->y . '&nbsp;' . plural($interval->y, lang('year'), lang('years1'), lang('years2')) . lang('ago');
                    break;
                case ($interval->m > 0):
                    $ago = $interval->m . '&nbsp;' . plural($interval->m, lang('month'), lang('months1'), lang('months2')) . lang('ago');
                    break;
                case ($interval->days >= 7):
                    $ago = floor($interval->days/7) . '&nbsp;' . plural(floor($interval->days/7), lang('week'), lang('weeks1'), lang('weeks2')) . lang('ago');
                    break;
                case ($interval->days  >= 1):
                    $ago = $interval->days . '&nbsp;' . plural($interval->days, lang('day'), lang('days1'), lang('days2')) . lang('ago');
                    break;
                default:
                    $ago = lang('today');
                    break;
            }
        }
        return $ago;
    }

}