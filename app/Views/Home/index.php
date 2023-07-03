<?= $this->extend("Layout/main") ?>

<!------------------ Título ------------------------>

<?= $this->section("title") ?> <?= $title ?> <?= $this->endSection() ?>

<!------------------ Estilos ------------------------>

<?= $this->section("style") ?>

<!-- Inserir os estilos dessa página nessa Section -->

<?= $this->endSection() ?>

<!------------------ Conteúdo ------------------------>

<?= $this->section("content") ?>

<!-- Inserir o conteúdo dessa página nessa Section -->

<?= $this->endSection() ?>

<!------------------ Scripts ------------------------>

<?= $this->section("scripts") ?>

<!-- Inserir os scripts dessa página nessa Section -->

<?= $this->endSection() ?>