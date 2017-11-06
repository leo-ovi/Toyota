<?php

class LoginController {
  function Page($params, $gets) {
    return render([
      'template' => 'login',
      'params' => [],
      'title' => 'LOGIN'
    ]);
  }

  function Login($params, $gets) {
    $status = false;
    $message = '';

    if( !isset($_POST['username']) || !isset($_POST['password']) ) {
      $status = false;
      $message = 'ผิดพลาด';
    } else {
      try {
        $userService = new User();
        $userService->setAuth($_POST['username'], md5($_POST['password']));
        $result = $userService->login();

        if(count($result) == 1) {
          $status = false;
          $message = '<strong>เข้่าสู่ระบบผิดพลาด</strong> กรุณาลองใหม่';
        } else {
          $_SESSION['user_username'] = $result['username'];
          $_SESSION['user_password'] = $result['password'];

          // จัดเก็บข้อมูลไว้ที่ตัวแปร Global `USER`
          $GLOBALS['user'] = $result;

          $status = true;
          $message = 'เข้าระบบสำเร็จ, สวัสดี <strong>' . $result['fullname'] . '</strong>';
        }

      } catch(Exception $e) {
        $message = 'We are unable to process your request. Please try again later"';
      }
    }

    return render([
      'template' => 'post/message',
      'params' => [
        'status' => $status,
        'message' => $message
      ],
      'title' => 'เข้าสู่ระบบ'
    ]);
  }

  function Logout() {
    $status = false;
    $message = '';

    $userService = new User();
    if($userService->logout()) {
      $status = true;
      $message = "ออกจากระบบสำเร็จ";
    }

    return render([
      'template' => 'post/message',
      'params' => [
        'status' => $status,
        'message' => $message
      ],
      'title' => 'ออกจากระบบ'
    ]);
  }
}
