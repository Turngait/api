<?php

class Responce 
{
    private $_success;
    private $_httpStatusCode;
    private $_messages = array();
    private $_data;
    private $_responceData = array();

    public function setSuccess(bool $success): void
    {
      $this->_success = $success;
    }

    public function setStatusCode(int $statusCode): void
    {
      $this->_httpStatusCode = $statusCode;
    }
  
    public function addMessage(string $message): void
    {
      $this->_messages[] = $message;
    }

    public function setData(mixed $data): void
    {
      $this->_data = $data;
    }

    public function send(): void
    {
      header('Content-type: application/json;charset=utf-8');
      
      if(($this->_success !== false && $this->_success !== true) || !is_numeric($this->_httpStatusCode)) {
        http_response_code(500);
        $this->_responceData['statusCode'] = 500;
        $this->_responceData['success'] = false;
        $this->addMessage('Responce error');
        $this->_responceData['messages'] = $this->_messages;
      }
      else {
        http_response_code($this->_httpStatusCode);
        $this->_responceData['statusCode'] = $this->_httpStatusCode;
        $this->_responceData['success'] = $this->_success;
        $this->_responceData['messages'] = $this->_messages;
        $this->_responceData['data'] = $this->_data;
      }

      echo json_encode($this->_responceData);
    }

}
