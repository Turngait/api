<?php

class Settings
{
  private static $_dbName = '';
  private static $_writeDBCluster = '';
  private static $_readDBCluster = '';
  private static $allowedMethods = ['POST', 'GET', 'PUT', 'PATCH', 'DELETE'];
  private static $allowedContentType = ['application/json'];

  public static function getAllowedMethods()
  {
    return self::$allowedMethods;
  }
  public static function getAllowedContentType()
  { 
    return self::$allowedContentType;
  }
}
