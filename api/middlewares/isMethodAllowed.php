<?php

require_once 'settings.php';

function isMethodAllowed (Responce $responce): void
{
  if (!in_array(strtoupper($_SERVER['REQUEST_METHOD']), Settings::getAllowedMethods())) {
    $responce->sendExceptionError('HTTP method not allowed', 405);
    die();
  }
}
