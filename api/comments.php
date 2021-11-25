<?php
/**
* Эндпоинт для работы с комментами
*/

// Подумать про замену на автолоадинг
require_once 'controllers/CommentController.php';
require_once 'providers/DB.php';
require_once 'models/Comment.php';
require_once 'providers/Responce.php';

function init() {
  $responce = new Responce();

  try {
    $readDB = DB::getConnection('read');
    $writeDB = DB::getConnection('write');
  }
  catch (PDOException $ex) {
    error_log('Connection error: '.$ex->getMessage(), 0);
    $responce->setSuccess(false);
    $responce->setStatusCode(500);
    $responce->addMessage(json_encode($ex->getMessage()));
    $responce->send();
    die();
  }
  
  $commentController = new CommentsController($responce, $readDB, $writeDB);
  
  if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $commentController->sendAllComments();
  }
  elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentController->saveNewComment([]);
  }
}

init();
