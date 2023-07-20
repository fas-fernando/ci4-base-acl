<div class="form-group">
    <label class="form-control-label">Nome completo</label>
    <input type="text" placeholder="Insira o nome completo" class="form-control" name="name" value="<?= esc($user->name) ?>">
</div>
<div class="form-group">
    <label class="form-control-label">E-mail</label>
    <input type="email" placeholder="Insira o e-mail de acesso" class="form-control" name="email" value="<?= esc($user->email) ?>">
</div>
<div class="form-group">
    <label class="form-control-label">Senha</label>
    <input type="password" placeholder="Insira a senha de acesso" class="form-control" name="password">
</div>
<div class="form-group">
    <label class="form-control-label">Confirmar senha</label>
    <input type="password" placeholder="Confirme a senha de acesso" class="form-control" name="password_confirmation">
</div>

<div class="custom-control custom-checkbox">
    <input type="hidden" name="status" value="0">
  <input type="checkbox" class="custom-control-input" name="status" value="1" id="status" <?= ($user->status == true) ? "checked" : ""  ?>>
  <label class="custom-control-label" for="status">Usuário ativo</label>
</div>