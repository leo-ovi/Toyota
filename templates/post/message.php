<?php include PATH_PARTIAL . '/header.php'; ?>

<div class="container marginTop">
  <?php if($params['status']): ?>
  <div class="alert alert-success" role="alert">
    <?=$params['message']?>
  </div>
  <?php else: ?>
  <div class="alert alert-danger" role="alert">
    <?=$params['message']?>
  </div>
  <?php endif; ?>
</div>

<?php include PATH_PARTIAL . '/footer.php'; ?>
