<?php

namespace K_Utilities;
class KCurlTool
{
    public function execute($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        if ($response == false) {
            $response =json_encode(["error"=>  curl_error($curl)."-".curl_errno($curl),"url"=>$url]);
         //   throw new Exception(curl_error($ch), curl_errno($ch));
        } 


        curl_close($curl);

        return $response;
    }

    /*public function execute($url)
    {
        // create curl resource

        $ch = curl_init();

        if ($ch === false) {
            
            throw new Exception('failed to initialize');
        }
        // set url

        curl_setopt($ch, CURLOPT_URL, $url);



        //return the transfer as a string

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_PROXY, $proxy); // $proxy is ip of proxy server
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE); // this results 0 every time



        // $output contains the output string

        $output = curl_exec($ch);

          // Check the return value of curl_exec(), too
        if ($output == false) {
            $output =json_encode(["error"=>  curl_error($ch)."-".curl_errno($ch)]);
         //   throw new Exception(curl_error($ch), curl_errno($ch));
        } 

        // close curl resource to free up system resources

        curl_close($ch);   

        return $output;
    }*/
}