<?php
/**
* Эндпоинт для работы с комментами
*/

// Подумать про замену на автолоадинг
require_once 'middlewares/checkContentType.php';

require_once 'providers/Responce.php';
require_once 'providers/factories.php';
require_once 'utils/request.php';

require_once 'models/Comment.php';

function init(): void
{
  $responce = new Responce();
  checkContentType($responce);
  useRouting(Creator::getInstance('comments', $responce), $responce, $_SERVER['REQUEST_METHOD']);
}


/**
 * Обрабатывает маршруты
 * @param CommentsController $commentController
 * @param Responce $responce
 * @param string $method
 * @return void
 */
function useRouting(CommentsController $commentController, Responce $responce, string $method): void
{
  if($method === 'GET') {
    $commentController->sendAllComments();
  }
  elseif ($method === 'POST') {
    $commentController->saveNewComment(getDataFromRequest($responce));
  }
  else {
    $responce->sendExceptionError('Method Not Allowed', 405);
  }
}

init();
