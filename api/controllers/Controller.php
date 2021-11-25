<?php

class Controller {
  protected Responce $_responce;
  protected PDO $_readDB;
  protected PDO $_writeDB;

  public function __construct(Responce $responce, PDO $readDB, PDO $writeDB)
  {
    $this->_responce = $responce;
    $this->_readDB = $readDB;
    $this->_writeDB = $writeDB;
  }

  protected function sendSucces(int $statusCode = 200, array $messages = [], mixed $data = null): void
  {
    $this->_responce->setSuccess(true);
    $this->_responce->setStatusCode($statusCode);
    $this->_responce->addMessage(...$messages);
    $this->_responce->setData($data);
    $this->_responce->send();
    exit();
  }

  protected function sendError(string $message): void
  {
    error_log($message, 0);
    $this->_responce->setSuccess(false);
    $this->_responce->setStatusCode(500);
    $this->_responce->addMessage(json_encode($message));
    $this->_responce->send();
    die();
  }
}