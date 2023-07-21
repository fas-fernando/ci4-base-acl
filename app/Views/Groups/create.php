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
                <div id="response"></div>
                <?= form_open("/", ["id" => "form"], ["id" => "$group->id"]) ?>
                    <?= $this->include("Groups/_form") ?>
                    <div class="form-group mt-5 mb-2">
                        <input type="submit" id="btn-save" value="Salvar" class="btn btn-primary">
                        <a href="<?= site_url("groups") ?>" class="btn btn-secondary ml-3">Voltar</a>
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
    $(document).ready(function(){
        $("#form").on("submit", function(event){
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "<?= site_url("groups/store") ?>",
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
                        window.location.href = "<?= site_url("groups/show/") ?>" + response.id;
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