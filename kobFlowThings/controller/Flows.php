<?php 
namespace kobFlowThings\controller;
use K_Utilities\KCurlTool;

use K_Utilities\KException;
class FlowsController extends AController
{
    public function __construct(ControllerToolBox $toolbox)
    {
        parent::__construct($toolbox);
        //get_object_vars converts std obj to array
        $this->portBoard= get_object_vars($this->otherConfigs->portBoard);
     }

    public function getAll($params)
    {
        
        try
        {// should inject instead
            $curlTool = new KCurlTool();
            $sourceContext = $params["sourceContext"];
            $port = $this->portBoard[$sourceContext];

            $data = $curlTool->execute("http://localhost:$port/$sourceContext");//
      // $data =  $curlTool->execute("https://baconipsum.com/api/?type=meat-and-filler");
        $this->response['body']=$data;
        }
        catch(\Exception $ex)
        {
            throw KException::createWithException($ex,"KobFlowsController.getAll");

        }
    }
    
  
}