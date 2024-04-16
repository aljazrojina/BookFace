<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Nazaj</a>
<br>
<h1><?php echo $data['post']->title; ?></h1>
     <div class="bg-secondary text-white p-2 mb-3">
          Written by: <?php echo $data['post']->author; ?> on <?php echo $data['post']->created_at; ?>
     </div>
     <p>
          <?php echo $data['post']->body; ?>
</p>
<p>
<?php if (!empty($data['post']->image_path)) : ?>
                    <img src="<?php echo URLROOT . '/public/img/' . $data['post']->image_path; ?>" class="img-fluid mb-2" alt="Post Image" width="300" height="200">
               <?php endif; ?>
</p>
     <?php if($data['post']->user_id == $_SESSION['user_id'] || $_SESSION['user_role'] == 'admin') : ?>
          <hr>
          <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Uredi</a>
          <form class="float-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="POST">
          <input type="submit" value="Zbriši" class="btn btn-danger">
          </form>
          <?php endif;?>
     

<?php require APPROOT . '/views/inc/footer.php'; ?>