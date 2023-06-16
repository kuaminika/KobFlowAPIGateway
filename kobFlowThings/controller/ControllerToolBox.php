<?php
namespace kobFlowThings\controller;
class ControllerToolBox
{
    public static function createNew( $createParams)
    {
       
        

        $createParams = isset( $createParams) ? $createParams : self::getBlankCreateParams();
        
        $configs = isset($createParams["configs"])? $createParams["configs"]:[];        
        $messageMap = new \K_Utilities\KMessageCodeMap((array) $configs->getConfig("messageMap"));
        $param = array(
            "messageMap" => $messageMap
           , "requestAction"  => isset($createParams["requestAction"]) ? $createParams["requestAction"]:"index"
           ,"requestParams"  => $createParams["requestParams"]
           ,"requestMethod"  => isset($createParams["requestMethod"]) ? $createParams["requestMethod"]:"GET"
           ,"otherConfigs"=> $configs->getConfig("otherConfigs")
       ); 

       $result = new ControllerToolBox($param);
       return $result;
    }

   
    public function __construct($param)
    {
        $this->messageMap = $param["messageMap"]; 
        $this->requestAction = $param["requestAction"];
        $this->requestParams = $param["requestParams"];
        $this->requestMethod = $param["requestMethod"];
        $this->otherConfigs = $param["otherConfigs"];
    }

    public function getOtherConfigs()
    {
        return  $this->otherConfigs;

    }
    public function getRequestParams()
    {
        return $this->requestParams;
    }

    public function getRequestAction()
    {
        return $this->requestAction;
    }
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    public function getMessageMap()
    {
        return $this->messageMap;
    }

}