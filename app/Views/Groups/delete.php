<?= $this->extend("Layout/main") ?>

<!------------------ Título ------------------------>

<?= $this->section("title") ?> <?= $title ?> <?= $this->endSection() ?>

<!------------------ Estilos ------------------------>

<?= $this->section("styles") ?>


<?= $this->endSection() ?>

<!------------------ Conteúdo ------------------------>

<?= $this->section("content") ?>

<div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
        <div class="block">
            <div class="block-body">
                <?= form_open_multipart("groups/delete/$group->id") ?>
                    <div class="alert alert-warning" role="alert">
                        Tem certeza que deseja excluir esse grupo?
                    </div>
                    <div class="form-group mt-5 mb-2">
                        <input type="submit" id="btn-save" value="Sim, pode excluir" class="btn btn-primary">
                        <a href="<?= site_url("groups/show/$group->id") ?>" class="btn btn-secondary ml-3">Cancelar</a>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!------------------ Scripts ------------------------>

<?= $this->section("scripts") ?>

<?= $this->endSection() ?>