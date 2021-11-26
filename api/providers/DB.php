<?php

/**
 * Создает соединения с кластерами БД
 */
class DB
{
  private static $_writeDBConnection;
  private static $_readDBConnection;
  private static $_readDBConnectionString;
  private static $_writeDBConnectionString;

  /**
   * Подготовка перед создания подключения.
   *
   * @param void
   * @return void
   */
  private static function prepare(): void
  {
    if (!isset($_ENV['DB_NAME']) || !isset($_ENV['READ_DB_CLUSTER']) || !isset($_ENV['WRITE_DB_CLUSTER'])) {
      throw new PDOException('Need more env variables');
    }
    self::$_readDBConnectionString = 'mysql:host=' . $_ENV['READ_DB_CLUSTER'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8';
    self::$_writeDBConnectionString = 'mysql:host=' . $_ENV['WRITE_DB_CLUSTER'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8';
  }

  /**
   * Создает соединение с БД кластером для внесения записей
   * @return PDO
   */
  private static function createWriteConnection(): PDO
  {
    if (self::$_writeDBConnection === null) {
      self::$_writeDBConnection = new PDO(self::$_writeDBConnectionString, 'root', $_ENV['DB_PASS']);
      self::$_writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$_writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    return self::$_writeDBConnection;
  }

  /**
   * Создает соединение с БД кластером для чтения
   * @return PDO
   */
  private static function createReadConnection(): PDO
  {
    if (self::$_readDBConnection === null) {
      self::$_readDBConnection = new PDO(self::$_readDBConnectionString, 'root', $_ENV['DB_PASS']);
      self::$_readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$_readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    return self::$_readDBConnection;
  }

  /**
   * Возвращает объект PDO
   * @param string $mode
   * @return PDO
   */
  public static function getConnection($mode = 'read')
  {
    self::prepare();
    if ($mode === 'read') {
      return self::createReadConnection();
    } elseif ($mode === 'write') {
      return self::createWriteConnection();
    } else {
      throw new Exception('Wrong DB mode');
    }
  }
}
