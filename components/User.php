<?php

class User {
  private $username = '';
  private $password = '';
  static $tableName = 'users';
  function __construct() {
  }

  function setAuth($username, $password) {
    $this->username = $username;
    $this->password = $password;
  }

  function login() {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT * FROM ".self::$tableName." WHERE username = :username AND password = :password");

    $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $this->password, PDO::PARAM_STR, 40);

    $stmt->execute();
    return $stmt->fetch( PDO::FETCH_ASSOC );
  }

  function logout() {
    session_destroy();
    $GLOBALS['user'] = null;
    return true;
  }

  static function get($id) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT * FROM ".self::$tableName." WHERE user_id = :id");

    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    $stmt->execute();
    return $stmt->fetch( PDO::FETCH_ASSOC );
  }

  static function getList($where = '') {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT user_id AS `id`, fullname, no, username, position, departments.department_id AS `department_id`, departments.name AS `department_name` FROM ".self::$tableName."
    LEFT JOIN departments ON users.department_id = departments.department_id $where");

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

    $stmt = $dbh->prepare("INSERT INTO users (no,fullname,position,department_id,username,password)
    VALUES (:no,:fullname,:position,:department_id,:username,:password)");

    $stmt->bindParam(':fullname', $obj['fullname'], PDO::PARAM_STR);
    $stmt->bindParam(':position', $obj['position'], PDO::PARAM_STR);
    $stmt->bindParam(':no', $obj['no'], PDO::PARAM_STR);
    $stmt->bindParam(':department_id', $obj['department_id'], PDO::PARAM_STR);
    $stmt->bindParam(':username', $obj['username'], PDO::PARAM_STR);
    $stmt->bindParam(':password', md5($obj['password']), PDO::PARAM_STR);

    return $stmt->execute();
  }

  static function update($obj) {
    $dbh = connectDB();

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($obj['password'] == '') {
      $stmt = $dbh->prepare("UPDATE users SET
        no = :no ,
        fullname = :fullname ,
        position = :position ,
        department_id = :department_id ,
        username = :username
        WHERE
        user_id = :user_id");
      } else {
        $stmt = $dbh->prepare("UPDATE users SET
          no = :no ,
          fullname = :fullname ,
          position = :position ,
          department_id = :department_id ,
          username = :username ,
          password = :password
          WHERE
          user_id = :user_id");
          $stmt->bindParam(':password', md5($obj['password']), PDO::PARAM_STR);
        }

        $stmt->bindParam(':fullname', $obj['fullname'], PDO::PARAM_STR);
        $stmt->bindParam(':position', $obj['position'], PDO::PARAM_STR);
        $stmt->bindParam(':no', $obj['no'], PDO::PARAM_STR);
        $stmt->bindParam(':department_id', $obj['department_id'], PDO::PARAM_STR);
        $stmt->bindParam(':username', $obj['username'], PDO::PARAM_STR);

        $stmt->bindParam(':user_id', $obj['id'], PDO::PARAM_STR);

        return $stmt->execute();
      }

      static function remove($id) {
        $dbh = connectDB();

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $dbh->prepare("DELETE FROM users WHERE user_id = :user_id ");

        $stmt->bindParam(':user_id', $id, PDO::PARAM_STR);

        return $stmt->execute();
      }

      static function size($where = '') {
        $dbh = connectDB();

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $dbh->prepare("SELECT COUNT(*) AS size FROM ".self::$tableName." $where");

        $stmt->execute();

        return $stmt->fetch( PDO::FETCH_ASSOC );
      }

      static function isAdmin() {
        return ( isset($GLOBALS['user']) && $GLOBALS['user']['position'] == 'ผู้ดูแลระบบ' );
      }
    }
