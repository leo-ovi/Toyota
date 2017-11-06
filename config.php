<?php

// ตรวจสอบว่าเข้าผ่านจากหน้า Index หรือไม่? ถ้าไม่จะทำการ Redirect.
include './defined.php';

autoloads();
autoLogin();

// ตรวจหา Path ที่ต้องการเพื่อดึง Component ออกมาแสดง.
include './routes.php';


function autoloads() {
  if ($handle = opendir( PATH_COMPONENT )) {

    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        include PATH_COMPONENT . '/' . $entry;
      }
    }

    closedir($handle);
  }

  if ($handle = opendir( PATH_CONTROLLER )) {

    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        include PATH_CONTROLLER . '/' . $entry;
      }
    }

    closedir($handle);
  }
}
