<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 06:11 MEZ
 */

/** @var $message */
/** @var $title */
/** @var $db_username */
/** @var $db_password */
/** @var $db_server */
/** @var $db_dbName */
/** @var stdClass $myObject */

?>

<div class="row">

    <div class="col-md-7">
        <h1><?php echo $title; ?></h1>
    </div>

    <div class="col-md-5">

        <div class="panel panel-primary">
            <div class="panel-body">
                <p>Go to Data-Base-Example <br>
                   You need a database with:</p>

                <table class="table  table-condensed">
                    <tr>
                        <th>Username</th>
                        <td><?php $this->showValue('db_username') ?></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><?php $this->showValue('db_password') ?></td>
                    </tr>
                    <tr>
                        <th>Server</th>
                        <td><?php $this->showValue('db_server') ?></td>
                    </tr>
                    <tr>
                        <th>DB-Name</th>
                        <td><?php $this->showValue('db_dbName') ?></td>
                    </tr>
                </table>
                <a href="db_sample.php">
                    <button class="btn btn-success">Go to DB-Example</button>
                </a>
            </div>
        </div>


    </div>
</div>


<h3>A foreach - Loop (assigned an Array from CuRequester::getClientData()):</h3>

<dl class="dl-horizontal">

    <?php /** @noinspection ForeachSourceInspection */
    foreach ($this->getValue('thisIsAnExampleArray') as $key => $valueFromArray):?>

        <dt><?php echo $key ?></dt>
        <dd><?php echo $valueFromArray ?></dd>

    <?php endforeach; ?>
</dl>


<h3>From an Object:</h3>
<p><?php echo $myObject->one; ?></p>


<h3>Just a small Form Example:</h3>


<div class="well">
    You can set the second parameter from the this->showValue() - method as 'true'. It will NOT use htmlspecialchars()
    function.
    Try to use &lt;b&gt;strong&lt;/b&gt; in input-Field.

    Send Data with htmlspecialchars switched off ($this->showValue('variableName', false):

</div>

<div class="alert alert-success">
    <?php $this->showValue('valueFromPostOrFromSession', false); ?>
</div>

<p>And with htmlspecialchars ($this->showValue('variableName')):</p>

<div class="alert alert-warning">
    <?php $this->showValue('valueFromPostOrFromSession'); ?>
</div>


<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>"
      method="post"
      enctype="application/x-www-form-urlencoded">

    <div class="form-group">
        <label for="formInputOne">Insert Value</label>
        <input type="text"
               id="formInputOne"
               name="valueFromPostOrFromSession"
               class="form-control"
               value="<?php $this->showValue('valueFromPostOrFromSession'); ?>">
    </div>

    <button type="submit" class="btn btn-default">Send</button>

</form>
