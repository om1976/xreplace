<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auth extends Xreplace_Controller {


    public function register()
    {
        if ($this->ion_auth->logged_in())
        {
            redirect(base_url('index.php/editor'));
            exit;
        }
        $data = array(
            'login'     => $this->session->flashdata('login'),
            'email'     => $this->session->flashdata('email'),
            'password'  => $this->session->flashdata('password'),
            'message'   => $this->session->flashdata('message'),
            'save_data' => $this->session->flashdata('save_data') ? 'checked' : ''
        );

        $this->_render_page('auth/register', $data);
    }

    public function login()
    {
        if ($this->ion_auth->logged_in())
        {
            redirect(base_url('index.php/editor'));
            exit;
        }
        $data = array(
            'login'     => $this->session->flashdata('login'),
            'password'  => $this->session->flashdata('password'),
            'remember'  => $this->session->flashdata('remember') ? 'checked' : '',
            'message'   => $this->session->flashdata('message'),
            'save_data' => $this->session->flashdata('save_data') ? 'checked' : ''
        );

        $this->_render_page('auth/login', $data);
    }

    public function forgot_password()
    {
        if ($this->ion_auth->logged_in())
        {
            redirect(base_url('index.php/editor'));
            exit;
        }

        $data = array(
            'email'     => $this->session->flashdata('email'),
            'message'   => $this->session->flashdata('message')
        );

        $this->_render_page('auth/forgot_password', $data);
    }

    public function reset_password()
    {
        if ($this->ion_auth->logged_in())
        {
            redirect(base_url('index.php/editor'));
            exit;
        }

        $data = array(
            'code' => $this->session->flashdata('code'),
            'message' => $this->session->flashdata('message')
        );

        $this->_render_page('auth/reset_password', $data);

    }


    public function new_password($code = '')
    {
        if ($this->ion_auth->logged_in())
        {
            redirect(base_url('index.php/editor'));
            exit;
        }

        if ( ! $this->ion_auth->forgotten_password_check($code))
        {
            $this->session->set_flashdata('message', lang('forgot_password_code_invalid'));
            redirect("auth/reset_password", 'refresh');
            exit;
        }

        $data = array(
            'code' => $code,
            'new_password' => $this->session->flashdata('new_password')
        );

        $this->_render_page('auth/new_password', $data);
    }
}