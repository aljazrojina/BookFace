<?php
     class Posts extends Controller {
          private $postModel;
          private $userModel;
          public function __construct(){

               if(!isLoggedIn()){
                    redirect('users/login');
               }

               $this->postModel = $this->model('Post');
               $this->userModel = $this->model('Post');
          }
          
          public function index(){

               // Get Posts
               $posts = $this->postModel->getPosts();
               $data = [
                    'posts' => $posts
               ]; 
               $this->view('posts/index', $data);
          }

          public function add() {
               if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                   // Sanitize input
                   $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
               //     var_dump($_FILES);
               //     var_dump($_POST);
                   
                   // Get file path
                   $image_path = $_FILES['image_path']['tmp_name'];
                   
                   $data = [
                       'title' => trim($_POST['title']),
                       'body' => trim($_POST['body']),
                       'user_id' => $_SESSION['user_id'],
                       'image_path' => '',
                       'title_err' => '',
                       'body_err' => ''
                   ];
                   
                   // Validate title
                   if (empty($data['title'])) {
                       $data['title_err'] = 'Please enter a title';
                   }
                   
                   // Validate body
                   if (empty($data['body'])) {
                       $data['body_err'] = 'Please enter text';
                   }
                   
                   // Handle file upload
                   if (isset($_FILES['image_path'])) {
                       $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/bookface/public/img/'; // Directory to store uploaded files
                       $uploadFile = $uploadDir . basename($_FILES['image_path']['name']); // Full path to the uploaded file
                       $endFile = basename($_FILES['image_path']['name']);
                    //    echo '<br>';
                    //    echo $image_path;
                    //    echo '<br>';
                    //    echo $uploadFile;
                    //    echo '<br>';
                       
                       // Move the uploaded file to the specified directory
                       if (move_uploaded_file($image_path, $uploadFile)) {
                           // File uploaded successfully
                           echo "File is valid, and was successfully uploaded.\n";
                           $data['image_path'] = $endFile;
                       } else {
                           // Error uploading file
                           $error = error_get_last();
                           var_dump($error);
                       }
                   }
                   
                   // Check for errors
                   if (empty($data['title_err']) && empty($data['body_err'])) {
                       // Success
                       
                       if ($this->postModel->addPost($data)) {
                           flash('post_message', 'Objavljeno');
                           redirect('posts');
                       } else {
                           die('Nekaj je šlo narobe!');
                       }
                   } else {
                       // Load view with errors

                       $this->view('posts/add', $data);
                   }
               } else {
                   // Display form
                   $data = [
                       'title' => '',
                       'body' => '',
                       'image_path' => ''
                   ];
                   $this->view('posts/add', $data);
               }
           }
           
          public function edit($id){
               // var_dump($id);
               // var_dump($_SERVER);
               // die('neki');

               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    // die('neki tuki napis');
                    // Saniraj

                    var_dump($_SESSION);
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $image_path = $_FILES['image_path']['tmp_name'];
                    

                    $data = [
                         'id' => $id,
                         'title' => trim($_POST['title']),
                         'body' => trim($_POST['body']),
                         'user_id' => $_SESSION['user_id'],
                         'image_path' => $image_path,
                         'title_err' => '',
                         'body_err' => ''
                    ];

                    // Validiraj naslov
                    if(empty($data['title'])){
                         $data['title_err'] = 'Prosim vnesite naslov';
                    }
                    // in tekst

                    if(empty($data['body'])){
                         $data['body_err'] = 'Prosim vnesite tekst';
                    }

                    //preglej napake

                    // Handle file upload
                    if (isset($_FILES['image_path'])) {
                         $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/bookface/public/img/'; // Directory to store uploaded files
                         $uploadFile = $uploadDir . basename($_FILES['image_path']['name']); // Full path to the uploaded file
                         $endFile = basename($_FILES['image_path']['name']);
                    //    echo '<br>';
                    //    echo $image_path;
                    //    echo '<br>';
                    //    echo $uploadFile;
                    //    echo '<br>';
                         
                         // Move the uploaded file to the specified directory
                         if (move_uploaded_file($image_path, $uploadFile)) {
                         // File uploaded successfully
                         echo "File is valid, and was successfully uploaded.\n";
                         $data['image_path'] = $endFile;
                         } else {
                         // Error uploading file
                         $error = error_get_last();
                         var_dump($error);
                         }
                    }  else {
                         $data['image_path'] = '';
                    }    

                    if(empty($data['title_err']) && empty($data['body_err'])){
                         // potrjeno
                         if($this->postModel->updatePost($data)){
                              flash('post_message', 'Popravljeno!');
                              redirect('posts');
                              
                         } else {
                              die('Nekaj je šlo narobe!');
                         }

                    } else {
                         // naloži pogled z napakmi
                         $this->view('posts/edit', $data);
                    }
                    
               } else {

                    //get existing post model
                    $post = $this->postModel->getPostById($id);
                    //check for owner

                    if($post->user_id != $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin'){
                         redirect('posts');
                    }

                    $data = [
                         'id' => $id,
                         'title' => $post->title,
                         'body' => $post->body
                    ]; 

                    $this->view('posts/edit', $data);
               }
          }

          public function show($id){
               $post = $this->postModel->getPostById($id);
               // $user = $this->userModel->getUserById($post->user_id);
               $data = [
                    'post' => $post,
                    //'user_id' => $user
               ];
               $this->view('posts/show', $data);
          }



          public function delete($id){
               
               if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $post = $this->postModel->getPostById($id);

               // var_dump($id);                    var_dump($post);
                    // var_dump($_SESSION['user_id']);
                    // die;
                    if($post->user_id != $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin'){
                         redirect('posts');
                    }

                    // var_dump($_SERVER);die;

                    if($post->user_id == $_SESSION['user_id'] || $_SESSION['user_role'] == 'admin')
                    {
                         if($this->postModel->deletePost($id)){
                              flash('post_message', 'Objava odstranjena');
                              redirect('posts');
                         } else {
                              die('Nekaj je šlo narobe!');
                         }
                    }
               } else {
                    redirect('posts');
               }
          }
     }