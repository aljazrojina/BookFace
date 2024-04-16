<?php
  class Pages extends Controller {
    private $postModel;
    public function __construct(){
    }
    
    public function index(){

      if(isLoggedIn()){
        redirect('posts');
      }

      $data = [
        'title' => 'BookFace',
        'description' => 'Enostavno socialno omrežje zgrajeno na MVC PHP Framework'
      ];

      $this->view('pages/index', $data);
    }

    public function about(){
      $data = [
        'title' => 'O Nas',
        'description' => 'Aplikacija za deljenje objav z drugimi uporabniki'
      ];

      $this->view('pages/about', $data);
    }
    
  }