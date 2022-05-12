<?php echo $this->extend('layout/principal_web'); ?>

<!-- Aqui enviamos para o template principal o título -->
<?php echo $this->section('titulo'); ?>

  <?php echo $titulo; ?>

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os estilos -->
<?php echo $this->section('estilos'); ?>

    <link rel="stylesheet" href="<?php echo site_url('web/src/assets/css/produto.css'); ?>"/>

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal o conteúdo -->
<?php echo $this->section('conteudo'); ?>

<div class="container">
    <!-- product -->
    <div class="product-content product-wrap clearfix product-deatil">
        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="product-image">
                
                    <img src="<?php echo site_url("produto/imagem/$produto->imagem"); ?>" alt="<?php echo esc($produto->nome); ?>" />
                
                </div>
            </div>

            <?php echo form_open('adicionar/carrinho'); ?>

                <div class="col-md-7 col-md-offset-1 col-sm-12 col-xs-12">
                    <h2 class="name">
                        <?php echo esc($produto->nome); ?>
                    </h2>
                    <hr />
                    <h3 class="price-container">

                        <p class="small">Escolha o valor</p>

                        <?php foreach ($especificacoes as $especificacao): ?>
                            
                            <div class="radio">
                            
                                <label style="font-size: 16px">
                                    <input type="radio" style="margin-top: 2px" style="margin-top: 2px" class="especificacao" data-especificacao="<?php echo esc($especificacao->especificacao_id); ?>" 
                                        name="produto[preco]" value="<?php echo esc(number_format($especificacao->preco, 2)); ?>">
                                            <?php echo esc($especificacao->nome); ?>
                                            R$&nbsp;<?php echo esc(number_format($especificacao->preco, 2)); ?>
                                </label>
                        
                            </div>
                        
                        <?php endforeach; ?>

                        <?php if (isset($extras)): ?>

                            <hr>

                            <p class="small">Extras do produto</p>

                            <div class="radio" style="font-size: 16px">
                                
                                <label>
                                    <input type="radio" style="margin-top: 2px" class="extra" name="extra" checked >Sem extra
                                </label>
                        
                            </div>

                            <?php foreach ($extras as $extra): ?>
                                
                                <div class="radio">
                                
                                    <label style="font-size: 16px">
                                        <input type="radio" style="margin-top: 2px" class="extra" data-extra="<?php echo esc($extra->id_principal); ?>" 
                                            name="extra" value="<?php echo esc(number_format($extra->preco, 2)); ?>">
                                                <?php echo esc($extra->nome); ?>
                                                R$&nbsp;<?php echo esc(number_format($extra->preco, 2)); ?>
                                    </label>
                            
                                </div>
                            
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </h3>
                    
                    <hr />
                    
                    <div class="description description-tabs">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" style="font-size: 16px" id="more-information">
                                <br />
                                <strong>É uma delícia</strong>
                                <p>
                                    <?php echo esc($produto->ingredientes); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div>
                        
                        <!-- Campos hidden que usaremos no controller -->
                        <input type="text" name="produto[slug]" placeholder="produto[slug]" value="<?php echo $produto->slug; ?>" />
                        <input type="text" id="especificacao_id" placeholder="produto[especificacao_id]" name="produto[especificacao_id]" />
                        <input type="text" id="extra_id" placeholder="produto[extra_id]" name="produto[extra_id]" />
                        
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <input id="btn-adiciona" type="submit" class="btn btn-success btn-lg" value="Adicionar ao carrinho" placeholder="produto[extra_id]" name="produto[extra_id]" />
                        </div>
                        <div class="col-sm-4">
                            <a href="<?php echo site_url('/'); ?>" class="btn btn-info btn-lg">Mais delícias</a>
                        </div>
                    </div>
                </div>

            <?php echo form_close(); ?>

        </div>
    </div>
    <!-- end product -->
</div>



    <!-- End Sections -->

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?php echo $this->section('scripts'); ?>

<script>

    $(document).ready(function() {

        var especificacao_id;

        if (!especificacao_id) {

            $('#btn-adiciona').prop('disabled', true);
            $('#btn-adiciona').prop('value', 'Selecione um valor');
        }

        $(".especificacao").on('click', function () {

            especificacao_id = $(this).attr('data-especificacao');

            $("#especificacao_id").val(especificacao_id);

            $('#btn-adiciona').prop('disabled', false);
            $('#btn-adiciona').prop('value', 'Adicionar ao carrinho');

        });

        $(".extra").on('click', function () {

            var extra_id = $(this).attr('data-extra');

            $("#extra_id").val(extra_id);

        });

    });

</script>

<?php echo $this->endSection(); ?><!-- Begin Sections-->