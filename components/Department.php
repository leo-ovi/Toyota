<?php

class Department {
  static $tableName = 'departments';
  function __construct() {
  }

  static function getDepartmentList($where = '') {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT department_id AS `id`, name, sub FROM ".self::$tableName."");

    $stmt->execute();

    $arr = [];
    while($result = $stmt->fetch( PDO::FETCH_ASSOC )) {
      $arr[] = $result;
    }

    return $arr;
  }

  static function update($obj) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("UPDATE ".self::$tableName." SET
    name = :name,
    sub = :sub
    WHERE
    department_id = :department_id");

    $stmt->bindParam(':name', $obj['name'], PDO::PARAM_STR);
    $stmt->bindParam(':sub', $obj['sub'], PDO::PARAM_STR);
    $stmt->bindParam(':department_id', $obj['department_id'], PDO::PARAM_STR);

    return $stmt->execute();
  }

  static function getSubList($id) {
      $list = [];

      foreach (Department::getList() as $department) {
        if( $department['sub'] == $id ) {
          $list[] = $department;
        }
      }

      return $list;
  }

  static function getList($where = '') {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT * FROM ".self::$tableName."");

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

    $stmt = $dbh->prepare("INSERT INTO ".self::$tableName." (name,sub)
    VALUES (:name,:sub)");

    $stmt->bindParam(':name', $obj['name'], PDO::PARAM_STR);
    $stmt->bindParam(':sub', $obj['sub'], PDO::PARAM_STR);

    $stmt->execute();

    return $dbh->lastInsertId();
  }

  static function get($id) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT department_id, name AS department_name, sub FROM ".self::$tableName." WHERE department_id = :did ");

    $stmt->bindParam(':did', $id, PDO::PARAM_STR);

    $stmt->execute();

    return $stmt->fetch( PDO::FETCH_ASSOC );
  }

  static function getSub($sub) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT department_id, name AS department_name, sub FROM ".self::$tableName." WHERE sub = :sub ");

    $stmt->bindParam(':sub', $sub, PDO::PARAM_STR);

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

    $stmt = $dbh->prepare("DELETE FROM ".self::$tableName." WHERE department_id = :department_id ");

    $stmt->bindParam(':department_id', $id, PDO::PARAM_STR);

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
