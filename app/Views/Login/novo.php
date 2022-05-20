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
            #login {
                min-width: 90% !important;
            
            }
        }

    </style>

<?php echo $this->endSection(); ?>

<!-- Aqui enviamos para o template principal o conteúdo -->
<?php echo $this->section('conteudo'); ?>

<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">
    <!-- product -->
    <div id="login" class="product-content product-wrap clearfix product-deatil center-block" style="max-width: 40%">
        <div class="row">
           
            <div class="col-md-12">

                <h4 class="text-center"><?php echo $titulo; ?></h4>

                <?php if (session()->has('errors_model')): ?>
                    <ul style="margin-left: -1.5em; list-style: decimal">
                        <?php foreach (session('errors_model') as $error): ?>
                            <li class="text-danger"><?php echo $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php echo form_open('login/criar'); ?>
                    <div class="form-group">
                        <input type="email" name="email" value="<?php echo old('email'); ?>" class="form-control form-control-lg" id="email" placeholder="Digite o seu e-mail.">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Digite a sua senha.">
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-food btn-block font-weight-medium auth-form-btn">Entrar</button>
                    </div>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input">
                                Me mantenha logado.
                            </label>
                        </div>
                        <a href="<?php echo site_url('password/esqueci') ?>" class="auth-link text-black">Esqueci a minha senha.</a>
                    </div>
                    
                    <div class="text-center mt-4 font-weight-light">
                        Ainda não tem uma conta? <a href="<?php echo site_url('registrar'); ?>" class="text-primary">Criar conta</a>
                    </div>
                <?php echo form_close(); ?>

            </div>
        
        </div>
    </div>
    <!-- end product -->
</div>

    <!-- End Sections -->

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?php echo $this->section('scripts'); ?>



<?php echo $this->endSection(); ?><!-- Begin Sections-->