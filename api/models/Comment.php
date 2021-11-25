<?php

class CommentsException extends Exception {}

/**
 *  Тестовый класс для работы с комментами
 */
class Comment
{
    private ?int $_id;
    private string $_title;
    private string $_text;
    private string $_userName;
    private string $_date;
    private string $_email;

    public function __construct(?int $id, string $title, string $text, string $userName, string $date, string $email)
    {
      $this->setID($id);
      $this->setTitle($title);
      $this->setText($text);
      $this->setUserName($userName);
      $this->setDate($date);
      $this->setEmail($email);
    }

    public function getID(): ?int
    {
      return $this->_id;
    }

    public function getTitle(): string
    {
      return $this->_title;
    }

    public function getUserName(): string
    {
      return $this->_text;
    }

    public function getDate(): string
    {
      return $this->_userName;
    }

    public function getText(): string
    {
      return $this->_date;
    }

    public function getEmail(): string
    {
      return $this->_email;
    }

    /**
    * @param int $id
    * @return void
    */
    public function setID(?int $id): void
    {
      if(($id !== null && !is_numeric($id)) || $id === 0) {
        throw new CommentsException('Comment id error');
      }

      $this->_id = $id;
    }

    /**
    * @param string $title
    * @return void
    */
    public function setTitle(string $title): void
    {
      if(strlen($title) >= 255 && strlen($title) <= 0) {
        throw new CommentsException('Comment title error');
      }

      $this->_title = $title;
    }

    /**
    * @param string $text
    * @return void
    */
    public function setText(string $text): void
    {
      if(strlen($text) <= 0) {
        throw new CommentsException('Comment text error');
      }

      $this->_text = $text;
    }

    /**
    * @param string $userName
    * @return void
    */
    public function setUserName(string $userName): void
    {
      if(strlen($userName) >= 255 && strlen($userName) <= 0) {
        throw new CommentsException('Comment userName error');
      }

      $this->_userName = $userName;
    }

    /**
    * @param string $date
    * @return void
    */
    public function setDate(string $date): void
    {
      if($date !== null && date_format(date_create_from_format('d/m/Y H:i', $date), 'd/m/Y H:i') !== $date) {
        throw new CommentsException('Comment date error');
      }

      $this->_date = $date;
    }

    /**
    * @param string $email
    * @return void
    */
    public function setEmail(string $email): void
    {
      // if(strlen($userName) >= 255 && strlen($userName) <= 0) {
      //   throw new CommentsException('Comment userName error');
      // }

      $this->_email = $email;
    }

    /**
    * Отдает коммент как ассоциативный массив
    * @return array
    */
    public function getCommentAsArray(): array
    {
      $comment = [];
      $comment['id'] = $this->_id;
      $comment['userName'] = $this->_userName;
      $comment['email'] = $this->_email;
      $comment['title'] = $this->_title;
      $comment['text'] = $this->_text;
      $comment['date'] = $this->_date;

      return $comment;
    }
}
