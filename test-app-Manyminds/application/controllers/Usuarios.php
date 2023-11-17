<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Register_Model');
    }

    public function index() {

        $data['title'] = 'Listando usuários';

        $config['base_url'] = base_url('usuarios');
        $config['total_rows'] = $this->Register_Model->count_users();
        $config['per_page'] = 4;

        $this->pagination->initialize($config);

        $pagina_atual = $this->uri->segment(2, 0);
        $limit = $config['per_page'];
        $offset = $pagina_atual;

        $data['usuarios'] = $this->Register_Model->list_users($limit, $offset);
        $data['links'] = $this->pagination->create_links();

        if ($this->session->userdata('logged_adm')) {
            $this->load->view('usuarios', $data);
        } else {
            redirect('login');
        }
    }

    public function status() {
        $this->load->model('Usuario_Model');

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $idUsuario = $this->input->post('id');

        $success = $this->Usuario_Model->toggle_user_status($idUsuario);

        $response = array('success' => $success);

        echo json_encode($response);
    }

    public function delete() {
        $this->load->model('Usuario_Model');

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $idUsuario = $this->input->post('id');

        $success = $this->Usuario_Model->user_delete($idUsuario);

        $response = array('success' => $success);

        echo json_encode($response);
    }

    public function update_page($id) {
        $this->load->model('Usuario_Model');

        $data['title'] = 'Editando usuário';

        if ($this->session->userdata('logged_adm') &&
            $this->session->userdata('logged_adm')->status == '1'
        ){

            $data['user'] = $this->Usuario_Model->get_user_by_id($id);

            if ($data['user']['status']) {

                $data['user_id'] = $id;

                $this->load->view('update', $data);
            }else{
                redirect(base_url('usuarios'));
            }
        } else {
            redirect(base_url());
        }
    }

    public function update_user($id) {
        $this->load->model('Usuario_Model');

        $data_post = $this->input->post();

        $return = $this->Usuario_Model->update_user($data_post, $id);

        if ($return['status'] == 1){
            mensagem('success', $return['mensagem']);
            redirect('usuarios');
        }elseif ($this->session->userdata('logged_adm') &&
            $this->session->userdata('logged_adm')->status == '1'
        ){
            $data['title'] = 'Editando usuário';

            $data['user_id'] = $id;

            if ($data_post) {
                $data['user'] = $data_post;
            }else{
                $data['user'] = $this->Usuario_Model->get_user_by_id($id);
            }


            mensagem('error', $return['mensagem']);
            $this->load->view('update', $data);
        } else {
            redirect(base_url());
        }
    }
}