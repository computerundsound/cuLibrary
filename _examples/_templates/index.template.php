<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */

declare(strict_types=1);

use computerundsound\culibrary\CuDebug;

/** @var $message */
/** @var $title */
/** @var $db_username */
/** @var $db_password */
/** @var $db_server */
/** @var $db_dbName */
/** @var stdClass $myObject */

?>

<div class="row">

    <div class="col">
        <h1><?php echo $title; ?></h1>
    </div>
</div>

<div class="row">

    <div class="col-5">

        <div class="panel panel-primary">
            <div class="panel-body">

                <h4>For this example you need a clean database with following credentials:</h4>
                <p>You don't need to create a table. This will be done by this tool.</p>

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
                <!--suppress HtmlUnknownTarget -->
                <a href="db_sample.php">
                    <button class="btn btn-success">Go to DB-Example</button>
                </a>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row mt-4">

    <div class="col">

        <h3>Flash Message example</h3>

        <p>In your code, you save a Flashmessage with CuFlashMessage::save()</p>
        <p>When you run CuFlashMessage::get() it will return the Flashmessage and clear the saved Flashmessage.</p>


        <form action="#" method="post">

            <input type="hidden" name="action" value="showFlash">

            <p>
                <button class="btn btn-primary">Save Flashmessage</button>
            </p>

        </form>

    </div>

</div>

<hr>

<div class="row mt-4">
    <div class="col">
        <h3>Debug example:</h3>
        <code>
            CuDebug::show(['foo'=>'bar']);
        </code>
        will output:

        <?php CuDebug::show(['foo' => 'bar']); ?>

    </div>
</div>

<hr>

<div class="row mt-4">

    <div class="col">

        <h3>Assign arrays to an Template</h3>

        <p>A foreach - Loop (assigned an Array from CuRequester::getClientData()):</p>

        <dl class="dl-horizontal">

            <?php
            foreach ($this->getValue('thisIsAnExampleArray') as $key => $valueFromArray):?>

                <dt><?php echo $key ?></dt>
                <dd><?php echo $valueFromArray ?></dd>

            <?php endforeach; ?>
        </dl>


        <h3>Assign an Object:</h3>
        <p><?php echo $myObject->one; ?></p>

    </div>
</div>

<hr>

<div class="row">
    <div class="col">

        <h3>Just a small Form Example:</h3>

        <div class="well">
            You can set the second parameter from the this->showValue() - method as 'true'. It will NOT use
            htmlspecialchars()
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

            <button type="submit" class="btn btn-info">Send data</button>

        </form>
    </div>
</div>

<hr>

<div class="row mt-4">
    <div class="col">

        <h3>Send a Message with CuInfoMail()</h3>

        <div class="alert alert-primary">
            <p>If you run this on your localhost, then you have make sure, that the mail() function is working.</p>
        </div>

        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>"
              method="post"
              enctype="application/x-www-form-urlencoded">

            <input type="hidden" name="action" value="sendMail">

            <div class="form-group">

                <label for="formInputMail">Email</label>
                <input type="text"
                       class="form-control"
                       name="email"
                       value="<?php echo $emailAddress ?? ''; ?>"
                       id="formInputMail">
            </div>

            <p>
                <button class="btn btn-warning" type="submit">Send email</button>
            </p>

        </form>

    </div>
</div>

<div class="mt-4">&nbsp;</div>
<hr>