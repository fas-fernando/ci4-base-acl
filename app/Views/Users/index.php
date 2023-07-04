<?= $this->extend("Layout/main") ?>

<!------------------ Título ------------------------>

<?= $this->section("title") ?> <?= $title ?> <?= $this->endSection() ?>

<!------------------ Estilos ------------------------>

<?= $this->section("styles") ?>

<link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet" />

<?= $this->endSection() ?>

<!------------------ Conteúdo ------------------------>

<?= $this->section("content") ?>

<div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="block">
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="ajaxTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!------------------ Scripts ------------------------>

<?= $this->section("scripts") ?>

<script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.js"></script>

<script>
    $('#ajaxTable').DataTable({
        ajax: '<?= site_url("users/getUsers") ?>',
        columns: [
            {
                data: 'avatar'
            },
            {
                data: 'name'
            },
            {
                data: 'email'
            },
            {
                data: 'status'
            },
        ],
    });
</script>

<?= $this->endSection() ?>