<?php

/** @var $message */
/** @var $title */
/** @var $smallArray */
/** @var $codeblock */

?>

<div class="container">

    <div class="row">

        <div class="col-sm-12">

            <h1><?php echo $title; ?></h1>

            <p><?php echo $message; ?></p>


            <div class="alert alert-info">
                <?php highlight_string($codeblock); ?>
            </div>

            <h3>From Array:</h3>
            <?php

            /** @noinspection ForeachSourceInspection */
            foreach ($smallArray as $key => $value):
                ?>

                <p>Pair: <?php echo $key; ?> => <?php echo $value; ?></p>

                <?php
            endforeach;
            ?>

            <h3>From Object</h3>

            <p><?php echo $smallObj->one; ?></p>
            <p><?php echo $smallObj->two; ?></p>

        </div>

    </div>

</div>
