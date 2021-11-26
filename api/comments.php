<?php
/**
* Эндпоинт для работы с комментами
*/

// Подумать про замену на автолоадинг
require_once 'controllers/CommentController.php';
require_once 'providers/DB.php';
require_once 'models/Comment.php';
require_once 'providers/Responce.php';
require_once 'middlewares/checkContentType.php';

function init() {
  $responce = new Responce();
  checkContentType($responce);
  useRouting(createCommentsController($responce), $responce, $_SERVER['REQUEST_METHOD']);
}

/**
 * Возвращает контроллер комментов
 * @param Responce $responce
 * @return CommentsController
 */
function createCommentsController(Responce $responce): CommentsController
{
  try {
    $readDB = DB::getConnection('read');
    $writeDB = DB::getConnection('write');
  }
  catch (PDOException $ex) {
    error_log('Connection error: '.$ex->getMessage(), 0);
    $responce->sendExceptionError($ex->getMessage());
    die();
  }
  
  return new CommentsController($responce, $readDB, $writeDB);
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


/**
 * Получает данные из запроса, проверяет их наличие и возвращает
 * @param Responce $responce
 * @return array
 */
function getDataFromRequest(Responce $responce): ?array
{
  try {
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData);
    if (!$data) {
      $responce->sendExceptionError('Wrong format', 400);
      die();
    }
    return $data;
  }
  catch (Exception $ex) {
    error_log('Exception error: '.$ex->getMessage(), 0);
    $responce->sendExceptionError($ex->getMessage());
    die();
  }
}

init();
