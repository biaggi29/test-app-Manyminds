<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comprar extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Comprar_Model');
    }

    public function index() {

        $data['title'] = 'CARRINHO';

        if ($this->session->userdata('logged_col')) {
            $data['fornecedores'] = $this->Comprar_Model->list_fornecedores();

            $data['itens'] = $this->Comprar_Model->obter_carrinho();

            $data['total_pedido'] = $this->calcular_total_pedido($data['itens']);
            $data['itens_no_carrinho'] = !empty($data['itens']);

            $this->load->view('comprar', $data);
        } else {
            redirect('login');
        }
    }

    public function page_for_produtos($id){

        $data['title'] = 'CARRINHO';

        if ($this->session->userdata('logged_col')) {
            $info_fornecedor = $this->Comprar_Model->get_fornecedor($id);

            $data['nome_fornecedor'] = $info_fornecedor['nome'] . ' ' . $info_fornecedor['sobrenome'];

            $data['produtos'] = $this->Comprar_Model->get_produtos_fornecedor($id);

            $data['itens'] = $this->Comprar_Model->obter_carrinho();

            $data['total_pedido'] = $this->calcular_total_pedido($data['itens']);
            $data['itens_no_carrinho'] = !empty($data['itens']);

            // teste
            //$this->session->unset_userdata('carrinho');
            //print_r($this->session->userdata('carrinho'));

            $this->load->view('comprarProdutos', $data);
        } else {
            redirect('login');
        }
    }

    public function page_pedidos(){
        if ($this->session->userdata('logged_col')) {
            $data['title'] = 'Meus Pedidos';

            $id_colaborador = $this->session->userdata('logged_col')->id;
            $data['pedidos_itens'] = $this->Comprar_Model->listar_pedidos_itens($id_colaborador);

            $this->load->view('pedidos', $data);
        } else {
            redirect('login');
        }
    }

    public function pedido_status() {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $idPedido= $this->input->post('id');

        $success = $this->Comprar_Model->toggle_order_status($idPedido);

        $response = array('success' => $success);

        echo json_encode($response);
    }

    public function pedido_delete() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $idPedido = $this->input->post('id');

        $success = $this->Comprar_Model->order_delete($idPedido);

        $response = array('success' => $success);

        echo json_encode($response);
    }

    public function limpar(){
        $this->Comprar_Model->limpar_carrinho();
        mensagem('success', 'Carrinho Vazio!');
        redirect('comprar');
    }

    public function finalizar() {
        if ($this->session->userdata('logged_col')) {
            $itens_no_carrinho = $this->session->userdata('carrinho');

            if (!empty($itens_no_carrinho)) {
                $id_colaborador = $this->session->userdata('logged_col')->id;
                $valor_total = $this->calcular_total_pedido($itens_no_carrinho);
                $status = 1;

                $pedido_id = $this->Comprar_Model->criar_pedido($id_colaborador, $valor_total, $status);

                if ($pedido_id) {
                    foreach ($itens_no_carrinho as $item) {
                        $this->Comprar_Model->adicionar_item_pedido($pedido_id, $item);
                    }

                    $this->session->unset_userdata('carrinho');

                    mensagem('success', 'Pedido realizado com sucesso! Verifique a página "Meus Pedidos"!');
                    redirect('comprar');
                }
            } else {
                redirect('comprar');
            }
        } else {
            redirect(base_url());
        }
    }

    public function adicionar() {
        $data = $this->input->post();

        if (isset($data['id_produto']) && isset($data['quantidade'])) {

            $info_product = $this->Comprar_Model->get_produto_by_id($data['id_produto']);

            $info_fornecedor = $this->Comprar_Model->get_fornecedor($info_product['id_fornecedor']);

            $produto = [
                'id_produto'        => $info_product['id'],
                'nome'              => $info_product['nome'],
                'preco'             => $info_product['preco'],
                'id_fornecedor'     => $info_product['id_fornecedor'],
                'nome_fornecedor'   => $info_fornecedor['nome'] . ' ' . $info_fornecedor['sobrenome'],
                'quantidade'        => isset($data['quantidade'])?$data['quantidade']:1,
                'observacoes'       => $data['observacoes']
            ];

            $this->Comprar_Model->adicionar_item($produto);

            return true;
        }

        return false;
    }

    public function remover($id_produto) {
        $this->Comprar_Model->remover_item($id_produto);

        mensagem('success', 'Produto removido com sucesso!');
        redirect(base_url('carrinho/visualizar'));
    }

    private function calcular_total_pedido($itens) {
        $total = 0;

        foreach ($itens as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }

        return $total;
    }

    public function get_pedidos_json() {

        // autenticação
        if (!$this->authenticate()) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'Authentication failed'));
            return;
        }

        $pedidos = $this->Comprar_Model->get_all_pedidos();

        $response = array();
        foreach ($pedidos as $pedido) {
            $pedido_info = array(
                'id_pedido' => $pedido['id'],
                'id_usuario' => $pedido['id_colaborador'],
                'valor_total' => $pedido['valor_total'],
                'status' => $pedido['status'],
                'itens' => $this->Comprar_Model->get_itens_pedido($pedido['id'])
            );

            array_push($response, $pedido_info);
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }


    private function authenticate() {
        $token = $this->input->get_request_header('Authorization', TRUE);
        if ($token && strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);

            // token fixo
            $token_valido = 'FKSH-DKDV-WYXFG-DGDS';

            if ($token === $token_valido) {
                return true;
            }
        }

        return false;
    }
}