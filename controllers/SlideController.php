<?php

class SlideController {

  private $menus_slide = [
    'title' => 'ตัวเลือกจัดการสไลด์',
    'list' => [
      [
        'name' => 'ดูสไลด์ทั้งหมด',
        'url' => '/admin/slides'
      ],
      [
        'name' => '<i class="fa fa-plus-circle"></i> เพิ่มสไลด์',
        'url' => '/admin/slides/new'
      ]
    ]
  ];

  function __construct() {
    if(!User::isAdmin() && strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
      header( "location: /404" );
      exit(0);
    }
  }

  function Slides($param, $gets) {
    return render([
      'template' => 'admin/slide',
      'params' => [
        'menus' => $this->menus_slide
      ],
      'title' => 'จัดการระบบ: สไลด์'
    ]);
  }

  function NewSlide($param, $gets) {
    return render([
      'template' => 'admin/slide_add',
      'params' => [
        'menus' => $this->menus_slide
      ],
      'title' => 'จัดการระบบ: สไลด์'
    ]);
  }

  function AddSlide($param, $gets) {
    $status = false;
    $message = '<strong>ล้มเหลว!</strong> ไม่สามารถเพิ่มใหม่ได้.';

    if(User::isAdmin()) {
      $name = getImageName($_FILES['image']['name']);
      if(uploadImage($_FILES['image']['tmp_name'], $name)) {
        if(Slide::add([
          'title' => $_POST['title'],
          'description' => $_POST['description'],
          'image' => $name,
          ])) {
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
        'title' => 'เพิ่มสไลด์'
      ]);
    }

    function EditSlide($param, $gets) {
      return render([
        'template' => 'admin/slide_edit',
        'params' => [
          'menus' => $this->menus_slide,
          'id' => $param['id']
        ],
        'title' => 'จัดการระบบ: สไลด์'
      ]);
    }

    function UpdateSlide($param, $gets) {
      $status = false;
      $message = '<strong>ล้มเหลว!</strong> ไม่สามารถแก้ไขได้.';

      if(User::isAdmin()) {
        $image = '';
        if($_FILES['image']['error'] != 4) {
          $name = getImageName($_FILES['image']['name']);
          $image = (uploadImage($_FILES['image']['tmp_name'], $name)) ? $name: '';
        }
        if(Slide::update([
          'slide_id' => $param['id'],
          'title' => $_POST['title'],
          'description' => $_POST['description'],
          'image' => $image,
          ])) {
            $message = "<strong>สำเร็จ!</strong> <a href='/admin/slides'>กลับไปหน้ารายการ</a>";
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
          'title' => 'แก้ไขสไลด์'
        ]);
      }

      function RemoveSlides($param, $gets) {
        $status = false;
        $message = '<strong>ล้มเหลว!</strong> ไม่สามารถลบได้.';

        if(isset($_POST['id']) && User::isAdmin()) {
          foreach($_POST['id'] as $id) {
            if(Slide::remove($id)) {
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
          'title' => 'ลบสไลด์'
        ]);
      }

      function RemoveSlide($param, $gets) {
        $status = false;
        $message = '<strong>ล้มเหลว!</strong> ไม่สามารถลบได้.';

        if(isset($param['id']) && User::isAdmin()) {
          if(Slide::remove($param['id'])) {
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
          'title' => 'ลบสไลด์'
        ]);
      }

    }
