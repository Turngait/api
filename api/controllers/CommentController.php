<?php
require_once 'controllers/Controller.php';

/**
 * Тестовый контроллер для сохранения комментов
 */
class CommentsController extends Controller
{
  public function __construct(Responce $responce, PDO $readDB, PDO $writeDB)
  {
    parent::__construct($responce, $readDB, $writeDB);
  }

  /**
  * Отправляет все комменты
  * @return void
  */
  public function sendAllComments(): void
  {
    $comments = array();

    try {
      // TODO перенести в модель
      $query = $this->_readDB->prepare('SELECT id, title, text, user_name, email, DATE_FORMAT(date, "%d/%m/%Y %H:%i") as date FROM comments');
      $query->execute();
      $rowCount = $query->rowCount();

      if ($rowCount === 0) {
        $this->sendSucces(200, ['Comments not found'], null);
      }

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $comment = new Comment($this->_writeDB, $this->_readDB, $row['title'], $row['text'], $row['user_name'], $row['date'], $row['email'], $row['id']);
        $comments[] = $comment->getCommentAsArray();
      }

      $this->sendSucces(200, ['Comments found'], $comments);
    }
    catch (PDOException $ex) {
      $this->sendError('Connection error: ' . $ex->getMessage());
    }
    catch (CommentsException $ex) {
      $this->sendError('Create task error: ' . $ex->getMessage());
    }
    catch (Exception $ex) {
      $this->sendError('Exception: ' . $ex->getMessage());
    }
  }

  /**
  * Создает новый коммент
  * @param mixed $data
  */
  public function saveNewComment(mixed $data)
  {
    // Code
    try {
      $this->validatePostData($data);
      $comment = new Comment($this->_writeDB, $this->_readDB, $data->title, $data->text, $data->userName, $data->date, $data->email);
      $newComment = $comment->getCommentAsArray();

      // TODO перенести в модель
      $insertStatment = 'INSERT INTO comments (`user_name`, `email`, `date`, `title`, `text`) VALUES(:user_name, :email, STR_TO_DATE(:date, "%d/%m/%Y %H:%i"), :title, :text)';
      $query = $this->_writeDB->prepare($insertStatment);
      $query->bindParam(':user_name', $newComment['userName'], PDO::PARAM_STR);
      $query->bindParam(':email', $newComment['email'], PDO::PARAM_STR);
      $query->bindParam(':date', $newComment['date'], PDO::PARAM_STR);
      $query->bindParam(':title', $newComment['title'], PDO::PARAM_STR);
      $query->bindParam(':text', $newComment['text'], PDO::PARAM_STR);

      $query->execute();
      $rowCount = $query->rowCount();
      if ($rowCount === 1) {
        $newComment['id'] = $this->_writeDB->lastInsertId();
        $this->sendSucces(200, ['Comment created'], $newComment);
      } else {
        $this->sendError('Failed to create comment');
      }
    }
    catch (PDOException $ex) {
      $this->sendError('Connection error: ' . $ex->getMessage());
    }
    catch (CommentsException $ex) {
      $this->sendError('Create task error: ' . $ex->getMessage());
    }
    catch (Exception $ex) {
      $this->sendError('Exception: ' . $ex->getMessage());
    }
  }

  private function validatePostData(mixed $data): void
  {
    (!isset($data->title)) ? $this->sendError('Нехватает заголовка') : null;
    (!isset($data->text)) ? $this->sendError('Нехватает текста') : null;
    (!isset($data->userName)) ? $this->sendError('Нехватает именю пользователя') : null;
    (!isset($data->date)) ? $this->sendError('Нехватает даты') : null;
    (!isset($data->email)) ? $this->sendError('Нехватает email') : null;
  }
}
