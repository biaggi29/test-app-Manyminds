<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_Model extends CI_Model {

    public function toggle_product_status($idProduct) {
        $condicao = $this->db->where('id', $idProduct)->set('status', 'NOT status', FALSE)->update('produtos');
        return $condicao;
    }

    public function product_delete($idProduct) {
        $this->db->where('id', $idProduct);
        $this->db->delete('produtos');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function list_products($limit, $offset) {
        $this->db->select('*');
        $this->db->from('produtos');
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_product_by_id($id) {
        $this->db->select('*');
        $this->db->from('produtos');
        $this->db->where('id', $id);

        $query = $this->db->get();
        return $query->row_array();
    }

    public function register_product($data_post)
    {

        if (empty($data_post['nome'])) {
            return array('status' => 0, 'mensagem' => 'O campo nome é obrigatório!');
        }

        $preco = str_replace(',', '.', str_replace('.', '', $data_post['preco'])); // Remove pontos e substitui vírgulas por pontos
        if (!preg_match('/^\d+(\.\d{1,2})?$/', $preco)) {
            return array('status' => 0, 'mensagem' => 'Por favor, insira um preço válido!');
        }

        $this->db->trans_start();

        try {
            $this->save_product($data_post);

            $this->db->trans_complete();

            return array('status' => 1, 'mensagem' => 'Produto cadastrado com sucesso!');
        } catch (Exception $e) {
            $this->db->trans_rollback();

            return array('status' => 0, 'mensagem' => 'Ocorreu algum problema!');
        }
    }

    private function save_product($data) {

        $preco = str_replace(',', '.', str_replace('.', '', $data['preco']));
        $id_fornecedor = $this->session->userdata('logged_for')->id;
        $nome_fornecedor = $this->session->userdata('logged_for')->nome . ' ' . $this->session->userdata('logged_for')->sobrenome;

        $product_data = array(
            'nome'              => $data['nome'],
            'preco'             => $preco,
            'id_fornecedor'     => $id_fornecedor,
            'nome_fornecedor'   => $nome_fornecedor,
            'status'            => $data['status'],
        );

        $this->db->insert('produtos', $product_data);

        return $this->db->insert_id();
    }
 
    public function update_product($data_post, $id) {
        if (isset($id)) {
            return $this->update_existing_product($data_post, $id);
        }
    }

    private function update_existing_product($data, $id)
    {

        if (empty($data['nome'])) {
            return array('status' => 0, 'mensagem' => 'O campo nome é obrigatório!');
        }

        $preco = str_replace(',', '.', str_replace('.', '', $data['preco'])); // Remove pontos e substitui vírgulas por pontos
        if (!preg_match('/^\d+(\.\d{1,2})?$/', $preco)) {
            return array('status' => 0, 'mensagem' => 'Por favor, insira um preço válido!');
        }

        $preco = str_replace(',', '.', str_replace('.', '', $data['preco']));
        $id_fornecedor = $this->session->userdata('logged_for')->id;
        $nome_fornecedor = $this->session->userdata('logged_for')->nome . ' ' . $this->session->userdata('logged_for')->sobrenome;

        $product_data = array(
            'nome'              => $data['nome'],
            'preco'             => $preco,
            'id_fornecedor'     => $id_fornecedor,
            'nome_fornecedor'   => $nome_fornecedor,
            'status'            => $data['status'],
        );

        $this->db->where('id', $id);
        $table = $this->db->update('produtos', $product_data);

        if ($table) {
            return array('status' => 1, 'mensagem' => 'Produto atualizado com sucesso!');
        } else {
            return array('status' => 0, 'mensagem' => 'Falha ao atualizar o Produto.');
        }
    }

    public function count_products() {
        return $this->db->count_all('produtos');
    }

}