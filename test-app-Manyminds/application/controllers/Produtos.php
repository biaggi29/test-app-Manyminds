<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Produtos_Model');
    }

    public function index() {

        $data['title'] = 'Listando Produtos';

        $config['base_url'] = base_url('produtos');
        $config['total_rows'] = $this->Produtos_Model->count_products();
        $config['per_page'] = 4;

        $this->pagination->initialize($config);

        $pagina_atual = $this->uri->segment(2, 0);
        $limit = $config['per_page'];
        $offset = $pagina_atual;

        $data['produtos'] = $this->Produtos_Model->list_products($limit, $offset);
        $data['links'] = $this->pagination->create_links();

        if ($this->session->userdata('logged_for')) {
            $this->load->view('produtos', $data);
        } else {
            redirect('login');
        }
    }

    public function page_register() {

        $data['title'] = 'Cadastrando novo Produto';

        if ($this->session->userdata('logged_for') &&
            $this->session->userdata('logged_for')->funcao == '3' &&
            $this->session->userdata('logged_for')->status == '1'
        ){

            $data['nome_fornecedor'] = $this->session->userdata('logged_for')->nome . ' ' . $this->session->userdata('logged_for')->sobrenome;

            $this->load->view('registerProduto', $data);
        }elseif ($this->session->userdata('logged_adm')){
            redirect('usuarios');
        } else {
            redirect(base_url());
        }
    }

    public function register() {
        $data_post = $this->input->post();

        $return = $this->Produtos_Model->register_product($data_post);

        if ($return['status'] == 1){
            mensagem('success', $return['mensagem']);
            redirect('produtos');
        }elseif ($this->session->userdata('logged_for') &&
            $this->session->userdata('logged_for')->funcao == '3' &&
            $this->session->userdata('logged_for')->status == '1'
        ){
            $data['title'] = 'Cadastrando novo Produto';
            $data['nome_fornecedor'] = $this->session->userdata('logged_for')->nome . ' ' . $this->session->userdata('logged_for')->sobrenome;
            $data['post'] = $data_post;
            mensagem('error', $return['mensagem']);
            $this->load->view('registerProduto', $data);
        } else {
            redirect(base_url());
        }
    }

    public function delete() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $idProduct = $this->input->post('id');

        $success = $this->Produtos_Model->product_delete($idProduct);

        $response = array('success' => $success);

        echo json_encode($response);
    }

    public function status() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $idUsuario = $this->input->post('id');

        $success = $this->Produtos_Model->toggle_product_status($idUsuario);

        $response = array('success' => $success);

        echo json_encode($response);
    }

    public function update_page($id) {
        $data['title'] = 'Editando Produto';

        if ($this->session->userdata('logged_for') &&
            $this->session->userdata('logged_for')->status == '1'
        ){

            $data['product_id'] = $id;
            $data['product'] = $this->Produtos_Model->get_product_by_id($id);

            if ($data['product']['status'] == 1) {

                $data['nome_fornecedor'] = $this->session->userdata('logged_for')->nome . ' ' . $this->session->userdata('logged_for')->sobrenome;

                $this->load->view('updateProduto', $data);
            }else{
                redirect(base_url('produtos'));
            }
        } else {
            redirect(base_url());
        }
    }

    public function update_product($id) {

        $data_post = $this->input->post();

        $return = $this->Produtos_Model->update_product($data_post, $id);

        if ($return['status'] == 1){
            mensagem('success', $return['mensagem']);
            redirect('produtos');
        }elseif ($this->session->userdata('logged_for') &&
            $this->session->userdata('logged_for')->status == '1'
        ){
            $data['title'] = 'Editando Produto';

            $data['product_id'] = $id;

            $data['nome_fornecedor'] = $this->session->userdata('logged_for')->nome . ' ' . $this->session->userdata('logged_for')->sobrenome;

            if ($data_post) {
                $data['product'] = $data_post;
            }else{
                $data['product'] = $this->Produtos_Model->get_product_by_id($id);
            }


            mensagem('error', $return['mensagem']);
            $this->load->view('updateProduto', $data);
        } else {
            redirect(base_url());
        }
    }
}