<?php

require_once "core/boot.php";

if(file_exists("views/".$view->getPageURL())) include_once "views/".$view->getPageURL();
else {
    $requestMapper->toErrorPage(404);
}