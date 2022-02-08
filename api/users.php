<?php

/**
* Эндпоинт для юзеров
*/

require_once 'providers/Responce.php';
require_once 'providers/factories.php';
require_once 'middlewares/checkContentType.php';
require_once 'middlewares/isMethodAllowed.php';

function init (): void
{
  $responce = new Responce();
  checkContentType($responce);
  isMethodAllowed($responce);
  useRouting(Creator::getInstance('user', $responce), $responce, $_SERVER['REQUEST_METHOD']);
}

// Переиспользуется. Нужно переделать на отдельный класс
function useRouting(UserController $userController, Responce $responce, string $method): void
{
  if($method === 'GET') {
    $userController->signIn();
  }
  elseif ($method === 'POST') {
    $userController->signUp();
  }
  else {
    $responce->sendExceptionError('Method Not Allowed', 405);
  }
}

init();
