<?php

/**
 * Модель для работы с БД
 */
class Model
{
  protected PDO $writeDB;
  protected PDO $readDB;
  protected PDOStatement $query;

  protected function __construct(PDO $writeDB, PDO $readDB)
  {
    $this->writeDB = $writeDB;
    $this->readDB = $readDB;
  }

  protected function prepareReadDB(string $selectStatement)
  {
    $this->query = $this->readDB->prepare($selectStatement);
  }

  protected function prepareInsertToDB(string $insertStatement): void
  {
    $this->query = $this->_writeDB->prepare($insertStatement);
  }

  protected function bindParam(string $param, string $value, int $type = PDO::PARAM_STR): void
  {
    $this->query->bindParam($param, $value, $type);
  }

  protected function execute(): void
  {
    $this->query->execute();
  }

  protected function getLastInsertedID(): ?string
  {
    return $this->_writeDB->lastInsertId();
  }

  protected function getRowCount(): int
  {
    return $this->query->rowCount();
  }

  protected function fetchAll(): mixed
  {
    return $this->query->fetch(PDO::FETCH_ASSOC);
  }

  protected function selectAllFromTable(string $selectStatement)
  {
    $this->prepareReadDB($selectStatement);
    $this->execute();
    return $this->fetchAll();
  }
}
