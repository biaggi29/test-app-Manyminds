<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $data['title'] = 'Sistema CRUD';

        if ($this->session->userdata('logged_col')) {
            redirect('comprar');
        } elseif ($this->session->userdata('logged_for')) {
            redirect('produtos');
        }else {
            $this->load->view('home', $data);
        }
    }

    public function login_home() {
        $this->load->model('Usuario_Model');

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $login_result = $this->Usuario_Model->validate_login($email, $password);

        if ($login_result['status'] == 1) {
            if ($login_result['data']->funcao == 1) {
                $this->session->set_userdata('logged_adm', $login_result['data']);
                redirect(base_url('usuarios'));
            }elseif ($login_result['data']->funcao == 2){
                $this->session->set_userdata('logged_col', $login_result['data']);
                redirect(base_url('comprar'));
            }elseif ($login_result['data']->funcao == 3){
                $this->session->set_userdata('logged_for', $login_result['data']);
                redirect(base_url('produtos'));
            }else{
                mensagem('error',$login_result['msg']);
                redirect(base_url(''), 'refresh');
            }

            redirect(base_url('usuarios'));
        }else {
            mensagem('error',$login_result['msg']);
            redirect(base_url(''), 'refresh');
        }
    }
}