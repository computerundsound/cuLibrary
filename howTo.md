# CuErrorhandler #

The CuErrorhandler can output meaningful error messages, and SIMPLY
and without making any changes to the source code, either suppress the error messages
or display. He can also forward the errors by email.

## Application example:

You are working on a tool on your dev server. You need meaningful Error messages.
In the productive environment, errors should also be displayed, but without manny
Information about the system.
However, it may be wise to have the error message sent to you by email.

Whether the errors should be displayed, whether just a simple page
(which they themselves can specify) whether the error message should be sent
by email can be determined simply by the presence of empty files.

The file is located

**debugShow.debug**

in your document root directory, meaningful error pages are generated.
If this is not available, another page will be displayed.

Is the file

**debugMail.debug**

exists, the error message will be sent by email.

Files can have one or none.

For example, it is often common practice to have the debugMail.debug file on the production server
However, use the debugShow.debug file on the dev server.

----

## How to - code integration:

The following line must be included:

CuErrorHandler::getInstance();

The return value of the method can be neglected.

If you would like to use the email function, you still have to tell the system
to whom the email should be written. Change the line to:

**(CuErrorHandler::getInstance())->setMailToAddress('youremail address');**

You can also pass further information to the error handler.
So you can show the error messages in your own template, or
Define even more information about the email (subject, name, etc.).

### Example:

<pre>
<code style="color: white">
(CuErrorHandler::getInstance())
->setMailToAddress('error@cu1723.com')
->setMailFromAddress('server@cu1723.com')
->setSubject('There was an Error on' . $_SERVER['HTTP_HOST'])
->setTemplateForErrorPath(__DIR__ . '/../close/myTemplate.php')
->setTemplateForNotShownErrorPath(__DIR__ . '/../close/myTemplateWithBasicInformation.php');
</code>
</pre>

The CuErrorHandlerParameter is present in every template. There you can
Retrieve various data (error code, ErrorMessage, file, line).

Have fun with it.