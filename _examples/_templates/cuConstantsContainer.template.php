<?php
declare(strict_types=1);
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cu1723.de
 *
 */

/** @var array $cuConstants */

?>

<div class="row mb-5">
    <div class="col">

        <h2>Elements from the cuConstantsContainer</h2>

        <dl class="dl-horizontal">
            <?php foreach ($cuConstants as $key => $value): ?>
                <dt><?php $this->showAsHtml($key); ?></dt>
                <dd><?php $this->showAsHtml($value); ?></dd>
            <?php endforeach; ?>
        </dl>

    </div>
</div>