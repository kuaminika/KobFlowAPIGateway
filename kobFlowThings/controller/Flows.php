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

            $data = $curlTool->execute("http://localhost:$port/$sourceContext");
            $this->response['body']=$data;
        }
        catch(\Exception $ex)
        {
            throw KException::createWithException($ex,"KobFlowsController.getAll");

        }
    }
    
    //POST
    public function update($params)
    {

        try
        {// should inject instead
            
            $params = $params["jsonValue"];
            if(!property_exists($params,"payLoad")) {    $this->handleError("payLoad is missing");}
         
            $content = $params->payLoad;//["payLoad"];
            $curlTool = new KCurlTool();
            if(!property_exists($params,"sourceContext"))     $this->handleError("payLoad is missing");
            $sourceContext = $params->sourceContext;//["sourceContext"];


            $port = $this->portBoard[$sourceContext];
            $data = get_object_vars($content);
           $data = $curlTool->executePost("http://localhost:$port/$sourceContext/Update",$data);
            $this->response['body']=$data;
        }
        catch(Exception $ex)
        {
            echo "its caught";
        //   throw KException::createWithException($ex,"KobFlowsController.getAll");

        }
    }
    
    //POST
    public function delete($params)
    {

        try
        {// should inject instead
            
            $params = $params["jsonValue"];
            if(!property_exists($params,"payLoad")) {    $this->handleError("payLoad is missing");}
         
            $content = $params->payLoad;//["payLoad"];
            $curlTool = new KCurlTool();
            if(!property_exists($params,"sourceContext"))     $this->handleError("payLoad is missing");
            $sourceContext = $params->sourceContext;//["sourceContext"];


            $port = $this->portBoard[$sourceContext];
            $data = get_object_vars($content);
           $data = $curlTool->executePost("http://localhost:$port/$sourceContext/Delete",$data);
            $this->response['body']=$data;
        }
        catch(Exception $ex)
        {
            echo "its caught";
        //   throw KException::createWithException($ex,"KobFlowsController.getAll");

        }
    }
    //POST
    public function add($params)
    {

        try
        {// should inject instead
            
            $params = $params["jsonValue"];
            if(!property_exists($params,"payLoad")) {    $this->handleError("payLoad is missing");}
         
            $content = $params->payLoad;//["payLoad"];
            $curlTool = new KCurlTool();
            if(!property_exists($params,"sourceContext"))     $this->handleError("payLoad is missing");
            $sourceContext = $params->sourceContext;//["sourceContext"];


            $port = $this->portBoard[$sourceContext];
            $data = get_object_vars($content);
           $data = $curlTool->executePost("http://localhost:$port/$sourceContext/Add",$data);
            $this->response['body']=$data;
        }
        catch(Exception $ex)
        {
            echo "its caught";
        //   throw KException::createWithException($ex,"KobFlowsController.getAll");

        }
    }


    public function whatISent($content)
    {
        
        try
        {
            
            $this->response['status_code_header'] = 'HTTP/1.1 200 OK';
            $this->response['body'] = json_encode($content["jsonValue"]);
                }
        catch(\Exception $ex)
        {
            throw KException::createWithException($ex,"KobFlowsController.getAll");

        }
    }
  
}