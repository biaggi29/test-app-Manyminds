<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprar_Model extends CI_Model {

    public function list_fornecedores() {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('funcao', 3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_fornecedor($id) {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }

    public function get_produtos_fornecedor($id_fornecedor) {
        $this->db->select('*');
        $this->db->from('produtos');
        $this->db->where('id_fornecedor', $id_fornecedor);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_produto_by_id($id_produto) {
        $this->db->select('*');
        $this->db->from('produtos');
        $this->db->where('id', $id_produto);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function criar_pedido($id_colaborador, $valor_total, $status) {
        $dados_pedido = array(
            'id_colaborador' => $id_colaborador,
            'valor_total' => $valor_total,
            'status' => $status
        );

        $this->db->insert('pedidos', $dados_pedido);

        return $this->db->insert_id();
    }

    public function adicionar_item_pedido($pedido_id, $item) {
        $dados_item = array(
            'id_pedido' => $pedido_id,
            'id_produto' => $item['id_produto'],
            'nome' => $item['nome'],
            'preco' => $item['preco'],
            'id_fornecedor' => $item['id_fornecedor'],
            'nome_fornecedor' => $item['nome_fornecedor'],
            'quantidade' => $item['quantidade'],
            'observacoes' => $item['observacoes']
        );

        $this->db->insert('pedidos_produtos', $dados_item);
    }

    public function listar_pedidos_itens($id_colaborador) {
        $this->db->select('pedidos.id as pedido_id, pedidos.id_colaborador, pedidos.valor_total, pedidos.status, pedidos_produtos.id as item_id, pedidos_produtos.nome, pedidos_produtos.preco, pedidos_produtos.id_fornecedor, pedidos_produtos.nome_fornecedor, pedidos_produtos.quantidade, pedidos_produtos.observacoes');
        $this->db->from('pedidos');
        $this->db->join('pedidos_produtos', 'pedidos.id = pedidos_produtos.id_pedido');
        $this->db->where('pedidos.id_colaborador', $id_colaborador);

        $query = $this->db->get();
        $result = $query->result_array();

        $pedidos_itens = [];

        foreach ($result as $row) {
            $pedido_id = $row['pedido_id'];
            if (!isset($pedidos_itens[$pedido_id])) {
                $pedidos_itens[$pedido_id] = [
                    'pedido' => [
                        'id' => $row['pedido_id'],
                        'id_colaborador' => $row['id_colaborador'],
                        'valor_total' => $row['valor_total'],
                        'status' => $row['status'],
                    ],
                    'itens' => []
                ];
            }

            // Adiciona o item ao pedido
            $pedidos_itens[$pedido_id]['itens'][] = [
                'id' => $row['item_id'],
                'nome' => $row['nome'],
                'preco' => $row['preco'],
                'id_fornecedor' => $row['id_fornecedor'],
                'nome_fornecedor' => $row['nome_fornecedor'],
                'quantidade' => $row['quantidade'],
                'observacoes' => $row['observacoes'],
            ];
        }

        return $pedidos_itens;
    }

    public function toggle_order_status($idPedido) {
        $condicao = $this->db->where('id', $idPedido)->set('status', 'NOT status', FALSE)->update('pedidos');
        return $condicao;
    }

    public function get_all_pedidos() {
        $query = $this->db->get('pedidos');
        return $query->result_array();
    }

    public function get_itens_pedido($id_pedido) {
        $this->db->where('id_pedido', $id_pedido);
        $query = $this->db->get('pedidos_produtos');
        return $query->result_array();
    }

    public function order_delete($idPedido) {
        $this->db->where('id_pedido', $idPedido);
        $this->db->delete('pedidos_produtos');

        $this->db->where('id', $idPedido);
        $this->db->delete('pedidos');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Metodos para o carrinho
    public function adicionar_item($item) {
        $carrinho = $this->session->userdata('carrinho') ?? [];
        $id_produto = $item['id_produto'];

        if (isset($carrinho[$id_produto])) {
            $carrinho[$id_produto]['quantidade'] += $item['quantidade']; // att quantidade
            $carrinho[$id_produto]['observacoes'] = $item['observacoes']; // att observacao
        } else {
            $carrinho[$id_produto] = $item;
        }

        $this->session->set_userdata('carrinho', $carrinho);
    }

    public function remover_item($id_produto) {
        $carrinho = $this->session->userdata('carrinho') ?? [];

        if (isset($carrinho[$id_produto])) {
            unset($carrinho[$id_produto]);
            $this->session->set_userdata('carrinho', $carrinho);
        }
    }

    public function obter_carrinho() {
        return $this->session->userdata('carrinho') ?? [];
    }

    public function limpar_carrinho() {
        $this->session->unset_userdata('carrinho');
    }
}