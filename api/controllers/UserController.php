<?php
require_once 'controllers/Controller.php';

/**
 * Тестовый контроллер для работы с юзерами
 */
class UserController extends Controller
{
  public function __construct(Responce $responce, PDO $readDB, PDO $writeDB)
  {
    parent::__construct($responce, $readDB, $writeDB);
  }

  public function signIn()
  {
    $this->sendSucces(200, ['Success'], null);
  }

  public function signUp()
  {
    $this->sendSucces(200, ['Success'], null);
  }
}