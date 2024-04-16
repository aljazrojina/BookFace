<?php require APPROOT . '/views/inc/header.php'; ?>
     <div class="col-md-6 mx-auto">
               <div class="card card-body bg-light mt-5">
                    <?php flash('changePass_success'); ?>
                    <h2><?php echo $_SESSION['user_name'];?></h2>
                    <form action="<?php echo URLROOT; ?>/users/account" method='post'>
                    <div>
                         <p>Email: <?php echo $_SESSION['user_email'];?></p>
                    </div>
                    <div>
                         <p>Spremeni Geslo:</p>
                    </div>
                    <div class="form-group">
                         <label for="Password">Password: <sup>*</sup></label>
                         <input type="password" name="password" class="form-control form-control-lg 
                         <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                         <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>
                    <div class="form-group">
                         <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                         <input type="password" name="confirm_password"  class="form-control form-control-lg 
                         <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
                         <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                    </div>
                    <div class="row">
                         <div class="col">
                              <input type="submit" value="Shrani" class="btn btn-success btn-block">
                         </div>
                    </div>
               </form>
               </div>
          </div>
     </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>