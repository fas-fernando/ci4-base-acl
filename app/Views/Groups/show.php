<?= $this->extend("Layout/main") ?>

<!------------------ Título ------------------------>

<?= $this->section("title") ?> <?= $title ?> <?= $this->endSection() ?>

<!------------------ Estilos ------------------------>

<?= $this->section("styles") ?>

<style>

</style>


<?= $this->endSection() ?>

<!------------------ Conteúdo ------------------------>

<?= $this->section("content") ?>

<div class="row">
    <?php if($group->id < 3) : ?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">Importante!</h4>
                <p>O grupo <strong><?= esc($group->name) ?></strong> não pode ser editado ou excluído, pois o mesmo não pode ter sua permissão revogada.</p>
            </div>
        </div>
    <?php endif ?>

    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
        <div class="block">
            <h5 class="card-title mt-2"><?= esc($group->name) ?></h5>
            <p class="card-text"><strong>Descrição:&nbsp;</strong> <?= esc($group->description)  ?></p>
            <p class="card-text"><strong>Status:&nbsp;</strong> <?= $group->showSituation()  ?></p>
            <p class="card-text"><strong>Criado:&nbsp;</strong> <?= $group->created_at->humanize() ?></p>
            <p class="card-text"><strong>Atualizado:&nbsp;</strong> <?= $group->updated_at->humanize() ?></p>

            <?php if ($group->id > 2) : ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle mr-3" data-toggle="dropdown" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= site_url("groups/edit/$group->id") ?>">Editar grupo</a>
                        
                        <?php if($group->id > 2) : ?>
                            <a class="dropdown-item" href="<?= site_url("groups/permissions/$group->id") ?>">Gerenciar permissões</a>
                        <?php endif ?>

                        <div class="dropdown-divider"></div>

                        <?php if ($group->deleted_at == null) : ?>
                            <a class="dropdown-item" href="<?= site_url("groups/delete/$group->id") ?>">Excluir grupo</a>
                        <?php else : ?>
                            <a class="dropdown-item" href="<?= site_url("groups/restore/$group->id") ?>">Restaurar grupo</a>
                        <?php endif ?>
                    </div>
                </div>
            <?php endif ?>

            <a href="<?= site_url("groups") ?>" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!------------------ Scripts ------------------------>

<?= $this->section("scripts") ?>



<?= $this->endSection() ?>