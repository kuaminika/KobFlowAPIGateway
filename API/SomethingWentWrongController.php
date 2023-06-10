<?php 
 class SomethingWentWrongController
 {
    private $error;
    public function __construct($error)
    {
        $errorType = gettype($error);
      $this->error =[ "error_payload"=> $error, "error_title"=>"something went wrong", "message"=>"", "error_type"=>$errorType=="object"?get_class($error):$errorType];
    }


    
    public function processRequest()
    {
       if($this->error["error_type"]== "Exception") 
        $this->error["message"] =  $this->error["error_payload"]->getMessage();
       else 
       $this->error["message"] = $this->error["error_payload"];
      $this->response = ["status_code_header"=>"Internal Server Error",
      "body"=>json_encode($this->error)
      ];

      header($this->response['status_code_header']);
      echo $this->response['body'];

    }
 }
