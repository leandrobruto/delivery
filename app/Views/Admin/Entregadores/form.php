<div class="form-row">

    <div class="form-group col-md-4">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo old('nome', esc($entregador->nome)); ?>">
    </div>

    <div class="form-group col-md-2">
        <label for="nome">CPF</label>
        <input type="text" class="form-control cpf" name="cpf" id="cpf" value="<?php echo old('cpf', esc($entregador->cpf)); ?>">
    </div>

    <div class="form-group col-md-3">
        <label for="nome">Telefone</label>
        <input type="text" class="form-control sp_celphones" name="telefone" id="telefone" value="<?php echo old('telefone', esc($entregador->telefone)); ?>">
    </div>

    <div class="form-group col-md-3">
        <label for="email">E-mail</label>
        <input type="text" class="form-control" name="email" id="email" value="<?php echo old('email', esc($entregador->email)); ?>">
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-3">
        <label for="password">Senha</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>

    <div class="form-group col-md-3">
        <label for="password_confirmation">Confrimação de senha</label>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
    </div>

</div>

<div class="form-check form-check-flat form-check-primary mb-2">
    <label for="is_admin" class="form-check-label">
        <input type="hidden" name="ativo" value="0" />
        <input type="checkbox" class="form-check-input" name="ativo" id="ativo" value="1" <?php if (old('ativo', $entregador->ativo)): ?> checked="" <?php endif; ?> />
        Ativo
    </label>
</div>

<button type="submit" class="btn btn-primary btn-sm mr-2">
    <i class="mdi mdi-checkbox-marked-circle btn-icon-prepend"></i>
    Salvar
</button>