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

    <div class="col-sm-12 col-md-12 col-lg-12">
        <!-- product -->
        <div class="product-content product-wrap clearfix product-deatil">
            <div class="row">
            
                <div class="col-xs-12 col-md-12">
            
                    <h2 class="section-title pull-left"><?php echo esc($titulo); ?></h2>
        
                </div>

                <div class="col-md-6">

                    <ul class="list-group">
                        
                        <?php $total = 0; ?>

                        <?php foreach ($carrinho as $produto): ?>

                            <?php $subTotal = $produto['preco'] * $produto['quantidade']; ?>

                            <?php $total += $subTotal; ?>

                            <li class="list-group-item">
                                <div>
                                    <h4><?php echo ellipsize($produto['nome'], 60); ?></h4>
                                    <p class="text-muted">Quantidade: <?php echo $produto['quantidade']; ?></p>
                                    <p class="text-muted">Preço: R$ <?php echo $produto['preco']; ?></p>
                                    <p class="text-muted">Subtotal: R$ <?php echo number_format($subTotal, 2); ?></p>
                                </div>
                            </li>

                        <?php endforeach; ?>

                        <li class="list-group-item">
                            <span>Total de produtos:</span>
                            <strong><?php echo 'R$&nbsp;' . esc(number_format($total, 2)); ?></strong>
                        </li>

                        <li class="list-group-item">
                            <span>Taxa de entrega:</span>
                            <strong id="valor_entrega" class="text-danger">Obrigatório *</strong>
                        </li>

                        <li class="list-group-item">
                            <span>Valor do pedidos:</span>
                            <strong id="total"><?php echo 'R$&nbsp;' . esc(number_format($total, 2)); ?></strong>
                        </li>

                        <li class="list-group-item">
                            <span>Endereço de entrega:</span>
                            <strong id="endereco" class="text-danger">Obrigatório *</strong>
                        </li>

                    </ul>

                    <a href="<?php echo site_url('/'); ?>" class="btn btn-food btn-sm">Quero mais delícias</a>
                    <a href="<?php echo site_url('carrinho'); ?>" class="btn btn-primary btn-sm" style="font-family: 'Montserrat-Bold';">Ver meu carrinho</a>    

                </div> <!-- Fim col-md-6 -->

                <div class="col-md-6">

                    <?php echo form_open('checkout/processar', ['class' => 'form-checkout']); ?>

                        <?php if (session()->has('errors_model')): ?>
                            <ul style="list-style: decimal; margin-left: -1.5em;">
                                <?php foreach (session('errors_model') as $error): ?>
                                    <li class="text-danger"><?php echo $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <p style="font-size: 16px; font-weight: bold;">Escolha a forma de pagamento na entrega</p>

                        <div class="form-row">

                            <?php foreach ($formas as $forma): ?>
                                        
                                <div class="radio">
                                
                                    <label style="font-size: 16px">
                                        <input id="forma" type="radio" style="margin-top: 2px" name="forma" class="forma" data-forma="<?php echo $forma->id; ?>">
                                        <?php echo esc($forma->nome); ?>
                                    </label>
                            
                                </div>
                            
                            <?php endforeach; ?> 

                            <hr>
                            
                            <!-- Essa div será evibida quando for escolhida a forma de pagamento dinheiro -->
                            <div id="troco" class="hidden">

                                <div class="form-group col-md-12" style="padding-left: 0">
                                    <label>Troco para</label>
                                    <input type="text" id="troco_para" name="checkout[troco_para]" class="form-control money" placeholder="Troco para..">
                                </div>

                                <label>
                                    <input type="checkbox" id="sem_troco" name="checkout[sem_troco]">
                                    Não preciso troco
                                </label>

                                <hr>

                            </div> <!-- Fim troco -->

                            <div class="form-group col-md-12" style="padding-left: 0">
                                <label>Consulte a taxa de entrega</label>
                                <input type="text" name="cep" class="form-control cep" placeholder="Informe seu CEP..">
                                <div id="cep"></div>
                            </div>

                            <div class="form-group col-md-9" style="padding-left: 0">
                                <label>Rua *</label>
                                <input id="rua" type="text" name="checkout[rua]" class="form-control" readonly="" required="">
                            </div>
                            
                            <div class="form-group col-md-3" style="padding-left: 0">
                                <label>Número *</label>
                                <input type="text" name="checkout[numero]" class="form-control" required="">
                            </div>

                            <div class="form-group col-md-12" style="padding-left: 0">
                                <label>Ponto de referência</label> *</label>
                                <input type="text" name="checkout[referencia]" class="form-control" required="">
                            </div>

                            <div class="form-group col-md-12">
                                <input type="hidden" id="forma_id" name="checkout[forma_id]" placeholder="checkout[forma_id]">
                                <input type="hidden" id="bairro_slug" name="checkout[bairro_slug]" placeholder="checkout[bairro_slug]">
                            </div>

                            <div class="form-group col-md-12" style="padding-left: 0">
                                <input type="submit" id="btn-checkout" class="btn btn-block btn-food" value="Antes, consulte a tava de entrega">
                            </div>

                        </div>

                    <?php echo form_close(); ?>

                </div>
            
            </div>
        </div>
        <!-- end product -->
    </div>
</div>



    <!-- End Sections -->

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?php echo $this->section('scripts'); ?>

<script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js') ?>"></script>
<script src="<?php echo site_url('admin/vendors/mask/app.js') ?>"></script>

<script>

    $('#btn-checkout').prop('disabled', true);

    $(".forma").on('click', function () {

        var forma_id = $(this).attr('data-forma');

        $("#forma_id").val(forma_id);

        if (forma_id == 1) {
            $("#troco").removeClass('hidden');            
        } else {
            $("#troco").addClass('hidden');  
        }
    }); // Fim #troco

    $("#sem_troco").on('click', function () {

        if (this.checked) {
            $("#troco_para").prop('disabled', true);
            $("#troco_para").val('Não preciso de troco, pois tenho o valor certinho.');
            $("#troco_para").attr('placeholder', 'Não preciso de troco, pois tenho o valor certinho.');
        } else {
            $("#troco_para").prop('disabled', false);
            $("#troco_para").val('');
            $("#troco_para").attr('placeholder', 'Enviar troco para..');
        }
        
    }); // Fim #sem_troco

    $('[name = cep]').focusout( function () {

        var cep = $(this).val();

        if (cep.length === 9) {
            $.ajax({
                type: 'get',
                url: '<?php echo site_url('checkout/consultacep'); ?>',
                dataType: 'json',
                data: {
                    cep: cep
                },
                beforeSend: function () {

                    $("#cep").html('<div class="small">Consultando..</div>');
                    
                    $('[name = cep]').val('');

                    $('#btn-checkout').prop('disabled', true);
                    $('#btn-checkout').val('Consultando a taxa de entrega..');

                },
                success: function (response) {

                    if (!response.erro) {

                        /* CEP válido.. */
                    
                        $("#valor_entrega").html(response.valor_entrega);
                        $("#bairro_slug").val(response.bairro_slug);

                        $('#btn-checkout').prop('disabled', false);
                        $('#btn-checkout').val('Processar pedido');

                        if (response.logradouro) {
                            $('#rua').val(response.logradouro);
                        } else {
                            $('#rua').prop('readonly', false);
                        }

                        $("#endereco").html(response.endereco);

                        $("#total").html(response.total);

                        $("#cep").html(response.bairro);

                    } else {
                        /* Tem erros de validação */

                        $("#cep").html(response.erro);
                        
                        $('#btn-checkout').prop('disabled', true);
                        $('#btn-checkout').val('Antes, consulte a taxa de entrega..');
                    }
                    
                }, // Fim success
                error: function () {

                    alert("Não foi possível consultar a taxa de entrega. Por favor, entre em contato com a nossa equipe e informe o erro: CONSULTA-ERRO-TAXA-ENTREGA-CHECKOUT.");

                    $('#btn-checkout').prop('disabled', true);
                    $('#btn-checkout').val('Antes, consulte a taxa de entrega..');
                },

            });
        }
    });

    $("form").submit(function () {
        $(this).find(":submit").attr('disabled', 'disabled');
        $('#btn-checkout').val('Processando o seu perdido..');
    });

    $(window).keyDown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

</script>

<?php echo $this->endSection(); ?><!-- Begin Sections-->