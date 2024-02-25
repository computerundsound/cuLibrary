<?php

use computerundsound\culibrary\ErrorHandler\system\CuErrorHandlerParameter;

/**
 * @var CuErrorHandlerParameter $cuEHP ;
 */
$cuEHP;

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
            background: #c7c7c7;
            color: #000000;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 80%;
            background: #ffffff;
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

    <h1>Sorry, an Error occurred:</h1>

    <p>You can send an email to the admin.</p>
    <p>Please try again, or maybe try later.</p>

    <div class="cuUnderTable">
        <p>Link Back: <a href="<?php echo $cuEHP->getReferer() ?>"><?php echo $cuEHP->getReferer() ?></a></p>
    </div>
</div>

</body>
</html>