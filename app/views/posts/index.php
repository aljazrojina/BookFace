<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('post_message'); ?>
<div class="container clearfix">
     <div class="row mb-3">
     <div class="col-md-6">
          <h1>Objave</h1>
     </div>
     <div class="col-md-6">
          <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary float-right">
          <i class="fa fa-pencil"></i> Dodaj objavo
          </a>
     </div>
     </div>

     <?php foreach($data['posts'] as $post) : ?>
          <div class="card card-body mb-3">
               <h4 class="card-title"><?php echo $post->title; ?></h4>
               <div class="bg-light p-2 mb-3">
                    Napisal: <?php echo $post->name; ?> on <?php echo $post->postCreated; ?>
               </div>
               <p class="card-text"><?php echo $post->body; ?></p>
               <p>
               <?php if (!empty($post->image_path)) : ?>
                    <img src="<?php echo URLROOT . '/public/img/' . $post->image_path; ?>" class="img-fluid mb-2" alt="Post Image" width="300" height="200">
               <?php endif; ?>
               </p>
               <p class="btn btn-block">
               <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-dark float-center">Več</a>
               </p>      
          </div>
     <?php endforeach; ?>
     </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>