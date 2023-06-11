<?php 

namespace Log_Utilities;

class EchoLogTool implements ILogTool
{
    public $active;

    public function __construct()
    {
        $this->active = false;        
    }
    
    public function toggleActivation($isActive)
    {
        $this->active = $isActive;
    }
    public function log($str)
    {
        echo $str."</br>";
    }
    public function logWithTab($str)
    {
        echo "&nbsp;&nbsp;".$str."</br>";

    }
    public function showObj($obj)
    {
        echo json_encode($obj)."</br>";

    }
    public function showVDump($obj)
    {
        
        echo "var_dump: </br>";
        var_dump($obj);
    }
}