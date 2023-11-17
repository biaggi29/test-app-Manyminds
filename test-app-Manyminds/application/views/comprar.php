<?php $this->load->view('_header'); ?>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="col-md-12">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title">Fornecedores</h4>
                            <div>
                                <?php if (!empty($this->session->userdata('carrinho'))){ ?>
                                    <a href="<?php echo base_url('comprar/limpar'); ?>" class="btn btn-danger">Limpar Carrinho</a>
                                <?php } ?>
                                <a href="<?php echo base_url('meus-pedidos'); ?>" class="btn btn-secondary">Meus Pedidos</a>
                            </div>
                        </div>


                        <?php foreach ($fornecedores as $fornecedor): ?>
                            <div class="card mb-3">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title"><?php echo ucwords($fornecedor['nome'] . ' ' . $fornecedor['sobrenome']); ?></h5>

                                        <?php if ($fornecedor['status'] == 1): ?>
                                            <a href="<?php echo site_url('comprar/fornecedor/' . $fornecedor['id']); ?>" class="btn btn-primary">
                                                <i class="fa fa-shopping-cart"></i> Ver Produtos
                                            </a>
                                        <?php else: ?>
                                            <button disabled class="btn btn-primary">
                                                <i class="fa fa-shopping-cart"></i> Ver Produtos
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($fornecedor['status'] == 1): ?>
                                        <button disabled type="button" class="btn btn-success">Ativo</button>
                                    <?php else: ?>
                                        <button disabled type="button" class="btn btn-danger">Inativo</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

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
