<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.04 at 23:56 MEZ
 */

/** @var array $cuConstants */

?>

<h2>Elements from the cuConstantsContainer</h2>


<dl class="dl-horizontal">
    <?php foreach ($cuConstants as $key => $value): ?>
        <dt><?php $this->showAsHtml($key); ?></dt>
        <dd><?php $this->showAsHtml($value); ?></dd>
    <?php endforeach; ?>
</dl>
