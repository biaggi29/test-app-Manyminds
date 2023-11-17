<?php $this->load->view('_header'); ?>
<section class="h-100">
<div class="container h-100" style="margin-top: 100px;">
    <div class="row justify-content-md-center h-100">
        <div class="col-md-12">
            <?php foreach ($pedidos_itens as $pedido_item): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Pedido #<?php echo $pedido_item['pedido']['id']; ?></h5>
                            <p class="card-text">Valor Total: $ <?php echo $pedido_item['pedido']['valor_total']; ?></p>
                            <div class="d-flex">
                                <div style="margin-right: 5px;">
                                    <?php if ($pedido_item['pedido']['status'] == 1): ?>
                                        <button data-status="<?php echo $pedido_item['pedido']['id']; ?>" type="button" class="btn btn-primary">Ativo</button>
                                    <?php else: ?>
                                        <button disabled data-status="<?php echo $pedido_item['pedido']['id']; ?>" type="button" class="btn btn-danger">Finalizado</button>
                                    <?php endif; ?>
                                </div>
                                <?php if ($pedido_item['pedido']['status'] == 1): ?>
                                    <button data-delete="<?php echo $pedido_item['pedido']['id']; ?>" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php else: ?>
                                    <button disabled class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <ul>
                            <?php foreach ($pedido_item['itens'] as $item): ?>
                                <li>
                                    <?php echo $item['nome']; ?> -
                                    $<?php echo number_format($item['preco'], 2); ?> -
                                    Fornecedor <?php echo $item['nome_fornecedor']; ?> -
                                    Quantidade: <?php echo $item['quantidade']; ?>
                                    <?php if (!empty($item['observacoes'])): ?>
                                        - Observação: <?php echo $item['observacoes']; ?>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>
</section>
<script>
window.addEventListener("load", function() {
    $('[data-delete]').on('click', function() {
        const idPedido = $(this).data('delete');
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
                    url: '<?php echo base_url('comprar/pedido_delete'); ?>',
                    type: 'POST',
                    data: {id: idPedido},
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Exclusão bem-sucedida!',
                            showConfirmButton: true,
                        }).then(function () {
                            location.reload();
                        });
                    }
                });
            }
        });
    });
});

window.addEventListener("load", function() {
    $('[data-status]').on('click', function() {
        const idPedido = $(this).data('status');
        $.ajax({
            url: '<?php echo base_url('comprar/pedido_status'); ?>',
            type: 'POST',
            data: {id: idPedido},
            success: function() {
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