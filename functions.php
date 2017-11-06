<?php

function render($params) {
  $params['type'] = 'render';
  return $params;
}

function json($params) {
  $params['type'] = 'json';
  return $params;
}

function isRoute($path) {
  $tempPath = explode('?', $_SERVER['REQUEST_URI']);
  return $tempPath[0] === $path;
}

function isActive($path) {
  return (isRoute($path)) ? 'active' : '';
}

function autoLogin() {
  $GLOBALS['user'] = null;
  if( isset($_SESSION['user_username']) && isset($_SESSION['user_password']) ) {
    $userService = new User();
    $userService->setAuth($_SESSION['user_username'], $_SESSION['user_password']);
    $GLOBALS['user'] = $userService->login();
  }
}

function uploadImage($temp, $name) {
  if(move_uploaded_file($temp, "./uploads/$name")) {
    return true;
  }
  return false;
}

function getImageName($fileName) {
  $now = time();
  $names = explode('.', $fileName);
  $name = '';
  for($i=0; $i<count($names); $i++) {
    if(($i+1) == count($names)) {
      $name .= "-$now." . $names[$i];
    } else {
      $name .= $names[$i];
    }
  }
  return $name;
}
