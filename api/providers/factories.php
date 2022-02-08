<?php

/**
* Возвращают инстансы различных классов. Как бы это не совсем реализация паттерна Фабрика
*/

// Подумать как убрать эти зависимости
require_once 'providers/DB.php';
require_once 'controllers/CommentController.php';
require_once 'controllers/UserController.php';

class Creator
{
  public static function getInstance($type, Responce $responce)
  {
    switch($type) {
      case 'comments':
        return self::_createCommentsController($responce);
      case 'user':
        return self::_createUserController($responce);
      default:
        return null;
    }
  }

  /**
  * Возвращает контроллер комментов
  * @param Responce $responce
  * @return CommentsController
  */
  private static function _createCommentsController(Responce $responce): CommentsController
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
  * Возвращает контроллер users
  * @param Responce $responce
  * @return CommentsController
  */
  private static function _createUserController(Responce $responce): UserController
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
    
    return new UserController($responce, $readDB, $writeDB);
  }
}
