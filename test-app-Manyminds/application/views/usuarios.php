<?php $this->load->view('_header'); ?>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="col-md-12">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">Usuários (Administrador, Colaboradores e Fornecedores)</h4>
                            <?php if (
                                $this->session->userdata('logged_adm') &&
                                $this->session->userdata('logged_adm')->funcao == '1' &&
                                $this->session->userdata('logged_adm')->status == '1'
                            ){ ?>
                                <a href="<?php echo base_url('register');?>" style="margin-top: auto;" class="btn btn-success">Novo cadastro</a>
                            <?php } ?>
                        </div>
                        <div>
                            <p>Apenas o administrador cadastra novos usuários</p>
                        </div>
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Sobrenome</th>
                                <th>E-mail</th>
                                <th>CPF</th>
                                <th>Data de nascimento</th>
                                <th>Função</th>
                                <th>Editar</th>
                                <th>Status</th>
                                <th>Excluir</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?php echo $usuario['id']; ?></td>
                                    <td><?php echo $usuario['nome']; ?></td>
                                    <td><?php echo $usuario['sobrenome']; ?></td>
                                    <td><?php echo $usuario['email']; ?></td>
                                    <td><?php echo $usuario['cpf']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($usuario['nascimento'])); ?></td>
                                    <td><?php echo ($usuario['funcao'] == 1) ? 'Administrador' : (($usuario['funcao'] == 2) ? 'Colaborador' : 'Fornecedor'); ?></td>

                                    <td>
                                        <?php if ($usuario['funcao'] == 1 && $usuario['status'] == 1): ?>
                                            <a href="<?php echo base_url('usuario/update/'.$usuario['id']); ?>" class="btn btn-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        <?php elseif($usuario['status'] == 1 && $usuario['funcao'] == 2): ?>
                                            <a href="<?php echo base_url('usuario/update/'.$usuario['id']); ?>" class="btn btn-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        <?php elseif($usuario['status'] == 1 && $usuario['funcao'] == 3): ?>
                                            <a href="<?php echo base_url('usuario/update/'.$usuario['id']); ?>" class="btn btn-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-danger" disabled>
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (($usuario['status'] == 1 && $usuario['funcao'] == 2) || ($usuario['status'] == 1 && $usuario['funcao'] == 3)): ?>
                                            <button data-status="<?php echo $usuario['id']; ?>" type="button" class="btn btn-primary">Ativo</button>
                                        <?php elseif ($usuario['status'] == 1 && $usuario['funcao'] != 2): ?>
                                            <button disabled data-status="<?php echo $usuario['id']; ?>" type="button" class="btn btn-primary">Ativo</button>
                                        <?php elseif ($usuario['status'] == 0 && $usuario['funcao'] == 3): ?>
                                            <button data-status="<?php echo $usuario['id']; ?>" type="button" class="btn btn-danger">Inativo</button>
                                        <?php elseif ($usuario['status'] == 0 && $usuario['funcao'] != 2): ?>
                                            <button disabled data-status="<?php echo $usuario['id']; ?>" type="button" class="btn btn-danger">Inativo</button>
                                        <?php else: ?>
                                            <button data-status="<?php echo $usuario['id']; ?>" type="button" class="btn btn-danger">Inativo</button>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($usuario['id'] != 1 && $usuario['funcao'] != 2 && $usuario['status'] == 1): ?>
                                            <button data-delete="<?php echo $usuario['id']; ?>" class="btn btn-danger btn-excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php elseif($usuario['funcao'] != 2 && $usuario['status'] == 0): ?>
                                            <button data-delete="<?php echo $usuario['id']; ?>" class="btn btn-danger btn-excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                        <div class="pagination">
                            <?php echo $links; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    window.addEventListener("load", function() {
        $('[data-status]').on('click', function() {
            const idUsuario = $(this).data('status');
            $.ajax({
                url: '<?php echo base_url('usuarios/status'); ?>',
                type: 'POST',
                data: {id: idUsuario},
                success: function(response) {
                    location.reload();
                }
            });
        });
    });

    window.addEventListener("load", function() {
        $('[data-delete]').on('click', function() {
            const idUsuario = $(this).data('delete');
            Swal.fire({
                title: 'Você tem certeza?',
                text: 'Essa ação é irreversível!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url('usuarios/delete'); ?>',
                        type: 'POST',
                        data: {id: idUsuario},
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Exclusão bem-sucedida!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    });
</script>
<?php if ($this->session->flashdata('mensagem')) { ?>
    <script>
        window.addEventListener("load", function() {
            Swal.fire(
                'Sucesso',
                '<?php echo $this->session->flashdata('mensagem')['mensagem']; ?>',
                '<?php echo $this->session->flashdata('mensagem')['tipo']; ?>'
            );
        });
    </script>
<?php } ?>
<?php $this->load->view('_footer'); ?>
