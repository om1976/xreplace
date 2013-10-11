<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_actions extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $language = $this->input->cookie('lang') === 'english' ? 'english' : 'russian';
        $this->config->set_item('language', $language);

        $this->lang->load('editor');

        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->model('category_model', 'category');

        $this->lang->load('editor');
        $this->lang->load('ion_auth');
        $this->lang->load('auth');

        //Bot check
        if ($this->input->post('areyouabot'))
        {
            redirect(base_url('index.php/editor'));
        }
    }


    public function register()
    {
        if ($this->ion_auth->logged_in())
        {
            redirect(base_url('index.php/editor'), 'refresh');
            exit;
        }
        
        $this->form_validation->set_rules('login', 'lang:register_login', 'required|max_length[12]|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'lang:register_email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'lang:register_password', 'required');
        
        $login = $this->input->post('login');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $save_data = (bool) $this->input->post('save_data');

        if ($this->form_validation->run() == true)
        {
            if ($user_id = $this->ion_auth->register($login, $password, $email))
            {
                if ($save_data)
                {
                    $this->category->save_data($this->session->userdata('session_id'), $user_id);
                }
                echo lang('register_success_message');
                header('Refresh:5;url='.base_url('index.php/editor'));
                exit;
            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }
        else
        {
            $this->session->set_flashdata('message', validation_errors());
        }

        $this->session->set_flashdata('login', $login);
        $this->session->set_flashdata('email', $email);
        $this->session->set_flashdata('password', $password);
        $this->session->set_flashdata('save_data', $save_data);

        redirect(base_url('index.php/auth/register'), 'refresh');
    }

    public function activate($id, $code) {
        if ($this->ion_auth->logged_in())
        {
            redirect('index.php/editor');
        }

        //if user is active redirect to the home page
        $user = $this->ion_auth->user($id)->row();

        if ($user and $user->active == 1)
        {
            echo lang('activate_unsuccessful_already_active');
            header('Refresh:4;url='.base_url('index.php/auth/login'));
            exit;
        }

        if ($code !== false)
        {
                $activation = $this->ion_auth->activate($id, $code);
        }
        else if ($this->ion_auth->is_admin())
        {
                $activation = $this->ion_auth->activate($id);
        }

        if ($activation)
        {
                //redirect them to the auth page
                echo $this->ion_auth->messages();
                header('Refresh:4;url='.base_url('index.php/auth/login'));
                exit;
        }
        else
        {
                //redirect them to the forgot password page
                echo $this->ion_auth->errors();
                header('Refresh:4;url='.base_url('index.php/auth/register'));
                exit;
        }
    }

    public function login()
    {
        if ($this->ion_auth->logged_in())
        {
            redirect(base_url('index.php/editor'), 'refresh');
            exit;
        }

        $this->form_validation->set_rules('login', 'lang:login_login', 'required');
        $this->form_validation->set_rules('password', 'lang:login_password', 'required');

        $remember = (bool) $this->input->post('remember');
        $save_data = (bool) $this->input->post('save_data');
        $login = $this->input->post('login');
        $password = $this->input->post('password');

        if ($this->form_validation->run() == true)
        {
            if ($this->ion_auth->login($login, $password, $remember))
            {
                if ($save_data)
                {
                    $this->category->save_data($this->session->userdata('session_id'), $this->ion_auth->user()->row()->id);
                }
                redirect(base_url('index.php/editor'), 'refresh');
                exit;
            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }
        else
        {
            $this->session->set_flashdata('message', validation_errors());
        }

        $this->session->set_flashdata('login', $login);
        $this->session->set_flashdata('password', $password);
        $this->session->set_flashdata('remember', $remember);
        $this->session->set_flashdata('save_data', $save_data);

        redirect(base_url('index.php/auth/login'), 'refresh');
    }

    public function logout()
    {
        $this->ion_auth->logout();
        redirect(base_url('index.php/editor'));
    }

    public function forgot_password()
    {
        if ($this->ion_auth->logged_in())
        {
            redirect(base_url('index.php/editor'), 'refresh');
            exit;
        }

        $this->form_validation->set_rules('email', 'lang:register_email', 'required|valid_email');

        if ($this->form_validation->run() == true)
        {
            $forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

            if ($forgotten)
            {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("auth/reset_password", 'refresh');
                    exit;
            }
            else
            {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    $this->session->set_flashdata('email', $this->input->post('email'));
                    redirect("auth/forgot_password", 'refresh');
                    exit;
            }

        }
        else
        {
            $this->session->set_flashdata('message', validation_errors());
            $this->session->set_flashdata('email', $this->input->post('email'));
            redirect("auth/forgot_password", 'refresh');
        }

    }

    public function reset_password($code = '')
    {
        $code = $code ? $code : $this->input->post('code');
        
        if ( ! $code)
        {
            $this->session->set_flashdata('message', lang('forgot_password_no_code'));
            redirect("auth/reset_password", 'refresh');
            exit;
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user)
        {
            $this->session->set_flashdata('code', $code);
            redirect("auth/new_password/" . $code, 'refresh');
        }
        else
        {
            $this->session->set_flashdata('message', lang('forgot_password_code_invalid'));
            $this->session->set_flashdata('code', $code);
            redirect("auth/reset_password", 'refresh');
        }

    }

    public function new_password()
    {
        $code = $this->input->post('code');

        if ( ! $code)
        {
            $this->session->set_flashdata('message', lang('forgot_password_no_code'));
            redirect("auth/reset_password", 'refresh');
            exit;
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user)
        {
            $change = $this->ion_auth->reset_password($user->email, $this->input->post('new_password'));
            if ($change)
            {
                $this->session->set_flashdata('email', $user->email);
                redirect("auth/login", 'refresh');
            }
        }
        else
        {
            $this->session->set_flashdata('message', lang('forgot_password_code_invalid'));
            $this->session->set_flashdata('code', $code);
            redirect("auth/reset_password", 'refresh');
        }

    }
  

}