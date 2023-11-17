<?php $this->load->view('_header'); ?>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="col-lg-12">
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title">Registro</h4>
                        <form class="my-login-validation" method="post" action="<?php echo site_url('register/register'); ?>">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <input id="name" type="text" class="form-control" name="nome" value="<?php echo isset($post['nome'])?$post['nome']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="surname">Sobrenome</label>
                                        <input id="surname" type="text" class="form-control" name="sobrenome" value="<?php echo isset($post['sobrenome'])?$post['sobrenome']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input id="email" type="email" class="form-control" name="email" value="<?php echo isset($post['email'])?$post['email']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="cpf">CPF</label>
                                        <input id="cpf" type="text" class="form-control" name="cpf" value="<?php echo isset($post['cpf'])?$post['cpf']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="birthdate">Data de Nascimento</label>
                                        <input id="birthdate" type="text" class="form-control" name="nascimento" value="<?php echo isset($post['nascimento'])?$post['nascimento']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Telefone</label>
                                        <input id="phone" type="text" class="form-control" name="telefone" value="<?php echo isset($post['telefone'])?$post['telefone']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Função</label>
                                        <select id="role" class="form-control" name="funcao">
                                            <?php if (isset($post['funcao']) && $post['funcao'] == 1){ ?>
                                                <option value="1" selected>Administrador</option>
                                            <?php }else{ ?>
                                                <option value="1">Administrador</option>
                                            <?php } ?>
                                            <?php if (isset($post['funcao']) && $post['funcao'] == 2){ ?>
                                                <option value="2" selected>Colaborador</option>
                                            <?php }else{ ?>
                                                <option value="2">Colaborador</option>
                                            <?php } ?>
                                            <?php if (isset($post['funcao']) && $post['funcao'] == 3){ ?>
                                                <option value="3" selected>Fornecedor</option>
                                            <?php }else{ ?>
                                                <option value="3">Fornecedor</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Senha</label>
                                        <input id="password" type="password" class="form-control" name="senha" data-eye value="<?php echo isset($post['senha'])?$post['senha']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="password-2">Confirmar senha</label>
                                        <input id="password-2" type="password" class="form-control" name="confirmasenha" data-eye value="<?php echo isset($post['confirmasenha'])?$post['confirmasenha']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Status</label>
                                        <select id="status" class="form-control" name="status">
                                            <?php if (isset($post['status']) && $post['status'] == 1){ ?>
                                            <option value="1" selected>Ativo</option>
                                            <?php }else{ ?>
                                                <option value="1">Ativo</option>
                                            <?php } ?>
                                            <?php if (isset($post['status']) && $post['status'] == 2){ ?>
                                                <option value="0" selected>Inativo</option>
                                            <?php }else{ ?>
                                                <option value="0">Inativo</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="cep">CEP</label>
                                        <input id="cep" type="text" class="form-control" name="cep" value="<?php echo isset($post['cep'])?$post['cep']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="country">País</label>
                                        <input id="country" type="text" class="form-control" name="pais" value="<?php echo isset($post['pais'])?$post['pais']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="state">UF</label>
                                        <input id="state" type="text" class="form-control" name="uf" value="<?php echo isset($post['uf'])?$post['uf']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="city">Cidade</label>
                                        <input id="city" type="text" class="form-control" name="cidade" value="<?php echo isset($post['cidade'])?$post['cidade']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="street">Rua</label>
                                        <input id="street" type="text" class="form-control" name="rua" value="<?php echo isset($post['rua'])?$post['rua']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="number">Número</label>
                                        <input id="number" type="text" class="form-control" name="numero" value="<?php echo isset($post['numero'])?$post['numero']:'';?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-0">
                                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="footer">
                    Aplicação Teste - 2023
                </div>
            </div>
        </div>
    </div>
</section>
<?php if ($this->session->flashdata('mensagem')) { ?>
    <script>
        window.addEventListener("load", function() {
            Swal.fire(
                'Ops..',
                '<?php echo $this->session->flashdata('mensagem')['mensagem']; ?>',
                '<?php echo $this->session->flashdata('mensagem')['tipo']; ?>'
            );
        });
    </script>
<?php } ?>
<?php $this->load->view('_footer'); ?>
