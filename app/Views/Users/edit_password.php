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
                <?= form_open("/", ["id" => "form"]) ?>
                <div class="form-group">
                    <label class="form-control-label">Senha Atual</label>
                    <input type="password" class="form-control" name="current_password">
                </div>
                <div class="form-group">
                    <label class="form-control-label">Nova Senha</label>
                    <input type="password" class="form-control" name="new_password">
                </div>
                <div class="form-group">
                    <label class="form-control-label">Confirmar Nova Senha</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
                <div class="form-group mt-5 mb-2">
                    <input type="submit" id="btn-save" value="Atualizar" class="btn btn-primary">
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!------------------ Scripts ------------------------>

<?= $this->section("scripts") ?>

<script>
    $(document).ready(function() {
        $("#form").on("submit", function(event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "<?= site_url("users/updatepassword") ?>",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#response").html("");
                    $("#btn-save").val("Por favor aguarde...");
                },
                success: function(response) {
                    $("#btn-save").val("Atualizar");
                    $("#btn-save").removeAttr("disabled");
                    $("[name=csrf_ordem]").val(response.token);

                    if (!response.error) {
                        $("#form")[0].reset();

                        if (response.info) {
                            $("#response").html("<div class='alert alert-info'>" + response.info + "</div>");
                        } else {
                            $("#response").html("<div class='alert alert-success'>" + response.success + "</div>");
                        }

                    } else {
                        $("#response").html("<div class='alert alert-danger'>" + response.error + "</div>");

                        if (response.errors_model) {
                            $.each(response.errors_model, function(key, value) {
                                $("#response").append("<ul class='list-unstyled'><li class='text-danger'>" + value + "</li></ul>");
                            });
                        }
                    }
                },
                error: function() {
                    alert("Não foi possível processar a solicitação. Por favor entre em contato com nosso suporte técnico.");
                    $("#btn-save").val("Atualizar");
                    $("#btn-save").removeAttr("disabled");
                }
            });
        });

        $("#form").submit(function() {
            $(this).find(":submit").attr("disabled", "disabled");
        });
    });
</script>

<?= $this->endSection() ?>