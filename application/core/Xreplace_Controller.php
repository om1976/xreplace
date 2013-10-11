<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xreplace_Controller extends CI_Controller
{
    protected $_user = array();

    public function __construct()
    {
        parent::__construct();

        error_reporting(E_ALL);

        $this->_init();
    }

        /*
     *  Setting language, user, loading libraries, models etc.
     */

    protected function _init() {

        ini_set('memory_limit', '-1');


        $language = $this->input->cookie('lang') === 'english' ? 'english' : 'russian';

        //Native cookie setter is used due to bugs while setting cookies with CI Cookie
        setcookie('lang', $language, time() + 315360000, '/');

        $this->config->set_item('language', $language);

        $this->lang->load('editor');

        $this->load->model('editor_model', 'editor');
        $this->load->model('category_model', 'category');
        $this->load->model('group_model', 'group');
        $this->load->model('rule_model', 'rule');
        $this->load->model('history_model', 'history');

        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');

        if ($this->ion_auth->logged_in())
        {
            $this->_user = $this->ion_auth->user()->row();
            $this->_user->session_id = $this->_user->id;
            $this->_user->group_id = $this->ion_auth->get_users_groups()->row()->id;
        }
        else
        {
            $this->_user = new stdClass();
            $this->_user->id = 0;
            $this->_user->session_id = $this->session->userdata('session_id');
            $this->_user->group_id = 3;
        }
    }


    /*
     * Rendering full page
     */

    protected function _render_page ($view, $data = array())
    {
         $this->_load_header();

         $this->load->view($view, $data);

         $this->_load_footer();
    }

    /*
     * Rendering header
     */
    protected function _load_header ()
    {
        $menu = $this->_load_menu();

        if ($this->ion_auth->logged_in())
        {
            $user_name = $this->_user->username;
            $logger_title = lang('header_auth_logout');
            $logger_ref = base_url('index.php/auth_actions/logout');
            $user_image_class = 'ui-user bright';
        }
        else
        {
            $user_name = '';
            $logger_title = lang('header_auth_login');
            $logger_ref = base_url('index.php/auth/login');
            $user_image_class = '';
        }


        $this->load->view('header', array(
            'menu' => $menu,
            'user_name' => $user_name,
            'logger_title' => $logger_title,
            'logger_ref' => $logger_ref,
            'user_image_class' => $user_image_class));
    }


    /*
     * Rendering footer
     */
    protected function _load_footer ()
    {
        $this->load->view('footer', array('title' => 'X-Replace'));
    }


    /*
     * Rendering menu
     */
    protected function _load_menu ()
    {
        $language = $this->config->item('language');

        return $this->editor->get_menu($this->_user->group_id, $language);
    }


    public function not_found()
    {
        $this->output->set_status_header('404');
        $data['content'] = lang('page_not_found');
        $this->_render_page('editor/not_found', $data);

    }

}