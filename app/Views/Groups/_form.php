<div class="form-group">
    <label class="form-control-label">Nome</label>
    <input type="text" placeholder="Insira o nome do grupo" class="form-control" name="name" value="<?= esc($group->name) ?>">
</div>
<div class="form-group">
    <label class="form-control-label">Descrição</label>
    <input type="text" placeholder="Insira a descrição do grupo" class="form-control" name="description" value="<?= esc($group->description) ?>">
</div>

<div class="custom-control custom-checkbox">
    <input type="hidden" name="show" value="0">
    <input type="checkbox" class="custom-control-input" name="show" value="1" id="show" <?= ($group->show == true) ? "checked" : ""  ?>>
    <label class="custom-control-label" for="show">Exibir grupo</label>
</div>