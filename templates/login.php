<?php include PATH_PARTIAL . '/header.php'; ?>

<div class="container marginTop">
  <form class="form-horizontal col-md-6 col-md-offset-3" method="post" action="/login">
    <fieldset>
      <h3 class="text-center">เข้าสู่ระบบ</h3>
      <hr>
      <div class="form-group">
        <label for="inputEmail" class="col-lg-2 control-label">ยูเซอร์เนม</label>
        <div class="col-lg-10">
          <input type="text" class="form-control" id="inputEmail" name="username" placeholder="Username">
        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword" class="col-lg-2 control-label">รหัสผ่าน</label>
        <div class="col-lg-10">
          <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
          <!-- <div class="checkbox">
            <label>
              <input type="checkbox"> Checkbox
            </label>
          </div> -->
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
          <button type="reset" class="btn btn-default">ยกเลิก</button>
          <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
        </div>
      </div>
    </fieldset>
  </form>
</div>

<?php include PATH_PARTIAL . '/footer.php'; ?>
