<?php

class ErrorController {
  function Page($param, $gets) {
    return render([
      'template' => '404',
      'params' => [],
      'title' => 'ไม่พบหน้า'
    ]);
  }
}
