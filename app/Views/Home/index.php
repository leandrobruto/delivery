<?php echo $this->extend('layout/principal_web'); ?>

<!-- Aqui enviamos para o template principal o título -->
<?php echo $this->section('titulo'); ?>

  <?php echo $titulo; ?>

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os estilos -->
<?php echo $this->section('estilos'); ?>


<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal o conteúdo -->
<?php echo $this->section('conteudo'); ?>

    <!--    Menus   -->
    <div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">
        <div class="title-block">
            <h1 class="section-title">Conheça as nossas delícias</h1>
        </div>

        <!--    Menus filter    -->
        <div class="menu_filter text-center">
            <ul class="list-unstyled list-inline d-inline-block">

                <?php if(empty($categorias)): ?>

                    <li class="item active">
                        <a href="javascript:;" class="filter-button">Não há categorias para exibir.</a>
                    </li>

                <?php else: ?>

                    <li id="todas" class="item active">
                        <a href="javascript:;" class="filter-button" data-filter="todas">Todas</a>
                    </li>
                
                    <?php foreach ($categorias as $key => $categoria): ?>
                    
                        <li class="item">
                            <a href="javascript:;" class="filter-button" data-filter="<?php echo $categoria->slug; ?>"><?php echo esc($categoria->nome); ?></a>
                        </li>

                    <?php endforeach; ?>

                <?php endif; ?>

            </ul>
        </div> 

        <!--    Menus items     -->
        <div id="menu_items">

            <div class="row">

                <?php if(empty($produtos)): ?>

                    <div class="title-block">
                        <h2 class="section-title">Não há delícias para exibir no momento</h2>
                    </div>

                <?php else: ?>

                    <?php foreach ($produtos as $key => $produto): ?>

                        <div class="col-sm-6 filtr-item image filter <?php echo $produto->categoria_slug; ?> active">
                            <a href="<?php echo site_url("produto/detalhes/$produto->slug"); ?>" class="block fancybox" data-fancybox-group="fancybox">
                                <div class="content">
                                    <div class="filter_item_img">
                                        <i class="fa fa-search-plus"></i>
                                        <?php if ($produto->imagem && $produto->deletedo_em == null): ?>
                                            <img class="card-img-top w-75" src="<?php echo site_url("produto/imagem/$produto->imagem"); ?>" alt="<?php echo esc($produto->nome); ?>" />
                                        <?php else: ?>
                                            <img class="card-img-top w-75" src="<?php echo site_url("admin/images/produto-sem-imagem.jpg"); ?>" alt="<?php echo esc($produto->nome); ?>" /> 
                                        <?php endif; ?>
                                    </div>
                                    <div class="info">
                                        <div class="name"><?php echo esc($produto->nome); previous_url() ?></div>
                                        <div class="short"><?php echo word_limiter($produto->ingredientes, 5); ?></div>
                                        <span class="filter_item_price">A partir de  R$&nbsp;<?php echo esc(number_format($produto->preco , 2)); ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

        </div>
    </div>

    <!-- End Sections -->

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?php echo $this->section('scripts'); ?>


<?php echo $this->endSection(); ?>