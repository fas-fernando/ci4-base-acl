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
    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
        <div class="user-block block">
            <div class="text-center">
                <?php if ($user->avatar == null) : ?>
                    <div class="avatar" style="width: 250px; height: 230px">
                        <img src="<?= site_url("resources/img/user-default.png") ?>" alt="User Default" class="card-img-top" style="width: 90%">
                    </div>
                <?php else : ?>
                    <div class="avatar" style="width: 250px; height: 230px">
                        <img src="<?= site_url("users/showAvatar/$user->avatar") ?>" alt="<?= esc($user->avatar) ?>" class="card-img-top" style="width: 90%">
                    </div>
                <?php endif ?>
                <a href="<?= site_url("users/editAvatar/$user->id") ?>" class="btn btn-outline-info btn-sm mt-3">Alterar imagem</a>
            </div>
            <hr class="border-secondary">

            <h5 class="card-title mt-2"><?= esc($user->name) ?></h5>
            <p class="card-text"><strong>E-mail:&nbsp;</strong> <?= esc($user->email) ?></p>
            <p class="card-text"><strong>Status:&nbsp;</strong> <?= $user->showSituation()  ?></p>
            <p class="card-text"><strong>Criado:&nbsp;</strong> <?= $user->created_at->humanize() ?></p>
            <p class="card-text"><strong>Atualizado:&nbsp;</strong> <?= $user->updated_at->humanize() ?></p>

            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= site_url("users/edit/$user->id") ?>">Editar usuário</a>
                    <a class="dropdown-item" href="<?= site_url("users/groups/$user->id") ?>">Gerenciar grupos</a>
                    <div class="dropdown-divider"></div>

                    <?php if($user->deleted_at == null) : ?>
                        <a class="dropdown-item" href="<?= site_url("users/delete/$user->id") ?>">Excluir usuário</a>
                    <?php else : ?>
                        <a class="dropdown-item" href="<?= site_url("users/restore/$user->id") ?>">Restaurar usuário</a>
                    <?php endif ?>
                </div>
            </div>
            <a href="<?= site_url("users") ?>" class="btn btn-secondary ml-3">Voltar</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!------------------ Scripts ------------------------>

<?= $this->section("scripts") ?>



<?= $this->endSection() ?>