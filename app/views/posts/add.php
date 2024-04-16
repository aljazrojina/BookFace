
<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Nazaj</a>
     <div class="card card-body bg-light mt-5">
          <h2>Dodaj objavo</h2>
          <form action="<?php echo URLROOT; ?>/posts/add" method='post' enctype="multipart/form-data">
          <div class="form-group">
               <label for="title">Naslov: <sup>*</sup></label>
               <input type="text" name="title" class="form-control form-control-lg 
               <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
               <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
          </div>
          <div class="form-group">
               <label for="body">Objava: <sup>*</sup></label>
               <textarea name="body" class="form-control form-control-lg 
               <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data ['body']; ?>
               </textarea>
               <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
          </div>
          <div class="form-group">
               <label for="image_path">Izberi sliko:</label>
               <input type="file" name="image_path"  class="form-control-file">
          </div>
          
          <input type="submit" class="btn btn-success"value="Submit">
     </form>
     </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
