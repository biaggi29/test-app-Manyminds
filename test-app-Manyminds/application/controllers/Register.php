<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Register_Model');
    }

    public function index() {

        $data['title'] = 'Cadastrando novo usuário';

        if ($this->session->userdata('logged_adm') &&
            $this->session->userdata('logged_adm')->funcao == '1' &&
            $this->session->userdata('logged_adm')->status == '1'
        ){
            $this->load->view('register', $data);
        }elseif ($this->session->userdata('logged_adm')){
            redirect('usuarios');
        } else {
            redirect(base_url());
        }
    }

    public function register() {
        $data_post = $this->input->post();

        $return = $this->Register_Model->register_user($data_post);

        if ($return['status'] == 1){
            mensagem('success', $return['mensagem']);
            redirect('usuarios');
        }elseif ($this->session->userdata('logged_adm') &&
            $this->session->userdata('logged_adm')->funcao == '1' &&
            $this->session->userdata('logged_adm')->status == '1'
        ){
            $data['title'] = 'Cadastrando novo usuário';
            $data['post'] = $data_post;
            mensagem('error', $return['mensagem']);
            $this->load->view('register', $data);
        } else {
            redirect(base_url());
        }
    }
}