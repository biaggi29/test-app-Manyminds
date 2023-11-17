<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_Model extends CI_Model {

    public function validate_login($email, $senha)
    {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('email', $email);
        $user = $this->db->get()->row();

        $ip_address = $this->input->ip_address();
        $max_tentativas = 3;
        $periodo = 30; //30 segundos de bloqueio

        if ($this->is_max_login_attempts_exceeded($ip_address, $max_tentativas, $periodo)) {
            return array('status' => 0, 'msg' => 'Seu IP foi bloqueado temporariamente.');
        }

        if ($user && $user->status == 1) {
            if (md5($senha) == $user->senha) {
                $this->db->where('ip_address', $ip_address);
                $this->db->delete('login_attempts');

                return array('status' => 1, 'data' => $user);
            }
        }

        $data = array(
            'ip_address' => $ip_address,
            'login' => $email,
            'time' => date('Y-m-d H:i:s')
        );
        $this->db->insert('login_attempts', $data);

        return array('status' => 0, 'msg' => 'Login inválido!');
    }

    public function is_max_login_attempts_exceeded($ip_address, $max_tentativas, $periodo)
    {
        $this->db->where('ip_address', $ip_address);
        $this->db->order_by('time', 'desc');
        $first_attempt_query = $this->db->get('login_attempts');

        if ($first_attempt_query->num_rows() > 0) {
            $first_attempt_time = $first_attempt_query->row()->time;

            if (time() - strtotime($first_attempt_time) > $periodo) {
                $this->db->where('ip_address', $ip_address);
                $this->db->delete('login_attempts');
            }
        }

        $this->db->where('ip_address', $ip_address);
        $query = $this->db->get('login_attempts');
        if ($query->num_rows() >= $max_tentativas) {
            return true;
        }

        return false;
    }

    public function toggle_user_status($idUsuario) {
        $condicao = $this->db->where('id', $idUsuario)->set('status', 'NOT status', FALSE)->update('usuarios');
        return $condicao;
    }

    public function user_delete($idUsuario) {
        $usuario = $this->db->get_where('usuarios', array('id' => $idUsuario))->row();

        if ($usuario->funcao == 3) {
            $this->db->where('id_fornecedor', $idUsuario);
            $this->db->delete('produtos');
        }

        $this->db->where('id_usuario', $idUsuario);
        $this->db->delete('enderecos');

        $this->db->where('id', $idUsuario);
        $this->db->delete('usuarios');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function get_user_by_id($id) {
        $this->db->select('usuarios.*, enderecos.cep, enderecos.pais, enderecos.uf, enderecos.cidade, enderecos.rua, enderecos.numero');
        $this->db->from('usuarios');
        $this->db->join('enderecos', 'usuarios.id = enderecos.id_usuario', 'left');
        $this->db->where('usuarios.id', $id);

        $query = $this->db->get();
        return $query->row_array();
    }


    public function update_user($data_post, $id) {
        if (isset($id)) {
            return $this->update_existing_user($data_post, $id);
        }
    }

    private function update_existing_user($data, $id)
    {

        if (empty($data['nome'])) {
            return array('status' => 0, 'mensagem' => 'O campo nome é obrigatório!');
        }

        if (empty($data['sobrenome']) || !preg_match('/^[a-zA-ZÀ-ÿ\s]{2,}$/', $data['sobrenome'])) {
            return array('status' => 0, 'mensagem' => 'O campo sobrenome é obrigatório, deve ter no mínimo 2 caracteres e não pode começar com números!');
        }

        if (empty($data['email'])) {
            return array('status' => 0, 'mensagem' => 'O campo e-mail é obrigatório e deve ser um endereço de e-mail válido.');
        }

        if ($this->is_email_exists_update($data['email'], $id)) {
            return array('status' => 0, 'mensagem' => 'E-mail indisponível. Tente outro!');
        }

        if (!is_valid_cpf($data['cpf'])) {
            return array('status' => 0, 'mensagem' => 'CPF inválido!');
        }

        if (strlen($data['nascimento']) < 8) {
            return array('status' => 0, 'mensagem' => 'O campo nascimento precisa ser preenchido!');
        }

        if (strlen($data['telefone']) < 8) {
            return array('status' => 0, 'mensagem' => 'O campo telefone precisa ser preenchido!');
        }

        if ($data['senha'] !== $data['confirmasenha']) {
            return array('status' => 0, 'mensagem' => 'A senha deve ter no mínimo 8 caracteres e as senhas devem coincidir.');
        }

        $valida = ['cep', 'pais', 'uf', 'cidade', 'rua', 'numero'];
        foreach ($valida as $campo) {
            if (empty($data[$campo])) {
                return array('status' => 0, 'mensagem' => 'O campo ' . ucfirst($campo) . ' é obrigatório e não pode ser vazio.');
            }
        }

        $nascimento_formatado = date('Y-m-d', strtotime(str_replace('/', '-', $data['nascimento'])));

        $user_data = array(
            'nome' => $data['nome'],
            'sobrenome' => $data['sobrenome'],
            'cpf' => $data['cpf'],
            'nascimento' => $nascimento_formatado,
            'telefone' => $data['telefone']
        );

        if (!empty($data['status'])) {
            $user_data['status'] = $data['status'];
        }

        if (!empty($data['email'])) {
            $user_data['email'] = $data['email'];
        }

        if (!empty($data['senha'])) {
            $user_data['senha'] = md5($data['senha']);
        }

        $this->db->where('id', $id);
        $table1 = $this->db->update('usuarios', $user_data);

        $address_data = array(
            'cep' => $data['cep'],
            'pais' => $data['pais'],
            'uf' => $data['uf'],
            'cidade' => $data['cidade'],
            'rua' => $data['rua'],
            'numero' => $data['numero'],
        );

        $this->db->where('id_usuario', $id);

        //echo $this->db->last_query();
        $table2 = $this->db->update('enderecos', $address_data);

        if ($table1 && $table2) {
            return array('status' => 1, 'mensagem' => 'Usuário atualizado com sucesso!');
        } else {
            return array('status' => 0, 'mensagem' => 'Falha ao atualizar o usuário.');
        }
    }

    private function is_email_exists_update($email, $id_usuario) {
        $this->db->where('email', $email);
        $this->db->where('id !=', $id_usuario);
        $query = $this->db->get('usuarios');

        return $query->num_rows() > 0;
    }

}