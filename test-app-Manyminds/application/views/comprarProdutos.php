<?php $this->load->view('_header'); ?>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="col-md-12">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title">Fornecedor: <?php echo $nome_fornecedor; ?></h4>
                            <div>
                                <?php if (!empty($this->session->userdata('carrinho'))){ ?>
                                    <a href="<?php echo base_url('comprar/limpar'); ?>" class="btn btn-danger">Limpar Carrinho</a>
                                <?php } ?>
                                <a href="<?php echo base_url('meus-pedidos'); ?>" class="btn btn-secondary">Meus Pedidos</a>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Produtos</h5>
                                <?php foreach ($produtos as $produto): ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $produto['nome']; ?></h6>
                                            <p class="card-text">Preço: $<?php echo number_format($produto['preco'], 2); ?> - Status: <?php echo $produto['status'] == 1 ? 'Ativo' : 'Inativo'; ?></p>
                                            <?php if ($produto['status']){ ?>
                                                <input type="number" value="1" min="1" class="form-control" placeholder="Quantidade">
                                                <textarea class="form-control" placeholder="Observações"></textarea>
                                                <button class="btn btn-primary mt-2 adicionar-ao-carrinho" data-produto="<?php echo $produto['id']; ?>">Adicionar ao Carrinho</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <?php if (!empty($itens)){ ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Itens</h5>
                                    <ul>
                                        <?php foreach ($itens as $item): ?>
                                            <li>
                                                <?php echo $item['nome']; ?> -
                                                $<?php echo number_format($item['preco'], 2); ?> -
                                                Fornecedor <?php echo $item['nome_fornecedor']; ?> -
                                                Quantidade: <?php echo $item['quantidade']; ?>
                                                <?php if (!empty($item['observacoes'])){ ?>
                                                    -
                                                    Observação: <?php echo $item['observacoes']; ?>
                                                <?php } ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span>Total do pedido: $ <?php echo number_format($total_pedido, 2); ?></span>

                            <?php if ($itens_no_carrinho): ?>
                                <a href="<?php echo site_url('comprar/finalizar'); ?>" class="btn btn-success">Finalizar Compra</a>
                            <?php else: ?>
                                <button class="btn btn-success" disabled>Finalizar Compra</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    window.addEventListener("load", function() {
        $('.adicionar-ao-carrinho').on('click', function () {
            let id_produto = $(this).data('produto');
            let quantidade = $(this).siblings('input[type="number"]').val();
            let observacoes = $(this).siblings('textarea').val();
            let produto = {
                'id_produto': id_produto,
                'quantidade': quantidade,
                'observacoes': observacoes
            };
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('comprar/adicionar'); ?>',
                data: produto,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Produto Adicionado ao Carrinho!',
                        showConfirmButton: true,
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    });
</script>
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
