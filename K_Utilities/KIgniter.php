<?php

namespace K_Utilities;
require_once dirname(__FILE__)."/KMessageCodeMap.php";
// require_once dirname(__FILE__)."/../DB_Utilities/MYSQL_DBTool.php";
// require_once dirname(__FILE__)."/../Log_Utilities/LogToolCreator.php";
require_once dirname(__FILE__)."/01ModuleConfigReader.php";
require_once dirname(__FILE__)."/KEnvReader.php";
class KIgniter
{


    private static $envReader = null; 
    private static function createEnvReader()
    {
        
        $envPath = __DIR__."/../.env";            
        $envReader = new KEnvReader($envPath);

        return $envReader;
    }

    public static function GetEnvReader()
    {
        if(self::$envReader == null)
        {
            self::$envReader = self::createEnvReader();
        }

        return self::$envReader;
    }



    public static function Ignite()
    { 
        $configPath = __DIR__."/../ModuleConfig.json";

        self::$envReader = self::createEnvReader();
        
        $configReader =  ModuleConfigReader::createNewConfigs([] );

        $configReaderJSON = new  JSONFileReader($configReader);
        
       $configs= (array) $configReaderJSON->getFileContent($configPath);

     


        $configReader =  ModuleConfigReader::createNewConfigs($configs );

        return $configReader; 
    }



}


?>