<?php
define ("DEBUG_MODE", true);

class FacePP
{	
    private $api_server_url;
    private $auth_params;

    public function __construct($api_key, $api_secret)
    {
            $this->api_server_url = "https://api-cn.faceplusplus.com/facepp/v3/";
            $this->auth_params = array();
            $this->auth_params['api_key'] = $api_key;
            $this->auth_params['api_secret'] = $api_secret;
    }

    //////////////////////////////////////////////////////////
    // public mathods
    //////////////////////////////////////////////////////////

    public function face_detect_url($urls = null)
    {
            return $this->post_call("detect", array("image_url" => $urls));
    }
    
    public function face_detect_file($filename)
    {
//        $size = filesize($filename);
        if(PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION >= 5) { /* CURLFile */ 
            $cfile = curl_file_create($filename); // curl_file_create($filename,'image/jpg','testpic')
        } else { /* Old way */ 
            $cfile = '@'.$filename;
        }
            return $this->post_call("detect", array(
                                      "image_file" => $cfile
                                      ));
    }
    
	//////////////////////////////////////////////////////////
	// private mathods
	//////////////////////////////////////////////////////////
	
    protected function call($method, $params = array())
    {
    	$params = array_merge($this->auth_params, $params);
        $url = $this->api_server_url . "$method?".http_build_query($params);

        if (DEBUG_MODE)
        {
                echo "REQUEST: $url" . "\r\n";
        }
		
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
     	$data = curl_exec($ch);
        if(curl_errno($ch))
        {
            print curl_error($ch);
        }
    	curl_close($ch);    
    	
        $result = null;
        if (!empty($data))
        {
                if (DEBUG_MODE)
                {
                        echo "RETURN: " . $data . "\r\n";
                }
                $result = json_decode($data);
        }

        return $result;

    }
    
    protected function post_call($method, $params = array())
    {
    	$params = array_merge($this->auth_params, $params);
        $url = $this->api_server_url . "$method";

        if (DEBUG_MODE)
        {
                echo "postREQUEST: $url?" .http_build_query($params)."\r\n";
        }
        
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//        curl_setopt($ch, CURLOPT_INFILESIZE,$size); 
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     	$data = curl_exec($ch);
        if(curl_errno($ch))
        {
            print curl_error($ch);
        }
    	curl_close($ch);
        
        $result = null;
        if (!empty($data))
        {
                if (DEBUG_MODE)
                {
                        echo "postRETURN: " . $data . "\r\n";
                }
                $result = json_decode($data);
        }

        return $result;
    }
    
}
?>
