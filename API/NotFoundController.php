<?php 
 class NotFoundController
 {
    private $error;
    public function __construct( $controllerName)
    {
      
        $this->error =[ 
         "error_payload"=> $controllerName,
         "error_title"=>"Something is not found", 
         "message"=>"context '$controllerName' is not found ", 
         "error_type"=>"none"];

         if(empty($controllerName))
         $this->error["message"] = "context is not provided";
    }


    
    public function processRequest()
    {
     
      $this->response = [
        "status_code_header"=>"HTTP/1.1 404  Not Found",
        "body"=>json_encode($this->error)
      ];

      header($this->response['status_code_header']);
      echo $this->response['body'];

    }
 }
