<?php

class Slide {
  static $tableName = 'slides';
  function __construct() {
  }

  static function get($id) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT * FROM ".self::$tableName." WHERE slide_id = :id");

    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    $stmt->execute();
    return $stmt->fetch( PDO::FETCH_ASSOC );
  }

  static function add($obj) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("INSERT INTO ".self::$tableName." (title,description,image)
    VALUES (:title,:description,:image)");

    $stmt->bindParam(':title', $obj['title'], PDO::PARAM_STR);
    $stmt->bindParam(':description', $obj['description'], PDO::PARAM_STR);
    $stmt->bindParam(':image', $obj['image'], PDO::PARAM_STR);

    return $stmt->execute();
  }

  static function update($obj) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($obj['image'] == '') {
      $stmt = $dbh->prepare("UPDATE ".self::$tableName." SET
      title = :title ,
      description = :description
      WHERE
      slide_id = :slide_id");
    } else {
      $stmt = $dbh->prepare("UPDATE ".self::$tableName." SET
      title = :title ,
      description = :description ,
      image = :image
      WHERE
      slide_id = :slide_id");
      $stmt->bindParam(':image', $obj['image'], PDO::PARAM_STR);
    }

    $stmt->bindParam(':title', $obj['title'], PDO::PARAM_STR);
    $stmt->bindParam(':description', $obj['description'], PDO::PARAM_STR);
    $stmt->bindParam(':slide_id', $obj['slide_id'], PDO::PARAM_STR);

    return $stmt->execute();
  }

  static function getList($where = '') {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT slide_id AS `id`, title, description, image, create_date FROM ".self::$tableName." $where");

    $stmt->execute();

    $arr = [];
    while($result = $stmt->fetch( PDO::FETCH_ASSOC )) {
      $arr[] = $result;
    }

    return $arr;
  }

  static function remove($id) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("DELETE FROM ".self::$tableName." WHERE slide_id = :slide_id ");

    $stmt->bindParam(':slide_id', $id, PDO::PARAM_STR);

    return $stmt->execute();
  }

  static function size($where = '') {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT COUNT(*) AS size FROM ".self::$tableName." $where");

    $stmt->execute();

    return $stmt->fetch( PDO::FETCH_ASSOC );
  }
}
