<?php $this->load->view('_header'); ?>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="col-md-5">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">Produtos</h4>
                            <?php if (
                                $this->session->userdata('logged_for') &&
                                $this->session->userdata('logged_for')->funcao == '3' &&
                                $this->session->userdata('logged_for')->status == '1'
                            ){ ?>
                                <a href="<?php echo base_url('produtos/register');?>" style="margin-top: auto;" class="btn btn-success">Novo Produto</a>
                            <?php } ?>
                        </div>

                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Fornecedor</th>
                                <th>Editar</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($produtos as $produto): ?>
                                <tr>
                                    <td><?php echo $produto['id']; ?></td>
                                    <td><?php echo $produto['nome']; ?></td>
                                    <td><?php echo $produto['nome_fornecedor']; ?></td>

                                    <td>
                                        <?php if ($produto['status'] == 1): ?>
                                            <a href="<?php echo base_url('produtos/update/'.$produto['id']); ?>" class="btn btn-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        <?php else: ?>
                                            <button href="<?php echo base_url('produtos/update/'.$produto['id']); ?>" type="button" class="btn btn-danger" disabled>
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($produto['status'] == 1): ?>
                                            <button data-status="<?php echo $produto['id']; ?>" type="button" class="btn btn-primary">Ativo</button>
                                        <?php else: ?>
                                            <button data-status="<?php echo $produto['id']; ?>" type="button" class="btn btn-danger">Inativo</button>
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
                url: '<?php echo base_url('produtos/status'); ?>',
                type: 'POST',
                data: {id: idUsuario},
                success: function(response) {
                    location.reload();
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
