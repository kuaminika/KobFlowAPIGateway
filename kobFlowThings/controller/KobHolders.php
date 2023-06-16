<?php 
namespace kobFlowThings\controller;
use K_Utilities\KCurlTool;

use K_Utilities\KException;
class KobHoldersController extends AController
{

    public function getAll()
    {
        
        try
        {// should inject instead
        $curlTool = new KCurlTool();
       $data =  $curlTool->execute("http://localhost:5002/KobHolder");//
      // $data =  $curlTool->execute("https://baconipsum.com/api/?type=meat-and-filler");
        $this->response['body']=$data;
        }
        catch(\Exception $ex)
        {
            throw KException::createWithException($ex,"KobHoldersController.getAll");

        }
    }
    
  
}