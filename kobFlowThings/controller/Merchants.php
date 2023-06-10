<?php 
namespace kobFlowThings\controller;
use K_Utilities\KCurlTool;

use K_Utilities\KException;
class MerchantsController extends AController
{

    public function getAll()
    {
        
        try
        {// should inject instead
        $curlTool = new KCurlTool();
       $data =  $curlTool->execute("https://localhost:5001/Merchant");//("https://baconipsum.com/api/?type=meat-and-filler");
        $this->response['body']=$data;
        }
        catch(\Exception $ex)
        {
            throw KException::createWithException($ex,"MerchantsController.getAll");

        }
    }
    
  
}