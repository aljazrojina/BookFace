<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class = "text-center">
    <h1><?php echo $data['title']; ?></h1>
    <p><?php echo $data['description']; ?></p>
    <p>Verzija: <strong><?php echo APPVERSION; ?></strong></p>
    <p>Ustvaril: <?php echo CREATOR;?></p>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>