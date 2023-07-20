<?php if (session()->has("success")) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucesso! </strong> <?= session("success") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<?php if (session()->has("info")) : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Informação! </strong> <?= session("info") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<?php if (session()->has("attention")) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Atenção! </strong> <?= session("attention") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<?php if (session()->has("errors_model")) : ?>
    <ul>
        <?php foreach($errors_model as $error_model) : ?>
            <li class="text-danger"><?= $error_model ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>

<?php if (session()->has("error")) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Erro! </strong> <?= session("error") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>