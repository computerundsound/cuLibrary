<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 06:55 MEZ
 */

/** @var $message */
/** @var $title */
/** @var $smallArray */
/** @var $codeblock */

?>

<div class="container">

    <div class="row">

        <div class="col-sm-12">

            <h1><?php $this->showValue('title'); ?></h1>

            <p><?php $this->showValue('message'); ?></p>

            <h3>Values in DB:</h3>

            <table class="table table-condensed table-striped">

                <tr>
                    <th>id</th>
                    <th>value</th>
                    <th>info</th>
                    <th>created</th>
                </tr>

                <?php foreach ($valuesInDB as $row): ?>

                    <tr>

                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['value']; ?></td>
                        <td><?php echo $row['info']; ?></td>
                        <td><?php echo $row['created']; ?></td>


                    </tr>

                <?php endforeach; ?>


            </table>


        </div>

    </div>

</div>
