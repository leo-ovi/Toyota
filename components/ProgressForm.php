<?php
class ProgressForm {

  private $obj = [
    'id' => '',
    'title' => '',
    'content' => '',
    'department_id' => ''
  ];

  private $title;
  private $path;

  function __construct() {
    $this->title = "<i class='fa fa-plus-circle'></i> เพิ่มขั้นตอนปฏิบัติ";
    $this->path = "/admin/progresses/new";
  }

  function setObj($obj) {
    $this->obj = $obj;
    $this->title = "<i class='fa fa-cog'></i> แก้ไขขั้นตอนปฏิบัติ";
    $this->path = "/admin/progresses/edit/" + $obj['id'];
  }

  function getProgressForm() {
    return $this->getHeader().$this->getForm();
  }

  function getHeader() {
    return "
    <div>
    <h4>
    <strong>$this->title</strong>
    </h4>
    <hr>
    </div>
    ";
  }

  function getSelection() {
    return '
    <select class="selection" name="department">
    <option value="-1">เลือกแผนก</option>
    '.$this->getDepartmentList().'
    </select>';
  }

  // function getDepartmentList() {
  //   $list = '';
  //   foreach (Department::getList() as $department) {
  //     $selected = ($department['department_id'] == $this->obj['department_id']) ? 'selected': '';
  //     $list .= "<option value='".$department['department_id']."' $selected>".$department['name']."</option>";
  //   }
  //   return $list;
  // }

  function getDepartmentList() {
    $list = '';
    foreach (Department::getList() as $department) {
      if($department['sub'] == 0) {
        $list .= '<optgroup label="'.$department['name'].'">';
        foreach (Department::getSub($department['department_id']) as $sub) {
          $list .= "<option value='".$sub['department_id']."'>".$sub['department_name']."</option>";
        }
        $list .= '</optgroup>';
      }
    }
    return $list;
  }

  function getForm() {
    return <<< HTML
    <form method="POST" action="$this->path" enctype="multipart/form-data" onsubmit="return askConfirm()">
    <div class="form-group">
    <label for="forTitle">หัวเรื่อง</label>
    <input type="text" class="form-control" name="title" id="forTitle" placeholder="title" value="{$this->obj['title']}">
    </div>
    <div class="form-group">
    <label for="forContent">คำอธิบาย</label>
    <textarea name="content" id="forContent" class="form-control">{$this->obj['content']}</textarea>
    </div>
    <div class="form-group">
    <label for="forSelection">แผนก</label>
    {$this->getSelection()}
    </div>
    <hr/>
    <div class="form-group">
    <label for="forImage">รูปประกอบ</label>
    <input type="file" name="images[]" multiple/>
    </div>
    <div class="form-group">
    <label for="forFile">ไฟล์แนบ</label>
    <input type="file" name="file"/>
    </div>
    <button type="submit" style="width: 150px" class="btn btn-default">ยืนยัน</button>
    <a href="" class="btn btn-danger">ยกเลิก</a>
    </form>
    <br><br>
HTML;
  }

}
