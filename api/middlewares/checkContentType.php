<?php

require_once 'settings.php';

/**
 * Контроллер проверяющий тип контента переданного от клиента
 * @param Responce $responce
 * @return void
 */
function checkContentType(Responce $responce): void
{
  $headers = getallheaders();
  if (!isset($headers['Content-Type']) || !in_array($headers['Content-Type'], Settings::getAllowedContentType())) {
    $responce->sendExceptionError('Wrong Content-Type', 400);
    die();
  }
}
