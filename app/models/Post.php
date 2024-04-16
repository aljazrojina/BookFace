<?php
     class Post {
          private $db;

          public function __construct(){
               $this->db = new Database;
          }

          public function getPosts(){
               $this->db->query(
                    'SELECT *,
               posts.id AS postId,
               users.id AS userId,
               posts.created_at AS postCreated,
               users.created_at AS userCreated
               FROM posts
               INNER JOIN users
               WHERE posts.user_id = users.id
               ORDER BY posts.created_at DESC'
               );
               $this->db->execute();
               $results = $this->db->resultSet();

               return $results;
          }

          public function addPost($data) {
               try {
                   if (!empty($data['image_path'])) {
                       $this->db->query('INSERT INTO posts (title, user_id, body, image_path) VALUES (:title, :user_id, :body, :image_path)');
                       // Bind values
                       $this->db->bind(':title', $data['title']);
                       $this->db->bind(':user_id', $data['user_id']);
                       $this->db->bind(':body', $data['body']);
                       $this->db->bind(':image_path', $data['image_path']);
                   } else {
                       $this->db->query('INSERT INTO posts (title, user_id, body) VALUES (:title, :user_id, :body)');
                       // Bind values
                       $this->db->bind(':title', $data['title']);
                       $this->db->bind(':user_id', $data['user_id']);
                       $this->db->bind(':body', $data['body']);
                   }
           
                   // Execute
                   if ($this->db->execute()) {
                       return true;
                   } else {
                       throw new Exception('Error executing database query.');
                   }
               } catch (Exception $e) {
                   // Handle exceptions
                   error_log('Error in addPost method: ' . $e->getMessage()); // Log the error
                   var_dump($e->getMessage());
                   return false; // Return false to indicate failure
               }
           }

          public function updatePost($data){
               // var_dump($data);

               
               if(!empty($data['image_path'])){

                    $this->db->query('UPDATE posts SET title = :title, body = :body, image_path = :image_path WHERE id = :id');
                    $this->db->bind(':id', $data['id']);
                    $this->db->bind(':title', $data['title']);
                    $this->db->bind(':body', $data['body']);
                    $this->db->bind(':image_path', $data['image_path']);
               } else {

                    $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
                    $this->db->bind(':id', $data['id']);
                    $this->db->bind(':title', $data['title']);
                    $this->db->bind(':body', $data['body']);
               }
               
               // execute
               if($this->db->execute()){
                    return true;
               } else {
                    return false;
               }
          }

          public function getPostById($id){
               $this->db->query('SELECT 
               p.id AS id,
               u.id as user_id,
               u.name as author,
               p.title,
               p.body,
               p.image_path,
               p.created_at
               FROM `posts` p
               LEFT JOIN `users` u ON p.user_id = u.id
               WHERE p.id= :id');
               $this->db->bind(':id', $id);
               
               $row = $this->db->single();

               return $row;
          }

          public function deletePost($id){
               $this->db->query('DELETE FROM posts WHERE id = :id');
               // bind values
               $this->db->bind(':id', $id);
               
               // execute
               if($this->db->execute()){
                    return true;
               } else {
                    return false;
               }
          }
     }