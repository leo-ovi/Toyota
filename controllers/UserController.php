<?php

class UserController {
  private $menus_member = [
    'title' => 'ตัวเลือกจัดการสมาชิก',
    'list' => [
      [
        'name' => 'ดูรายชื่อทั้งหมด',
        'url' => '/admin'
      ],
      [
        'name' => '<i class="fa fa-plus-circle"></i> เพิ่มสมาชิก',
        'url' => '/admin/members/new'
      ]
    ]
  ];

  function __construct() {
    if(!User::isAdmin() && strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
      header( "location: /404" );
      exit(0);
    }
  }


  function Members($param, $gets) {
    return render([
      'template' => 'admin/member',
      'params' => [
        'menus' => $this->menus_member
      ],
      'title' => 'จัดการระบบ: สมาชิก'
    ]);
  }

  function NewMember($param, $gets) {
    return render([
      'template' => 'admin/member_add',
      'params' => [
        'menus' => $this->menus_member
      ],
      'title' => 'จัดการระบบ: สมาชิก'
    ]);
  }

  function EditMember($param, $gets) {
    return render([
      'template' => 'admin/member_edit',
      'params' => [
        'menus' => $this->menus_member,
        'id' => $param['id']
      ],
      'title' => 'จัดการระบบ: สมาชิก'
    ]);
  }

  function UpdateMember($param, $gets) {
    $status = false;
    $message = '<strong>ล้มเหลว!</strong> ไม่สามารถเพิ่มใหม่ได้.';

    if(User::isAdmin()) {
      if(User::update([
        'id' => $param['id'],
        'fullname' => $_POST['fullname'],
        'position' => $_POST['position'],
        'no' => $_POST['no'],
        'department_id' => $_POST['department'],
        'username' => $_POST['username'],
        'password' => $_POST['password']
        ])) {
          $message = "<strong>สำเร็จ!</strong> <a href='/admin'>กลับไปหน้ารายการ</a>";
          $status = true;
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
        'title' => 'แก้ไขสมาชิก'
      ]);
    }

    function AddMember($param, $gets) {
      $status = false;
      $message = '<strong>ล้มเหลว!</strong> ไม่สามารถเพิ่มใหม่ได้.';

      if(User::isAdmin()) {
        if(User::add([
          'fullname' => $_POST['fullname'],
          'position' => $_POST['position'],
          'no' => $_POST['no'],
          'department_id' => $_POST['department'],
          'username' => $_POST['username'],
          'password' => $_POST['password']
          ])) {
            $message = "<strong>สำเร็จ!</strong> <a href='/admin'>กลับไปหน้ารายการ</a>";
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
          'title' => 'เพิ่มสมาชิก'
        ]);
      }

      function RemoveMembers($param, $gets) {
        $status = false;
        $message = '<strong>ล้มเหลว!</strong> ไม่สามารถลบได้.';

        if(isset($_POST['id']) && User::isAdmin() && User::size()['size'] != 1) {
          foreach($_POST['id'] as $id) {
            if(User::remove($id)) {
              $message = "<strong>สำเร็จ!</strong> <a href='/admin'>กลับไปหน้ารายการ</a>";
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
          'title' => 'ลบสมาชิก'
        ]);
      }

      function RemoveMember($param, $gets) {
        $status = false;
        $message = '<strong>ล้มเหลว!</strong> ไม่สามารถลบได้.';

        if(isset($param['id']) && User::isAdmin() && User::size()['size'] != 1) {
          if(User::remove($param['id'])) {
            $message = "<strong>สำเร็จ!</strong> <a href='/admin'>กลับไปหน้ารายการ</a>";
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
          'title' => 'ลบสมาชิก'
        ]);
      }

    }
