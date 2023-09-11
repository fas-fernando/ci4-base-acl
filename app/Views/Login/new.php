<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <link rel="stylesheet" href="<?= site_url("resources/plugin/bootstrap/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= site_url("resources/plugin/font-awesome/css/font-awesome.min.css") ?>">
    <link rel="stylesheet" href="<?= site_url("resources/css/font.css") ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <link rel="stylesheet" href="<?= site_url("resources/css/style.default.css") ?>" id="theme-stylesheet">
    <link rel="stylesheet" href="<?= site_url("resources/css/custom.css") ?>">
    <link rel="shortcut icon" href="<?= site_url("resources/img/favicon.ico") ?>">

</head>

<body>
    <div class="login-page">
        <div class="container d-flex align-items-center">
            <div class="form-holder has-shadow">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="info d-flex align-items-center">
                            <div class="content">
                                <div class="logo">
                                    <h1><?= $title ?></h1>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <?= form_open("/", ["id" => "form", "class" => "form-validate"]) ?>
                                <div id="response"></div>
                                <?= $this->include("Layout/_messages") ?>
                                <div class="form-group">
                                    <input id="email" type="email" name="email" required data-msg="Insira seu e-mail de acesso" class="input-material">
                                    <label for="email" class="label-material">E-mail de acesso</label>
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" name="password" required data-msg="Insira sua senha de acesso" class="input-material">
                                    <label for="password" class="label-material">Senha de acesso</label>
                                </div>
                                <input type="submit" value="Entrar" id="btn-login" class="btn btn-primary">

                                <?= form_close() ?>

                                <a href="#" class="forgot-pass mt-3">Esqueceu sua senha?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyrights text-center">
                <p><?= date('Y') ?> &copy; Todos os direitos <a target="_blank" href="https://etmo.com.br">ETMO</a>.</p>
            </div>
        </div>
    </div>

    <script src="<?= site_url("resources/plugin/jquery/jquery.min.js") ?>"></script>
    <script src="<?= site_url("resources/plugin/popper.js/umd/popper.min.js") ?>"> </script>
    <script src="<?= site_url("resources/plugin/bootstrap/js/bootstrap.min.js") ?>"></script>
    <script src="<?= site_url("resources/plugin/jquery.cookie/jquery.cookie.js") ?>"> </script>
    <script src="<?= site_url("resources/plugin/chart.js/Chart.min.js") ?>"></script>
    <script src="<?= site_url("resources/plugin/jquery-validation/jquery.validate.min.js") ?>"></script>
    <script src="<?= site_url("resources/js/charts-home.js") ?>"></script>
    <script src="<?= site_url("resources/js/front.js") ?>"></script>

    <script>
        $(document).ready(function() {
            $("#form").on("submit", function(event) {
                event.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "<?= site_url("login/create") ?>",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#response").html("");
                        $("#btn-login").val("Por favor aguarde...");
                    },
                    success: function(response) {
                        $("#btn-login").val("Entrar");
                        $("#btn-login").removeAttr("disabled");
                        $("[name=csrf_ordem]").val(response.token);

                        if (!response.error) {
                            window.location.href = "<?= site_url() ?>" + response.redirect;
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
                        $("#btn-login").val("Entrar");
                        $("#btn-login").removeAttr("disabled");
                    }
                });
            });

            $("#form").submit(function() {
                $(this).find(":submit").attr("disabled", "disabled");
            });
        });
    </script>
</body>

</html>