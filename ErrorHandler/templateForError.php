<?php

use computerundsound\culibrary\ErrorHandler\system\CuErrorHandlerParameter;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fehler</title>

    <style>
        body, html {
            height: 100%;
            box-sizing: border-box;
            background: #a10000;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 80%;
            background: #4d0000;
            padding: 1em;
            margin: auto;
        }

        table {
            font-size: 15px;
            padding: 15px;
            border: none;
            border-collapse: collapse;

        }


        tr {
            border: none;
        }

        th, td {
            border: 2px black solid;
            padding: 1em;
        }

        .cuUnderTable {
            background-color: 230000FF;
            color: white;
        }

        .cuUnderTable a {
            color: white;
        }

    </style>

</head>
<body>

<div class="container">

    <h1>An Error occurred: in <?= $cuEHP->getFile() ?>:<?= $cuEHP->getLine() ?></h1>

    <p>Type: <?php echo $cuEHP->getErrorType(); ?></p>

    <table>
        <tr>
            <th>Error</th>
            <td><?php echo $cuEHP->getMessage() ?></td>
        </tr>
        <tr>
            <th>Found in</th>
            <td><?php echo $cuEHP->getFile() ?>:<?php echo $cuEHP->getLine() ?></td>
        </tr>

        <?php
        if ($cuEHP->hasStack()):
            ?>
            <tr>
                <th>Stacktrace</th>
                <td><?php echo $cuEHP->getStack() ?></td>
            </tr>
        <?php
        endif;

        if ($cuEHP->getCodeBlock()): ?>
            <tr>
                <th>Code-Block</th>
                <td style="font-size: 12px; color: #9d9d9d; background-color: black;">
                    <pre><?php echo $cuEHP->getCodeBlock() ?></pre>
                </td>
            </tr>

        <?php
        endif;
        ?>

    </table>

    <div class="cuUnderTable">
        <p>Link Back: <a href="<?php echo $cuEHP->getReferer() ?>"><?php echo $cuEHP->getReferer() ?></a></p>
    </div>
</div>

</body>
</html>