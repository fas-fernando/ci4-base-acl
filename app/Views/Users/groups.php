<?= $this->extend("Layout/main") ?>

<!------------------ Título ------------------------>

<?= $this->section("title") ?> <?= $title ?> <?= $this->endSection() ?>

<!------------------ Estilos ------------------------>

<?= $this->section("styles") ?>

<link href="<?= site_url("resources/plugin/selectize/selectize.bootstrap4.css") ?>" rel="stylesheet" />

<style>
    /* Estilizando o select para acompanhar a formatação do template */

    .selectize-input,
    .selectize-control.single .selectize-input.input-active {
        background: #2d3035 !important;
    }

    .selectize-dropdown,
    .selectize-input,
    .selectize-input input {
        color: #777;
    }

    .selectize-input {
        /*        height: calc(2.4rem + 2px);*/
        border: 1px solid #444951;
        border-radius: 0;
    }
</style>

<?= $this->endSection() ?>

<!------------------ Conteúdo ------------------------>

<?= $this->section("content") ?>

<div class="row">

    <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
        <div class="user-block block">
            <div class="block-body">
                <?php if(empty($availableGroups)) : ?>
                    <p class="contributions mt-0">Esse usuário já faz parte de todos os grupos disponiveis.</p>
                <?php else : ?>
                    <div id="response"></div>
                    <?= form_open("/", ["id" => "form"], ["id" => "$user->id"]) ?>
                        <div class="form-group">
                            <label class="form-control-label">Escolha um ou mais grupos de acesso.</label>
                            <select name="group_id[]" class="selectize" multiple>
                                <option value="">Escolha...</option>
                                <?php foreach ($availableGroups as $group) : ?>
                                    <option value="<?= $group->id ?>"><?= esc($group->name) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group mt-5 mb-2">
                            <input type="submit" id="btn-save" value="Salvar" class="btn btn-primary">
                            <a href="<?= site_url("users/show/$user->id") ?>" class="btn btn-secondary ml-3">Voltar</a>
                        </div>
                    <?= form_close() ?>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
        <div class="user-block block">
            <?php if(empty($user->groups)) : ?>
                <p class="contributions text-warning mt-0">Esse usuário não faz parte de nenhum grupo de acesso.</p>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Grupo</th>
                                <th>Descrição</th>
                                <th class="float-right">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($user->groups as $group_info) : ?>
                                <tr>
                                    <td><?= esc($group_info->name) ?></td>
                                    <td><?= esc($group_info->description) ?></td>
                                    <td>
                                        <?php $attr = ["onSubmit" => "return confirm('Tem certeza da exclusão do grupo?')"] ?>
                                        <?= form_open("users/removegroup/$group->main_id", $attr) ?>
                                            <button type="submit" class="btn btn-sm btn-danger float-right"><i class="fa fa-trash"></i></button>
                                        <?= form_close() ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <div class="mt-3 ml-1">
                        <?= $user->pager->links() ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!------------------ Scripts ------------------------>

<?= $this->section("scripts") ?>

<script src="<?= site_url("resources/plugin/selectize/selectize.min.js") ?>"></script>

<script>
    $(document).ready(function(){
        $('.selectize').selectize();

        $("#form").on("submit", function(event){
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "<?= site_url("users/savegroups") ?>",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $("#response").html("");
                    $("#btn-save").val("Por favor aguarde...");
                },
                success: function(response){
                    $("#btn-save").val("Salvar");
                    $("#btn-save").removeAttr("disabled");
                    $("[name=csrf_ordem]").val(response.token);
                    
                    if(!response.error) {
                        window.location.href = "<?= site_url("users/groups/$user->id") ?>";
                    } else {
                        $("#response").html("<div class='alert alert-danger'>" + response.error + "</div>");

                        if(response.errors_model) {
                            $.each(response.errors_model, function(key, value){
                                $("#response").append("<ul class='list-unstyled'><li class='text-danger'>" + value + "</li></ul>");
                            });
                        }
                    }
                },
                error: function(){
                    alert("Não foi possível processar a solicitação. Por favor entre em contato com nosso suporte técnico.");
                    $("#btn-save").val("Salvar");
                    $("#btn-save").removeAttr("disabled");
                }
            });
        });

        $("#form").submit(function(){
            $(this).find(":submit").attr("disabled", "disabled");
        });
    });
</script>

<?= $this->endSection() ?>