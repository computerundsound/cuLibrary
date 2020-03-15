# Small Library - little helper for php-developer #


Needs PHP 7.4+ (for php < 7.4 use older cuLibrary version)

Very easy using!

You can include_once 'culibincluder.start.php';

Then you have autoload (or better use composer)

Install with:

    composer install computerundsound/culibrary

### You can see some examples in /_examples/

The best way for running the examples on server.  
Just copy the whole cuLibrary-dir into a directory of your server (localhost for example)  
Then start http://your-server/directoryFromCuServer/_examples/

Or just read the code :-)

# Why this?
This is a very(!) small library. I use it for little projects (often when I have only to build very small thinks 
like a vcard-page ore another onepage-tool)

## Highlights:

* Save an Array to Database is only one line: $db->cuInsert($tableName, $accocArray);
* Many other easy to use Database function like "cuSelectOneDataSet()", "cuUpdate()", "cuSelectAsArray()"
* Easy MailInfo. 
* Save Flashmessages
* Get standard Constants like AppRoot, HttpServerPath - etc...
* MiniTemplateEngine
* Easy Debuginfo


[Computer-Und-Sound](http://www.Computer-Und-Sound.de)