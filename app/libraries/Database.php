<?php
     /*
     * PDO Database Class
     * Connect to DB
     * Create prepared statements
     * Bind Values
     * Return rows and results
     */

     class Database {
          private $host = DB_HOST;
          private $user = DB_USER;
          private $pass = DB_PASS;
          private $dbname = DB_NAME;

          //DB handler
          private $dbh;
          //DB statement
          private $stmt;
          //DB Error
          private $error;

          public function __construct()
          {
               $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
               $options = array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
               );
               // PDO instance
               try{
                    $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);

               } catch(PDOException $e){
                    $this->error = $e->getMessage();
                    echo $this->error;
               }
          }

          // prepare statement with query

          public function query($sql){
               $this->stmt = $this->dbh->prepare($sql);
          }

          //  Bind vvalues
          public function bind($param, $value, $type = NULL){
               if(is_null($type)){
                    switch(true){
                         case is_int($value):
                              $type = PDO::PARAM_INT;
                              break;
                         case is_bool($value):
                              $type = PDO::PARAM_BOOL;
                              break;
                         case is_null($value):
                              $type = PDO::PARAM_NULL;
                              break;
                         default:
                              $type = PDO::PARAM_STR;
                         }
               }

               $this->stmt->bindValue($param,$value,$type);
               
          }

          // Execute funtion

          public function execute(){
               return $this->stmt->execute();
          }

          // Get results set as array of obj
          public function resultSet(){
               $this->execute();
               return $this->stmt->fetchAll(PDO::FETCH_OBJ);
          }

          //get result of a single record
          public function single(){
               $this->execute();
               return $this->stmt->fetch(PDO::FETCH_OBJ);
          }

          // GEt row count
          public function rowCount(){
               return $this->stmt->rowCount();
          }
     }
     

