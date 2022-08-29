<div class="form-row">

    <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo old('nome', esc($extra->nome)); ?>">
    </div>

    <div class="form-group col-md-6">
        <label for="preco">Preço de venda</label>
        <input type="text" class="money form-control" name="preco" id="nome" value="<?php echo old('preco', esc($extra->preco)); ?>">
    </div>

    <div class="form-group col-md-12">
        <label for="descricao">Descrição</label>
        <textarea type="text" class="form-control" name="descricao" id="descricao" rows="2" value="<?php echo old('descricao', esc($extra->descricao)); ?>"><?php echo old('descricao', esc($extra->descricao)); ?></textarea>
    </div>

</div>

<div class="form-check form-check-flat form-check-primary mb-4">
    <label for="ativo" class="form-check-label">
        <input type="hidden" name="ativo" value="0" />
        <input type="checkbox" class="form-check-input" name="ativo" id="ativo" value="1" <?php if (old('ativo', $extra->ativo)): ?> checked="" <?php endif; ?> />
        Ativo
    </label>
</div>

<button type="submit" class="btn btn-primary btn-sm mr-2">
    <i class="mdi mdi-checkbox-marked-circle btn-icon-prepend"></i>
    Salvar
</button>