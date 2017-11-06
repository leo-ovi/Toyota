<?php
class SlideForm {

  private $obj = [
    'id' => '',
    'title' => '',
    'description' => '',
    'image' => '',
    'create_date' => '',
  ];

  private $title;
  private $path;

  function __construct() {
    $this->title = "<i class='fa fa-plus-circle'></i> เพิ่มสไลด์";
    $this->path = "/admin/slides/new";
  }

  function setObj($obj) {
    $this->obj = $obj;
    $this->title = "<i class='fa fa-cog'></i> แก้ไขสไลด์";
    $this->path = "/admin/slides/edit/" + $obj['slide_id'];
  }

  function getSlideForm() {
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

  function getForm() {
    return <<< HTML
    <form method="POST" action="$this->path" enctype="multipart/form-data" onsubmit="return askConfirm()">
    <div class="form-group">
    <label for="forTitle">หัวเรื่อง</label>
    <input type="text" class="form-control" name="title" id="forTitle" placeholder="topic" value="{$this->obj['title']}">
    </div>
    <div class="form-group">
    <label for="forDescription">คำอธิบาย</label>
    <input type="text" class="form-control" name="description" id="forDescription" placeholder="description" value="{$this->obj['description']}">
    </div>
    <div class="form-group">
    <label for="forImage">รูปประกอบ</label>
    <input type="file" name="image"/>
    </div>
    <button type="submit" style="width: 150px" class="btn btn-default">ยืนยัน</button>
    <a href="" class="btn btn-danger">ยกเลิก</a>
    </form>
    <br><br>
HTML;
  }

}
