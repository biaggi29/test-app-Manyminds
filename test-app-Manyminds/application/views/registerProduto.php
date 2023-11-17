<?php $this->load->view('_header'); ?>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="col-lg-6">
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title">Cadastrando Produto</h4>
                        <form class="my-login-validation" method="post" action="<?php echo site_url('produtos/register'); ?>">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input id="nome" type="text" class="form-control" name="nome" value="<?php echo isset($post['nome'])?$post['nome']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="surname">Fornecedor</label>
                                        <input disabled id="nome_fornecedor" type="text" class="form-control" name="nome_fornecedor" value="<?php echo isset($post['nome_fornecedor'])?$post['nome_fornecedor']:$nome_fornecedor;?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="preco">Preço</label>
                                        <input id="preco" type="text" class="form-control" name="preco" value="<?php echo isset($post['preco'])?$post['preco']:'';?>">
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
                            </div>

                            <div class="form-group m-0">
                                <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
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
