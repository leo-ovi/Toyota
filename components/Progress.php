<?php

class Progress {

  static $tableName = 'progresses';
  function __construct() {
  }

  static function get($id) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT progress_id AS `id`, title, content, departments.department_id AS `department_id`, departments.name AS `department_name`, file_path FROM ".self::$tableName."
    LEFT JOIN departments ON ".self::$tableName.".department_id = departments.department_id WHERE progress_id = :id");

    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    $stmt->execute();
    return $stmt->fetch( PDO::FETCH_ASSOC );
  }

  static function getList($where = '') {

    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT progress_id AS `id`, title, content, departments.department_id AS `department_id`, departments.name AS `department_name` FROM ".self::$tableName."
    LEFT JOIN departments ON ".self::$tableName.".department_id = departments.department_id $where");

    $stmt->execute();

    $arr = [];
    while($result = $stmt->fetch( PDO::FETCH_ASSOC )) {
      $arr[] = $result;
    }

    return $arr;
  }

  static function add($obj) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("INSERT INTO ".self::$tableName." (title,content,department_id,file_path)
    VALUES (:title,:content,:department_id,:file_path)");

    $stmt->bindParam(':title', $obj['title'], PDO::PARAM_STR);
    $stmt->bindParam(':content', $obj['content'], PDO::PARAM_STR);
    $stmt->bindParam(':department_id', $obj['department_id'], PDO::PARAM_STR);
    $stmt->bindParam(':file_path', $obj['file_path'], PDO::PARAM_STR);

    $stmt->execute();

    return $dbh->lastInsertId();
  }

  static function update($obj) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(!empty($obj['file_path'])) {
      $stmt = $dbh->prepare("UPDATE ".self::$tableName." SET
      title = :title ,
      content = :content ,
      department_id = :department_id ,
      file_path = :file_path
      WHERE
      progress_id = :progress_id");

      $stmt->bindParam(':title', $obj['title'], PDO::PARAM_STR);
      $stmt->bindParam(':content', $obj['content'], PDO::PARAM_STR);
      $stmt->bindParam(':department_id', $obj['department_id'], PDO::PARAM_STR);
      $stmt->bindParam(':progress_id', $obj['progress_id'], PDO::PARAM_STR);
      $stmt->bindParam(':file_path', $obj['file_path'], PDO::PARAM_STR);
    } else {
      $stmt = $dbh->prepare("UPDATE ".self::$tableName." SET
      title = :title ,
      content = :content ,
      department_id = :department_id
      WHERE
      progress_id = :progress_id");

      $stmt->bindParam(':title', $obj['title'], PDO::PARAM_STR);
      $stmt->bindParam(':content', $obj['content'], PDO::PARAM_STR);
      $stmt->bindParam(':department_id', $obj['department_id'], PDO::PARAM_STR);
      $stmt->bindParam(':progress_id', $obj['progress_id'], PDO::PARAM_STR);
    }

    return $stmt->execute();
  }

  static function remove($id) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("DELETE FROM ".self::$tableName." WHERE progress_id = :progress_id ");

    $stmt->bindParam(':progress_id', $id, PDO::PARAM_STR);

    if(!$stmt->execute()) {
      return false;
    }

    return Image::removeByProgress($id);
  }

  static function size($where = '') {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT COUNT(*) AS size FROM ".self::$tableName." $where");

    $stmt->execute();

    return $stmt->fetch( PDO::FETCH_ASSOC );
  }
}
