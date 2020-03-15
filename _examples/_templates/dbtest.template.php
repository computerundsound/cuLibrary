<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */
declare(strict_types=1);

/** @var $message */
/** @var $title */
/** @var $smallArray */
/** @var $codeblock */

?>

<div class="container">
    <div class="row mt-4">
        <div class="col">

            <h1><?php $this->showValue('title'); ?></h1>

            <p><?php $this->showValue('message'); ?></p>

            <form action="db_sample.php" method="post" name="cuAdd">

                <p>
                    <button class="btn btn-primary" type="submit">Add Value (every reload will add a value)</button>
                </p>

            </form>

            <form action="db_sample.php" method="post" name="cuTruncate">

                <input type="hidden" name="action" value="truncateTable">

                <p>
                    <button class="btn btn-danger" type="submit">Truncate Table</button>
                </p>

            </form>


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
