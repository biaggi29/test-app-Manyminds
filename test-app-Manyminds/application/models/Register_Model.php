<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_Model extends CI_Model {

    public function list_users($limit, $offset) {
        $this->db->select('usuarios.*, enderecos.cep, enderecos.pais, enderecos.uf, enderecos.cidade, enderecos.rua, enderecos.numero');
        $this->db->from('usuarios');
        $this->db->join('enderecos', 'usuarios.id = enderecos.id_usuario', 'left');
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function register_user($data_post)
    {

        if (empty($data_post['nome'])) {
            return array('status' => 0, 'mensagem' => 'O campo nome é obrigatório!');
        }

        if (empty($data_post['sobrenome'])) {
            return array('status' => 0, 'mensagem' => 'O campo sobrenome é obrigatório, deve ter no mínimo 3 caracteres e não pode começar com números.');
        }

        if (empty($data_post['email'])) {
            return array('status' => 0, 'mensagem' => 'O campo e-mail é obrigatório e deve ser um endereço de e-mail válido.');
        }

        if ($this->is_email_exists($data_post['email'])) {
            return array('status' => 0, 'mensagem' => 'E-mail indisponível. Tente outro!');
        }

        if (!is_valid_cpf($data_post['cpf'])) {
            return array('status' => 0, 'mensagem' => 'CPF inválido!');
        }

        if (strlen($data_post['nascimento']) < 8) {
            return array('status' => 0, 'mensagem' => 'O campo nascimento precisa ser preenchido!');
        }

        if (strlen($data_post['telefone']) < 8) {
            return array('status' => 0, 'mensagem' => 'O campo telefone precisa ser preenchido!');
        }

        if (strlen($data_post['senha']) < 8 || $data_post['senha'] !== $data_post['confirmasenha']) {
            return array('status' => 0, 'mensagem' => 'A senha deve ter no mínimo 8 caracteres e as senhas devem coincidir.');
        }

        $valida = ['cep', 'pais', 'uf', 'cidade', 'rua', 'numero'];
        foreach ($valida as $campo) {
            if (empty($data_post[$campo])) {
                return array('status' => 0, 'mensagem' => 'O campo ' . ucfirst($campo) . ' é obrigatório e não pode ser vazio.');
            }
        }

        $this->db->trans_start();

        try {
            $id_usuario = $this->save_user($data_post);
            $this->save_address($id_usuario, $data_post);

            $this->db->trans_complete();

            return array('status' => 1, 'mensagem' => 'Usuário Cadastrado com sucesso!');
        } catch (Exception $e) {
            $this->db->trans_rollback();

            return array('status' => 0, 'mensagem' => 'Ocorreu algum problema!');
        }
    }

    private function save_user($data) {

        $nascimento_formatado = date('Y-m-d', strtotime(str_replace('/', '-', $data['nascimento'])));

        $user_data = array(
            'email'         => $data['email'],
            'senha'         => md5($data['senha']),
            'nome'          => $data['nome'],
            'sobrenome'     => $data['sobrenome'],
            'cpf'           => $data['cpf'],
            'nascimento'    => $nascimento_formatado,
            'telefone'      => $data['telefone'],
            'funcao'        => $data['funcao'],
            'status'        => $data['funcao'],
        );

        $this->db->insert('usuarios', $user_data);

        return $this->db->insert_id();
    }

    public function count_users() {
        return $this->db->count_all('usuarios');
    }

    private function save_address($id_usuario, $data) {
        $address_data = array(
            'id_usuario'    => $id_usuario,
            'cep'           => $data['cep'],
            'pais'          => $data['pais'],
            'uf'            => $data['uf'],
            'cidade'        => $data['cidade'],
            'rua'           => $data['rua'],
            'numero'        => $data['numero'],
        );

        $this->db->insert('enderecos', $address_data);
    }

    private function is_email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');

        return $query->num_rows() > 0;
    }
}