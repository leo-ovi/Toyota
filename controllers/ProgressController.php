<?php

class ProgressController {

  private $menus_progress = [
    'title' => 'ตัวเลือกจัดการขั้นตอน',
    'list' => [
      [
        'name' => 'ดูขั้นตอนทั้งหมด',
        'url' => '/admin/progresses'
      ],
      [
        'name' => '<i class="fa fa-plus-circle"></i> เพิ่มขั้นตอนปฏิบัติ',
        'url' => '/admin/progresses/new'
      ]
    ]
  ];

  private $title_admin = 'จัดการระบบ: ขั้นตอนการปฏิบัติ';

  function __construct() {
    if(!User::isAdmin() && strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
      header( "location: /404" );
      exit(0);
    }
  }

  function ListPage($param, $gets) {
    $department = Department::get($param['id']);
    if( isset($GLOBALS['user']) ) {
      if( $GLOBALS['user']['department_id'] != $department['department_id'] && $GLOBALS['user']['department_id'] != 0 ) {
        return render([
          'template' => '/notAccess',
          'params' => [
            'message' => '<strong>ผิดพลาด! </strong> คุณไม่ได้รับอนุญาติในส่วนนี้ !'
          ],
          'title' => 'ไม่ได้รับอนุญาติ!'
        ]);
      }
    } else {
      return render([
        'template' => '/notAccess',
        'params' => [
          'message' => '<strong>ผิดพลาด! </strong> กรุณาเข้าระบบ !'
        ],
        'title' => 'ไม่ได้เข้าระบบ!'
      ]);
    }
    return render([
      'template' => '/list',
      'params' => [
        'department' => $department
      ],
      'title' => 'ขั้นตอนการปฏิบัติ : ' . $department['department_name']
    ]);
  }

  function ShowPage($param, $gets) {
    $progress = Progress::get($param['id']);
    if( isset($GLOBALS['user']) ) {
      if( $GLOBALS['user']['department_id'] != $progress['department_id'] && $GLOBALS['user']['department_id'] != 0 ) {
        return render([
          'template' => '/notAccess',
          'params' => [
            'message' => '<strong>ผิดพลาด! </strong> คุณไม่ได้รับอนุญาติในส่วนนี้ !'
          ],
          'title' => 'ไม่ได้รับอนุญาติ!'
        ]);
      }
    } else {
      return render([
        'template' => '/notAccess',
        'params' => [
          'message' => '<strong>ผิดพลาด! </strong> กรุณาเข้าระบบ !'
        ],
        'title' => 'ไม่ได้เข้าระบบ!'
      ]);
    }
    return render([
      'template' => '/show',
      'params' => [
        'progress' => $progress
      ],
      'title' => 'ขั้นตอนการปฏิบัติ : ' . $progress['title']
    ]);
  }

  function Progresses($param, $gets) {
    return render([
      'template' => 'admin/progress',
      'params' => [
        'menus' => $this->menus_progress
      ],
      'title' => $this->title_admin
    ]);
  }

  function NewProgress($param, $gets) {
    return render([
      'template' => 'admin/progress_add',
      'params' => [
        'menus' => $this->menus_progress
      ],
      'title' => $this->title_admin
    ]);
  }

  function AddProgress($param, $gets) {
    $status = false;
    $message = '<strong>ล้มเหลว!</strong> ไม่สามารถเพิ่มใหม่ได้.';

    if(User::isAdmin()) {

      $fileName = '';
      if(!empty($_FILES['file']['name'])) {
        $fileName = getImageName($_FILES['file']['name']);
        if(uploadImage($_FILES['file']['tmp_name'], $fileName)) {

        }
      }

      $response = Progress::add([
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'department_id' => $_POST['department'],
        'file_path' => $fileName,
      ]);
      if($response > 0) {
        $count = 0;
        foreach ($_FILES['images']['name'] as $filename) {
          $name = getImageName($filename);
          if(uploadImage($_FILES['images']['tmp_name'][$count], $name)) {
            if(Image::add([
              'name' => $name,
              'progress_id' => $response
              ])) {
                $message = "<strong>สำเร็จ!</strong> <a href='/admin/progresses'>กลับไปหน้ารายการ</a>";
                $status = true;
              }
            } else {
              $message = "<strong>สำเร็จ!</strong> <a href='/admin/progresses'>กลับไปหน้ารายการ</a>";
              $status = true;
              break;
            }
            $count++;
          }
        } else {
          $message = "<strong>ล้มเหลว!</strong> มีบางอย่างผิดพลาด.";
          $status = false;
          break;
        }
      }

      return render([
        'template' => 'post/message',
        'params' => [
          'status' => $status,
          'message' => $message
        ],
        'title' => 'เพิ่มขั้นตอนปฏิบัติ'
      ]);
    }

    function EditProgress($param, $gets) {
      return render([
        'template' => 'admin/progress_edit',
        'params' => [
          'menus' => $this->menus_progress,
          'id' => $param['id']
        ],
        'title' => $this->title_admin
      ]);
    }

    function UpdateProgress($param, $gets) {
      $status = false;
      $message = '<strong>ล้มเหลว!</strong> ไม่สามารถแก้ไขได้.';


      $params = [
        'progress_id' => $param['id'],
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'department_id' => $_POST['department'],
      ];

      $fileName = '';
      if(!empty($_FILES['file']['name'])) {
        $fileName = getImageName($_FILES['file']['name']);
        if(uploadImage($_FILES['file']['tmp_name'], $fileName)) {
          $params = [
            'progress_id' => $param['id'],
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'department_id' => $_POST['department'],
            'file_path' => $fileName,
          ];
        }
      }

      if(User::isAdmin()) {
        if(Progress::update($params)) {
          $message = "<strong>สำเร็จ!</strong> <a href='/admin/progresses'>กลับไปหน้ารายการ</a>";
          $status = true;
          if( !(count($_FILES['images']['error']) == 1 && $_FILES['images']['error'][0] == 4) ) {
            Image::removeByProgress($param['id']);
            $count = 0;
            foreach ($_FILES['images']['name'] as $filename) {
              $name = getImageName($filename);
              if(uploadImage($_FILES['images']['tmp_name'][$count], $name)) {
                if(Image::add([
                  'name' => $name,
                  'progress_id' => $param['id']
                  ])) {
                    $message = "<strong>สำเร็จ!</strong> <a href='/admin/progresses'>กลับไปหน้ารายการ</a>";
                    $status = true;
                  }
                } else {
                  $message = "<strong>สำเร็จ!</strong> <a href='/admin/progresses'>กลับไปหน้ารายการ</a>";
                  $status = true;
                  break;
                }
                $count++;
              }
            }
          } else {
            $message = "<strong>ล้มเหลว!</strong> มีบางอย่างผิดพลาด.";
            $status = false;
          }
        }

        return render([
          'template' => 'post/message',
          'params' => [
            'status' => $status,
            'message' => $message
          ],
          'title' => 'แก้ไขขั้นตอนปฏิบัติ'
        ]);
      }

      function RemoveProgresses($param, $gets) {
        $status = false;
        $message = '<strong>ล้มเหลว!</strong> ไม่สามารถลบได้.';

        if(isset($_POST['id']) && User::isAdmin()) {
          foreach($_POST['id'] as $id) {
            if(Progress::remove($id)) {
              $message = "<strong>สำเร็จ!</strong> <a href='/admin/slides'>กลับไปหน้ารายการ</a>";
              $status = true;
            } else {
              $message = "<strong>ล้มเหลว!</strong> มีบางอย่างผิดพลาด.";
              $status = false;
              break;
            }
          }
        }

        return render([
          'template' => 'post/message',
          'params' => [
            'status' => $status,
            'message' => $message
          ],
          'title' => 'ลบขั้นตอนปฏิบัติ'
        ]);
      }

      function RemoveProgress($param, $gets) {
        $status = false;
        $message = '<strong>ล้มเหลว!</strong> ไม่สามารถลบได้.';

        if(isset($param['id']) && User::isAdmin()) {
          if(Progress::remove($param['id'])) {
            $message = "<strong>สำเร็จ!</strong> <a href='/admin/slides'>กลับไปหน้ารายการ</a>";
            $status = true;
          } else {
            $message = "<strong>ล้มเหลว!</strong> มีบางอย่างผิดพลาด.";
            $status = false;
            break;
          }
        }

        return render([
          'template' => 'post/message',
          'params' => [
            'status' => $status,
            'message' => $message
          ],
          'title' => 'ลบขั้นตอนปฏิบัติ'
        ]);
      }

    }
