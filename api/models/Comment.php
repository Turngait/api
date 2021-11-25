<?php

class CommentsException extends Exception {}

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

    public function setID(?int $id): void
    {
      if(($id !== null && !is_numeric($id)) || $id === 0) {
        throw new CommentsException('Comment id error');
      }

      $this->_id = $id;
    }

    public function setTitle(string $title): void
    {
      if(strlen($title) >= 255 && strlen($title) <= 0) {
        throw new CommentsException('Comment title error');
      }

      $this->_title = $title;
    }

    public function setText(string $text): void
    {
      if(strlen($text) <= 0) {
        throw new CommentsException('Comment text error');
      }

      $this->_text = $text;
    }

    public function setUserName(string $userName): void
    {
      if(strlen($userName) >= 255 && strlen($userName) <= 0) {
        throw new CommentsException('Comment userName error');
      }

      $this->_userName = $userName;
    }

    public function setDate(string $date): void
    {
      if($date !== null && date_format(date_create_from_format('d/m/Y H:i', $date), 'd/m/Y H:i') !== $date) {
        throw new CommentsException('Comment date error');
      }

      $this->_date = $date;
    }

    public function setEmail(string $email): void
    {
      // if(strlen($userName) >= 255 && strlen($userName) <= 0) {
      //   throw new CommentsException('Comment userName error');
      // }

      $this->_email = $email;
    }

    public function getCommentAsArray()
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