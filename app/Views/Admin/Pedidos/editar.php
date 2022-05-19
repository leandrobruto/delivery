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
  <div class="col-lg-8 grid-margin stretch-card">
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

        <?php echo form_open("admin/pedidos/atualizar/$pedido->codigo"); ?>

          <div class="form-check form-check-flat form-check-primary mb-4">
            <label for="saiu_entrega" class="form-check-label">
                <input type="radio" class="form-check-input" name="situacao" id="saiu_entrega" value="1" <?php echo ($pedido->situacao == 1 ? 'checked=' : ''); ?> />
                Saiu para entrega
            </label>
          </div>

          <div class="form-check form-check-flat form-check-primary mb-4">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="situacao" value="2" <?php echo ($pedido->situacao == 2 ? 'checked=' : ''); ?> />
                Pedido entregue
            </label>
          </div>

          <div class="form-check form-check-flat form-check-primary mb-4">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="situacao" value="3" <?php echo ($pedido->situacao == 3 ? 'checked=' : ''); ?> />
                Pedido cancelado
            </label>
          </div>

          <a href="<?php echo site_url("admin/pedidos/show/$pedido->codigo"); ?>" class="btn btn-light text-dark btn-sm">
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

  <script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js') ?>"></script>
  <script src="<?php echo site_url('admin/vendors/mask/app.js') ?>"></script>

<?php echo $this->endSection(); ?>