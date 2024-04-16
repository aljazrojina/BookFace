<?php
     class Users extends Controller{
          private $userModel;
          public function __construct(){
              $this->userModel = $this->model('User');
          }
          public function register(){
               //PREVERI ZA POST SUPERGLOBALNO SPREMENLJIVKO
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    // PROCESIRAMO FORM

                    // Sanatize Post data
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $data = [
                         'name' => trim($_POST['name']),
                         'email' => trim($_POST['email']),
                         'password' => trim($_POST['password']),
                         'confirm_password' => trim($_POST['confirm_password']),
                         'name_err' => '',
                         'email_err' => '',
                         'password_err' => '',
                         'confirm_password_err' => ''
                    ];

                    // POTRDIMO MAIL
                    if(empty($data['email'])){
                         $data['email_err'] = 'Prosim vnesite mail!';
                    } else {
                         // PREVERIMO MAIL ČE OBSTAJA
                         if($this->userModel->findUserByEmail($data['email'])){
                              $data['email_err'] = 'Mail je že v uporabi!';
                         }
                    }

                    // POTRDIMO IME
                    if(empty($data['name'])){
                         $data['name_err'] = 'Prosim vnesite ime!';
                    }

                    // POTRDIMO GESLO
                    if(empty($data['password'])){
                         $data['password_err'] = 'Prosim vnesite geslo!';
                    } elseif(strlen($data['password']) < 6){
                         $data['password_err'] = 'Geslo mora biti dolgo vsaj 6 znakov!';
                    }

                    // PODTRITEV PREVERJANJE GESLA
                    if(empty($data['confirm_password'])){
                         $data['confirm_password_err'] = 'Prosim potrdite geslo!';
                         
                    } else {
                         $password = trim($data['password']);
                         $confirmPassword = trim($data['confirm_password']);
                     
                         if ($password !== $confirmPassword) {
                             $data['confirm_password_err'] = 'Gesli se ne ujemata!';
                         }
                    }

                    // POSKRBIMO DA NI NAPAK
                    if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                         
                         // HASH GESLO
                         $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                         // REGISTRIRAMO UPORABNIKA ČE NI NAPAK
                         if($this->userModel->register($data)){
                              flash('register_success', 'Ste registrirani in se lahko prijavite!');
                              redirect('users/login');
                         } else {
                              die('Something went wrong!');
                         }

                    } else {
                         //NALOŽIMO POGLED REGISTER Z NAPAKAMI
                         $this->view('users/register', $data);
                    }

                    
               } else{
                    $data = [
                         'name' => '',
                         'email' => '',
                         'password' => '',
                         'confirm_password' => '',
                         'name_err' => '',
                         'email_err' => '',
                         'password_err' => '',
                         'confirm_password_err' => ''
                    ];

                    // NALOŽIMO POGLED
                    $this->view('users/register', $data);
               }
          }

          // FUNKCIJA LOGIN
          public function login(){
               //PREVERIMO ZA POST SUPERGLOBALNO SPREMENLJIVKO
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    // PROCESIRAMO FORM
                    // Sanatize Post data
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $data = [
                         'email' => trim($_POST['email']),
                         'password' => trim($_POST['password']),
                         'email_err' => '',
                         'password_err' => ''
                         
                    ];

                    // POTRDITEV MAILA
                    if(empty($data['email'])){
                         $data['email_err'] = 'Prosim vnesite mail!';
                    } 

                    // POTRDITEV GESLA
                    if(empty($data['password'])){
                         $data['password_err'] = 'Prosim vnesite geslo!';
                    } elseif(strlen($data['password']) < 6){
                         $data['password_err'] = 'Geslo mora biti dolgo vsaj 6 znakov!';
                    }

                    // PREVERI UPORABNIKA/MAIL
                    if($this->userModel->findUserByEmail($data['email'])){
                         //NAJDEMO UPORABNIKA
                    } else {
                         //NE NAJDE UPORABNIKA
                         $data['email_err'] = 'Ni uporabnika z tem email naslovom';
                    }

                    // POSKRBIMO DA SO NAPAKE PRAZNE
                    if(empty($data['email_err']) && empty($data['password_err'])){
                         // Preveri in vpisši uporabnika
                         $loggedInUser = $this->userModel->login($data['email'],$data['password']);

                         if($loggedInUser){
                              //Ustvari SESSION
                              $this->createUserSession($loggedInUser);
                         } else {
                              $data['password_err'] = 'Nepravilno geslo';
                              $this->view('users/login', $data);
                         }

                    } else {
                         // NALOŽIMO POGLED Z NAPAKAMI
                         $this->view('users/login', $data);
                    }
               } else{
                    $data = [
                         'email' => '',
                         'password' => '',
                         'email_err' => '',
                         'password_err' => ''
                    ];

                    // NALOŽIMO POGLED
                    $this->view('users/login', $data);
               }
          }

          public function createUserSession($user){
               $_SESSION['user_id'] = $user->id;
               $_SESSION['user_email'] = $user->email;
               $_SESSION['user_name'] = $user->name;
               $_SESSION['user_role'] = $user->role;
               redirect('posts');
          }

          public function logout(){
               unset($_SESSION['user_id']);
               unset($_SESSION['user_name']);
               unset($_SESSION['user_email']);
               session_destroy();
               redirect('users/login');
          }

          public function account(){

               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    // PROCESIRAMO FORM

                    // Sanatize Post data
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $data = [
                         'password' => trim($_POST['password']),
                         'confirm_password' => trim($_POST['confirm_password']),
                         'password_err' => '',
                         'confirm_password_err' => ''
                    ];

                    // POTRDIMO GESLO
                    if(empty($data['password'])){
                         $data['password_err'] = 'Prosim vnesite geslo!';
                    } elseif(strlen($data['password']) < 6){
                         $data['password_err'] = 'Geslo mora biti dolgo vsaj 6 znakov!';
                    }

                    // PODTRITEV PREVERJANJE GESLA
                    if(empty($data['confirm_password'])){
                         $data['confirm_password_err'] = 'Prosim potrdite geslo!';
                         
                    } else {
                         $password = trim($data['password']);
                         $confirmPassword = trim($data['confirm_password']);
                     
                         if ($password !== $confirmPassword) {
                             $data['confirm_password_err'] = 'Gesli se ne ujemata!';
                         }
                    }

                    // POSKRBIMO DA NI NAPAK
                    if(empty($data['password_err']) && empty($data['confirm_password_err'])){
                         
                         // HASH GESLO
                         $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                         // TESTING

                         
                         // REGISTRIRAMO UPORABNIKA ČE NI NAPAK
                         if($this->userModel->changePassword($_SESSION['user_email'], $data['password'])){
                              echo 'bravo';
                              flash('changePass_success', 'Geslo Popravljeno!');
                              redirect('users/account');
                         } else {
                              die('Something went wrong!');
                         }

                    } else {
                         //NALOŽIMO POGLED REGISTER Z NAPAKAMI
                         $this->view('users/account', $data);
                    }

                    
               } else{
                    $data = [
                         'email' => '',
                         'password' => '',
                         'confirm_password' => '',
                         'email_err' => '',
                         'password_err' => '',
                         'confirm_password_err' => ''
                    ];

                    // NALOŽIMO POGLED
                    $this->view('users/account', $data);
               }
          }
     }
