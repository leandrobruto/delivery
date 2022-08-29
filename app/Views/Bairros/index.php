<?php echo $this->extend('layout/principal_web'); ?>

<!-- Aqui enviamos para o template principal o título -->
<?php echo $this->section('titulo'); ?>

  <?php echo $titulo; ?>

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os estilos -->
<?php echo $this->section('estilos'); ?>

    <link rel="stylesheet" href="<?php echo site_url('web/src/assets/css/produto.css'); ?>"/>

    <style>

        @media only screen and (max-width: 767px) {
            .section-title {
                font-size: 20px !important;
                margin-top: -6em !important;
            }
        }

    </style>

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal o conteúdo -->
<?php echo $this->section('conteudo'); ?>

<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">

    <div class="col-sm-12 col-md-12 col-lg-12">
        <!-- product -->
        <div class="product-content product-wrap clearfix product-deatil">
            <div class="row">

            <?php if (empty($bairros)): ?>

                <div class="col-xs-12 col-md-12">
        
                    <h2 class="section-title">Não há dados para exibir.</h2>

                </div>

            <?php else: ?>

                <div class="col-xs-12 col-md-12">
        
                    <h2 class="section-title"><?php echo esc($titulo); ?></h2>

                </div>

                <?php foreach($bairros as $bairro): ?>

                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading panel-food"><?php echo esc($bairro->nome); ?> - <?php echo esc($bairro->cidade); ?> - CE</div>
                            <div class="panel-body fonte-food">Taxa de entrega: R$&nbsp<?php echo esc(number_format($bairro->valor_entrega, 2)); ?></div>
                        </div>
                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

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

        var especificacao_id;

        if (!especificacao_id) {

            $('#btn-adiciona').prop('disabled', true);
            $('#btn-adiciona').prop('value', 'Selecione um valor');
        }

        $(".especificacao").on('click', function () {

            especificacao_id = $(this).attr('data-especificacao');

            $("#especificacao_id").val(especificacao_id);

            $('#btn-adiciona').prop('disabled', false);
            $('#btn-adiciona').prop('value', 'Adicionar');

        });

        $(".extra").on('click', function () {

            var extra_id = $(this).attr('data-extra');

            $("#extra_id").val(extra_id);

        });

    });

</script>

<?php echo $this->endSection(); ?>