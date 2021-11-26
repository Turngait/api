<?php

/**
 * Контроллер проверяющий тип контента переданного от клиента
 * @param Responce $responce
 * @return void
 */
function checkContentType(Responce $responce): void
{
  $headers = getallheaders();
  if (!isset($headers['Content-Type']) || $headers['Content-Type'] !== 'application/json') {
    $responce->sendExceptionError('JSON format needed', 400);
    die();
  }
}
