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
      // Возможно стоило бы эту логику в модели отправить, для как бы реализации патттерна ActiveRocords 
      $query = $this->_readDB->prepare('SELECT id, title, text, user_name, email, DATE_FORMAT(date, "%d/%m/%Y %H:%i") as date FROM comments');
      $query->execute();
      $rowCount = $query->rowCount();

      if ($rowCount === 0) {
        $this->sendSucces(200, ['Comments not found'], null);
      }

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $comment = new Comment($row['id'], $row['title'], $row['text'], $row['user_name'], $row['date'], $row['email']);
        $comments[] = $comment->getCommentAsArray();
      }

      $this->sendSucces(200, ['Comments found'], $comments);
    } catch (PDOException $ex) {
      $this->sendError('Connection error: ' . $ex->getMessage());
    } catch (CommentsException $ex) {
      $this->sendError('Create task error: ' . $ex->getMessage());
    } catch (Exception $ex) {
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
  }
}
