<?php echo $this->extend('Admin/layout/principal'); ?>

<!-- Aqui enviamos para o template principal o título -->
<?php echo $this->section('titulo'); ?>

  <?php echo $titulo; ?>

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os estilos -->
<?php echo $this->section('estilos'); ?>



<?php echo $this->endSection(); ?>



<!-- Aqui enviamos para o template principal o conteúdo -->
<?php echo $this->section('conteudo'); ?>

<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-header bg-primary pb-0 pt-4">
        <h4 class="card-title text-white"><?php echo esc($titulo); ?></h4>
      </div>
      <div class="card-body">

        <?php if (session()->has('errors_model')): ?>
          <ul>
            <?php foreach (session('errors_model') as $error): ?>
              <li class="text-danger"><?php echo $error ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <?php echo form_open("admin/categorias/excluir/$categoria->id"); ?>

          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Atenção!</strong> Tem certeza da exclusão da categoria <strong><?php echo esc($categoria->nome) ?>?</strong>
          </div>

          <button type="submit" class="btn btn-danger btn-sm mr-2">
              <i class="mdi mdi-trash-can btn-icon-prepend"></i>
              Excluir
          </button>

          <a href="<?php echo site_url("admin/usuarios/show/$categoria->id"); ?>" class="btn btn-light text-dark btn-sm">
            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
            Voltar
          </a>

        <?php echo form_close(); ?>

      </div>
    </div>
  </div>
</div>

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?php echo $this->section('scripts'); ?>


<?php echo $this->endSection(); ?>