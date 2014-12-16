<?php

require_once "core/boot.php";

if(file_exists("views/".$view->getPageURL())) include_once "views/".$view->getPageURL();
else {
    $Route->toErrorPage(404);
}