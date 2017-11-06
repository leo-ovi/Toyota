<?php

class Image {

  static $tableName = 'images';
  function __construct() {
  }

  static function getImagesByProgress($id) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT * FROM ".self::$tableName." WHERE progress_id = :id ORDER BY cast(name as unsigned) DESC");

    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    $stmt->execute();

    $arr = [];
    while($result = $stmt->fetch( PDO::FETCH_ASSOC )) {
      $arr[] = $result;
    }

    return $arr;
  }

  static function removeByProgress($id) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("DELETE FROM ".self::$tableName." WHERE progress_id = :progress_id ");

    $stmt->bindParam(':progress_id', $id, PDO::PARAM_STR);

    return $stmt->execute();
  }

  static function add($obj) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("INSERT INTO ".self::$tableName." (name,progress_id)
    VALUES (:name,:progress_id)");

    $stmt->bindParam(':name', $obj['name'], PDO::PARAM_STR);
    $stmt->bindParam(':progress_id', $obj['progress_id'], PDO::PARAM_STR);

    return $stmt->execute();
  }

  static function getList($where = '') {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT * FROM ".self::$tableName." $where");

    $stmt->execute();

    $arr = [];
    while($result = $stmt->fetch( PDO::FETCH_ASSOC )) {
      $arr[] = $result;
    }

    return $arr;
  }

  static function size($where = '') {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT COUNT(*) AS size FROM ".self::$tableName." $where");

    $stmt->execute();

    return $stmt->fetch( PDO::FETCH_ASSOC );
  }
}
