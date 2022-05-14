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

<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">
    <div class="col-sm-8 col-md-offset-2">
        <!-- product -->
        <div class="product-content product-wrap clearfix product-deatil">
            <div class="row">

                <h2 class="name">
                    <?php echo esc($titulo); ?>
                </h2>


                <?php echo form_open('carrinho/especial'); ?>

                    <div class="row" style="min-height: 500px">

                        <div class="col-md-12" style="margin-bottom: 2em">

                            <?php if (session()->has('errors_model')): ?>
                                <ul style="list-style: decimal">
                                    <?php foreach (session('errors_model') as $error): ?>
                                        <li class="text-danger"><?php echo $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                        </div>

                        <div class="col-md-6">

                            <div id="imagemPrimeiroProduto" style="margin-bottom: 1em;">
                                <img class="img-reponsive center-block d-block mx-auto" src="<?php echo site_url("web/src/assets/img/escolha_produto.png"); ?>" width="200" alt="Escolha o produto" />
                            </div>
                        
                            <label>Escolha a primeira metade do produto</label>
                            <select id="primeira_metade" class="form-control" name="primeira_metade">

                                <option value="">Escolha seu produto..</option>

                                <?php foreach ($opcoes as $opcao): ?>

                                    <option value="<?php echo $opcao->id; ?>"><?php echo esc($opcao->nome); ?></option>

                                <?php endforeach; ?>
                                
                            </select>              

                        </div>

                        <div class="col-md-6">

                            <div id="imagemSegundoProduto" style="margin-bottom: 1em;">
                                <img class="img-reponsive center-block d-block mx-auto" src="<?php echo site_url("web/src/assets/img/escolha_produto.png"); ?>" width="200" alt="Escolha o produto" />
                            </div>
                        
                            <label>Escolha segunda metade</label>
                            <select id="segunda_metade" class="form-control" name="segunda_metade">

                                <!-- Aqui serão renderizadas as opções para compor a segunda metade, via javascript -->
                            
                                
                            </select>              

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-3">
                            <input id="btn-adiciona" type="submit" class="btn btn-success" value="Adicionar"/>
                        </div>

                        <div class="col-sm-3">
                            <a href="<?php echo site_url("produto/detalhes/$produto->slug"); ?>" class="btn btn-info">Voltar</a>
                        </div>

                    </div>

                <?php echo form_close(); ?>

            </div>
        </div>
        <!-- end product -->
    </div>  
</div>



    <!-- End Sections -->

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?php echo $this->section('scripts'); ?>

<script>

    $(document).ready(function() {

        $('#btn-adiciona').prop('disabled', true);
        $('#btn-adiciona').prop('value', 'Selecione um tamanho');

        $("#primeira_metade").on('change', function () {

            var primeira_metade = $(this).val();

            var categoria_id = '<?php echo $produto->categoria_id; ?>';

            $("#imagemPrimeiroProduto").html('<img class="img-reponsive center-block d-block mx-auto" src="<?php echo site_url("web/src/assets/img/escolha_produto.png"); ?>" width="200" alt="Escolha o produto" />');

            if (primeira_metade) {

                $.ajax({
                    type: 'get',
                    url: '<?php echo site_url('produto/procurar'); ?>',
                    dataType: 'json',
                    data: {
                        primeira_metade: primeira_metade,
                        categoria_id: categoria_id,
                    },
                    beforeSend: function (data) {

                        if (data.produtos) {
                            $("#segunda_metade").html('');
                        }
                    },
                    success: function (data) {

                        if (data.imagemPrimeiroProduto) {
                            
                            $('#imagemPrimeiroProduto').html('<img class="img-reponsive center-block d-block mx-auto" src="<?php echo site_url("produto/imagem/"); ?>' + data.imagemPrimeiroProduto + '" width="200" alt="Escolha o produto" />');

                        }

                        if (data.produtos) {
                            $("#segunda_metade").html('<option>Escolha a segunda metade..</option>');

                            $(data.produtos).each(function () {
                                var option = $('<option/>');

                                option.attr('value', this.id).text(this.nome);

                                $("#segunda_metade").append(option);
                            });

                        } else {
                            $("#segunda_metade").html('<option>Não encontramos opções de customização..</option>');
                        }
                    },
                });

            } else {

                /* Cliente não escolheu a primeira_metade */
                $("#segunda_metade").html('<option>Escolha a primeira metade..</option>');
                $("#imagemSegundoProduto").html('<img class="img-reponsive center-block d-block mx-auto" src="<?php echo site_url("web/src/assets/img/escolha_produto.png"); ?>" width="200" alt="Escolha o produto" />');

            }

        });

        $("#segunda_metade").on('change', function () {

            var primeiro_produto_id = $("#primeira_metade").val();
            var segundo_produto_id = $("#segunda_metade").val();

            $("#imagemSegundoProduto").html('<img class="img-reponsive center-block d-block mx-auto" src="<?php echo site_url("web/src/assets/img/escolha_produto.png"); ?>" width="200" alt="Escolha o produto" />');

            if (segundo_produto_id && segundo_produto_id) {

                $.ajax({
                    type: 'get',
                    url: '<?php echo site_url('produto/exibetamanhos'); ?>',
                    dataType: 'json',
                    data: {
                        primeiro_produto_id: primeiro_produto_id,
                        segundo_produto_id: segundo_produto_id,
                    },
                    beforeSend: function (data) {
                        
                    },
                    success: function (data) {

                        if (data.imagemSegundoProduto) {
                            
                            $('#imagemSegundoProduto').html('<img class="img-reponsive center-block d-block mx-auto" src="<?php echo site_url("produto/imagem/"); ?>' + data.imagemSegundoProduto + '" width="200" alt="Escolha o produto" />');

                        }

                    },
                });
            }
        });

    });

</script>

<?php echo $this->endSection(); ?><!-- Begin Sections-->