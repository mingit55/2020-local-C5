<?php
session_start();

define("DS", DIRECTORY_SEPARATOR);
define("_ROOT", dirname(__DIR__));
define("_SRC", _ROOT.DS."src");
define("_PUB", _ROOT.DS."public");
define("_UPLOAD", _PUB.DS."upload");
define("_VIEW", _SRC.DS."View");

require _SRC.DS."autoload.php";
require _SRC.DS."helper.php";
require _SRC.DS."web.php";