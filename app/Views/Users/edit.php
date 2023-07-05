<?= $this->extend("Layout/main") ?>

<!------------------ Título ------------------------>

<?= $this->section("title") ?> <?= $title ?> <?= $this->endSection() ?>

<!------------------ Estilos ------------------------>

<?= $this->section("styles") ?>


<?= $this->endSection() ?>

<!------------------ Conteúdo ------------------------>

<?= $this->section("content") ?>

<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="block">
            <div class="block-body">
                <div id="response"></div>
                <?= form_open("/", ["id" => "form"], ["id" => "$user->id"]) ?>
                    <?= $this->include("Users/_form") ?>
                    <div class="form-group mt-5 mb-2">
                        <input type="submit" id="btn-save" value="Salvar" class="btn btn-primary">
                        <a href="<?= site_url("users/show/$user->id") ?>" class="btn btn-secondary ml-3">Voltar</a>
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