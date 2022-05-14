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
    <!-- product -->
    <div class="product-content product-wrap clearfix product-deatil">
        <div class="row">

            <h2 class="name">
                <?php echo esc($titulo); ?>
            </h2>


            <?php echo form_open('carrinho/especial'); ?>

                <div class="row">

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
                    
                        <label>Escolha o seu produto</label>
                        <select id="primeira_metade" class="form-control" name="primeira_metade">

                            <option >Escolha seu produto..</option>

                            <?php foreach ($opcoes as $opcao): ?>

                                <option value="<?php echo $opcao->id; ?>"><?php echo esc($opcao->nome); ?></option>

                            <?php endforeach; ?>
                            
                        </select>              

                    </div>

                    <div class="col-md-6">
                    
                        <label>Segunda metade</label>
                        <select id="segunda_metade" class="form-control" name="segunda_metade">

                            <!-- Aqui serão renderizadas as opções para compor a segunda metade, via javascript -->
                            <option >Escolha seu produto..</option>

                            <?php foreach ($opcoes as $opcao): ?>

                                <option value="<?php echo $opcao->id; ?>"><?php echo esc($opcao->nome); ?></option>

                            <?php endforeach; ?>
                            
                        </select>              

                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-4">
                        <input id="btn-adiciona" type="submit" class="btn btn-success btn-block" value="Adicionar"/>
                    </div>

                    <div class="col-sm-4">
                        <a href="<?php echo site_url('/'); ?>" class="btn btn-info btn-block">Mais delícias</a>
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
            $('#btn-adiciona').prop('value', 'Adicionar');

        });

        $(".extra").on('click', function () {

            var extra_id = $(this).attr('data-extra');

            $("#extra_id").val(extra_id);

        });

    });

</script>

<?php echo $this->endSection(); ?><!-- Begin Sections-->