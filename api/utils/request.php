<?php
// Функции по работе с запросами

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
