<?php


namespace K_Utilities;
class KEnvReader
{


    private $envVars = [];
    private $envPath;
    private $loaded = false;

    public function __construct($envPath = null)
    {
        $this->envPath = $envPath ?? dirname(__DIR__) . '/.env';
        $this->loadEnvFile();
    }

    private function loadEnvFile()
    {
       if (!file_exists($this->envPath)) {
            throw new \Exception("Environment file not found: " . $this->envPath);
        }
        $lines = file($this->envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach($lines as $line)
        {
            $line = trim($line);
            // Skip comments and invalid lines
            if (empty($line) || strpos($line, '#') === 0)    continue;
            


            if (strpos($line,'=')<=0) continue;
           
              list($key, $value) = explode('=', $line, 2);
              $key = trim($key);
              $value = trim($value, '"\'');
              $this->envVars[$key] = $value;
        }

        $this->loaded = true;

    }


    public function get($key,$default = null)
    {
        if(!$this->loaded)
            $this->loadEnvFile();

        return isset($this->envVars[$key])?$this->envVars[$key]: $default;
    }

}