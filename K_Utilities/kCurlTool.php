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

    public function executePost($url,$content)
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
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($content),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
      
            if ($response == false) {
                $response =json_encode(["error"=>  curl_error($curl)."-".curl_errno($curl),"url"=>$url]);
             //   throw new Exception(curl_error($ch), curl_errno($ch));
            } 
 
    
            return $response;
    }

}