<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */
declare(strict_types=1);
use computerundsound\culibrary\CuFlashMessage;

/** @var string $currentPage */
/** @var string[] $cuConstantsArray */
/** @var string $content */
/** @var string $cuFlashMessage */

?><!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <base href="<?php echo $cuConstants['AppRootHTTP'] ?>">

    <title>Startseite</title>

    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="https://www.cusp.de" target="_blank">Computer & Sound</a>
    <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo ($currentPage === 'start') ? 'active' : '' ?>">
                <a class="nav-link" href="./">Examples</a>
            </li>

            <li class="nav-item <?php echo ($currentPage === 'dbSample') ? 'active' : '' ?>">
                <a class="nav-link" href="db_sample.php">Database Example</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" target="_blank" href="../">File overview</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" target="_blank" href="index.php?action=phpinfo">PHPInfo</a>
            </li>

        </ul>
    </div>
</nav>

<div class="container">

    <?php if (CuFlashMessage::get()): ?>
        <div class="row mt-4 mb-4">
            <div class="col">
                <div class="alert alert-warning">
                    <p><?php echo CuFlashMessage::get(); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">

        <div class="col">
            <?php echo $content; ?>
        </div>
    </div>
</div>
</body>
</html>
