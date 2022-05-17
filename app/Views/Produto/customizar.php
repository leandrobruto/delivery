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

                    <div class="row">

                        <div class="col-md-12" style="margin-top: 1em; bottom: 2em">

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

                        <div class="col-md-6">

                            <div id="valor_produto_customizado" style="margin-top: 3em; font-size: 18px; color: #990100; font-family: 'Montserrat-Bold';">
                            
                                <!-- Aqui será renderizado via Javascript o valor do produto -->

                            </div>
                                    
                        </div>

                    </div>

                    <div class="row" style="margin-top: 3em; margin-bottom: 3em">
                    
                        <div class="col-md-6">
                            
                            <label>Tamanho do produto</label>
                            <select id="tamanho" class="form-control" name="tamanho">

                                <!-- Aqui serão renderizadas as opções tamanho do produto, via javascript -->

                                
                            </select>              

                        </div>

                        <div class="col-md-6">
                            
                            <div id="boxInfoExtras" style="display:none">
                            
                                <label>Extras</label>

                                <div class="radio"><label><input type="radio" class="extra" name="extra" checked="">Sem extra</label></div>
                                
                                <div id="extras">

                                    <!-- Aqui serão renderizados os extras do produto, via javascript -->

                                </div>

                            </div>

                        </div>
                                        
                    </div>

                    <div>

                        <input type="hidden" id="extra_id" name="extra_id" placeholder="extra_id_hidden">
                        
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

        $('#segunda_metade').html('<option>Escolha a primeira metade..</option>');
        $('#tamanho').html('<option>Escolha a segunda metade..</option>');

        $("#primeira_metade").on('change', function () {

            var primeira_metade = $(this).val();

            var categoria_id = '<?php echo $produto->categoria_id; ?>';

            $("#imagemPrimeiroProduto").html('<img class="img-reponsive center-block d-block mx-auto" src="<?php echo site_url("web/src/assets/img/escolha_produto.png"); ?>" width="200" alt="Escolha o produto" />');
            $("#imagemSegundoProduto").html('<img class="img-reponsive center-block d-block mx-auto" src="<?php echo site_url("web/src/assets/img/escolha_produto.png"); ?>" width="200" alt="Escolha o produto" />');

            $('#valor_produto_customizado').html('');
            $('#tamanho').html('<option>Escolha a segunda metade..</option>');

            $("#boxInfoExtras").hide();
            $("#extras").html('');

            $('#btn-adiciona').prop('disabled', true);
            $('#btn-adiciona').prop('value', 'Selecione um tamanho');

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
          
            $('#valor_produto_customizado').html('');
            $('#tamanho').html('<option>Escolha a segunda metade..</option>');

            $("#boxInfoExtras").hide();
            $("#extras").html('');

            $('#btn-adiciona').prop('disabled', true);
            $('#btn-adiciona').prop('value', 'Selecione um tamanho');

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

                        if (data.medidas) {
                            $("#tamanho").html('<option value="">Escolha o tamanho do produto..</option>');

                            $(data.medidas).each(function () {
                                var option = $('<option/>');

                                option.attr('value', this.id).text(this.nome);

                                $("#tamanho").append(option);
                            });

                        } else {
                            $("#tamanho").html('<option>Escolha a segunda metade do produto..</option>');
                        }

                        if (data.extras) {
                            $("#boxInfoExtras").show();

                            $(data.extras).each(function () {
                                
                                var input = "<div class='radio'><label><input type='radio' class='extra' name='extra' data-extra='" + this.id + "' value='" + this.preco + "'>" + this.nome + ' - R$ ' + this.preco + "</label></div>"; 
                                                                
                                $("#extras").append(input);
                            });

                            $(".extra").on('click', function () {

                                var extra_id = $(this).attr('data-extra');

                                $("#extra_id").val(extra_id);

                                /* Capturamos o tamanho escolhido */
                                var medida_id = $("#tamanho").val();
                                
                                if ($.isNumeric(medida_id)) {
                                    $.ajax({
                                        type: 'get',
                                        url: '<?php echo site_url('produto/exibevalor'); ?>',
                                        dataType: 'json',
                                        data: {
                                            medida_id: medida_id,
                                            extra_id: $("#extra_id").val(),
                                        },
                                        success: function (data) {
                                            
                                            if (data) {
                                                $("#valor_produto_customizado").html('R$ ' + data.preco);

                                                $('#btn-adiciona').prop('disabled', false);
                                                $('#btn-adiciona').prop('value', 'Adicionar ao carrinho');
                                            }
                                        },

                                    });
                                }

                            });
                        }

                    },
                });
            }
        });

        $("#tamanho").on("change", function () {

            $('#btn-adiciona').prop('disabled', true);
            $('#btn-adiciona').prop('value', 'Selecione um tamanho');

            var medida_id = $(this).val();

            $("#valor_produto_customizado").html('');

            if (medida_id) {

                $.ajax({
                    type: 'get',
                    url: '<?php echo site_url('produto/exibevalor'); ?>',
                    dataType: 'json',
                    data: {
                        medida_id: medida_id,
                        extra_id: $("#extra_id").val(),
                    },
                    success: function (data) {
                        
                        if (data.preco) {
                            $("#valor_produto_customizado").html('R$ ' + data.preco);

                            $('#btn-adiciona').prop('disabled', false);
                            $('#btn-adiciona').prop('value', 'Adicionar ao carrinho');
                        }
                    },

                });
            }

        });

    });

</script>

<?php echo $this->endSection(); ?><!-- Begin Sections-->