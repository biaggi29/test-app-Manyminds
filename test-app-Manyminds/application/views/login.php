<?php $this->load->view('_header'); ?>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Administração</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Gerenciar usuários</h6>
                            <form method="post" action="<?php echo site_url('login/login'); ?>" id="loginForm" class="my-login-validation">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <?php echo form_input(
                                        array(
                                            'name'          => 'email',
                                            'class'         => 'form-control',
                                            'id'            => 'email',
                                            'placeholder'   => 'superadmin@gmail.com',
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
                                            'placeholder'   => 'pass123',
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