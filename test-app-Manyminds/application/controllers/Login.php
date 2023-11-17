<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_Model');
    }

    public function index() {

        $data['title'] = 'Ir para o início';

        if ($this->session->userdata('logged_adm')) {
            redirect('usuarios');
        } else {
            $this->load->view('login', $data);
        }
    }

    public function login() {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $login_result = $this->Usuario_Model->validate_login($email, $password);

        if ($login_result['status'] == 1) {
            $this->session->set_userdata('logged_adm', $login_result['data']);
            redirect(base_url('usuarios'));
        }else {
            mensagem('error',$login_result['msg']);
            redirect(base_url('login'), 'refresh');
        }
    }


    public function logout(){
        $this->session->sess_destroy();

        redirect(base_url());
    }

}