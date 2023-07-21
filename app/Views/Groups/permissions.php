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

    <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">

    </div>

    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
        <div class="user-block block">
            <?php if(empty($group->permissions)) : ?>
                <p class="contributions text-warning mt-0">Esse grupo não possui nenhuma permissão</p>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Permissão</th>
                                <th class="float-right">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($group->permissions as $permission) : ?>
                                <tr>
                                    <td><?= esc($permission->name) ?></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-danger float-right">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <div class="mt-3 ml-1">
                        <?= $group->pager->links() ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!------------------ Scripts ------------------------>

<?= $this->section("scripts") ?>



<?= $this->endSection() ?>