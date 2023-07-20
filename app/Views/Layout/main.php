<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ordem de Serviço | <?= $this->renderSection("title") ?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">

  <link rel="stylesheet" href="<?= site_url("resources/vendor/bootstrap/css/bootstrap.min.css") ?>">
  <link rel="stylesheet" href="<?= site_url("resources/vendor/font-awesome/css/font-awesome.min.css") ?>">
  <link rel="stylesheet" href="<?= site_url("resources/css/font.css") ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
  <link rel="stylesheet" href="<?= site_url("resources/css/style.default.css") ?>" id="theme-stylesheet">
  <link rel="stylesheet" href="<?= site_url("resources/css/custom.css") ?>">
  <link rel="shortcut icon" href="<?= site_url("resources/img/favicon.ico") ?>">

  <!-- Espaço reservado para reproduzir os estilos de cada view e extender esse layout -->
  <?= $this->renderSection("styles") ?>
</head>

<body>
  
  <?= $this->include("Layout/_parts/navbar") ?>

  <div class="d-flex align-items-stretch">

    <?= $this->include("Layout/_parts/sidebar") ?>

    <div class="page-content">
      <div class="page-header">
        <div class="container-fluid">
          <h2 class="h5 no-margin-bottom"><?= $title ?></h2>
        </div>
      </div>
      <section class="no-padding-top no-padding-bottom">

        <div class="container-fluid">
          <?= $this->include("Layout/_messages") ?>
          <!-- Espaço reservado para reproduzir o conteúdo de cada view e extender esse layout -->
          <?= $this->renderSection("content") ?>
        </div>

      </section>
      <footer class="footer">
        <div class="footer__block block no-margin-bottom">
          <div class="container-fluid text-center">
            <p class="no-margin-bottom"><?= date("Y") ?> &copy; Todos os direitos reservados.</p>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script src="<?= site_url("resources/vendor/jquery/jquery.min.js") ?>"></script>
  <script src="<?= site_url("resources/vendor/popper.js/umd/popper.min.js") ?>"> </script>
  <script src="<?= site_url("resources/vendor/bootstrap/js/bootstrap.min.js") ?>"></script>
  <script src="<?= site_url("resources/vendor/jquery.cookie/jquery.cookie.js") ?>"> </script>
  <script src="<?= site_url("resources/vendor/chart.js/Chart.min.js") ?>"></script>
  <script src="<?= site_url("resources/vendor/jquery-validation/jquery.validate.min.js") ?>"></script>
  <script src="<?= site_url("resources/js/charts-home.js") ?>"></script>
  <script src="<?= site_url("resources/js/front.js") ?>"></script>

  <!-- Espaço reservado para reproduzir os scripts de cada view e extender esse layout -->
  <?= $this->renderSection("scripts") ?>
</body>

</html>