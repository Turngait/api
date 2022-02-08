<?php
// Подумать про замену на автолоадинг
require_once 'providers/Responce.php';

function init() {
  $responce = new Responce();
  if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $responce->setSuccess(true);
    $responce->setStatusCode(200);
    $responce->addMessage('GET - /comments - get all comments');
    $responce->addMessage('POST - /comments - create new comment');
    $responce->addMessage('Content-type - only JSON');
    $responce->send();
  }
}

init();