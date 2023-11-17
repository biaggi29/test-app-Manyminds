<?php $this->load->view('_header'); ?>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Login</h4>
                            <ul>
                                <ul>
                                    <li><strong>Colaborador:</strong> Realiza Pedidos.</li>
                                    <li><strong>Fornecedor:</strong> Cadastra Produtos.</li>
                                </ul>
                            </ul>
                            <form method="POST" action="<?php echo site_url('home/login_home'); ?>" class="my-login-validation">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <?php echo form_input(
                                        array(
                                            'name'          => 'email',
                                            'class'         => 'form-control',
                                            'id'            => 'email',
                                            'placeholder'   => 'user@dominio.com',
                                            'type'          => 'email'
                                        )
                                    ); ?>
                                </div>

                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    <?php echo form_input(
                                        array(
                                            'name'          => 'password',
                                            'class'         => 'form-control',
                                            'id'            => 'password',
                                            'placeholder'   => 'Senha',
                                            'type'          => 'password',
                                            'data-eye'      => 'data-eye'
                                        )
                                    ); ?>
                                </div>
                                <div class="form-group m-0">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Login
                                    </button>
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