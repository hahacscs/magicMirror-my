<?php

define("DEBUG_MODE", true);

class FacePP {

    private $api_server_url;
    private $auth_params;

    public function __construct($api_key, $api_secret) {
        $this->api_server_url = "https://api-cn.faceplusplus.com/facepp/v3/";
        $this->auth_params = array();
        $this->auth_params['api_key'] = $api_key;
        $this->auth_params['api_secret'] = $api_secret;
    }

    //////////////////////////////////////////////////////////
    // public mathods
    //////////////////////////////////////////////////////////
    //
    //探测图片中的人脸
    //$flags 为urls时使用网络图片，为files时则上传本地图片。
    public function face_detect($flags, $names, $return_landmark = null, $return_attributes = null) {
        if ($flags === 'urls') {
            return $this->post_call("detect", array("image_url" => $names,
                        "return_landmark" => $return_landmark,
                        "return_attributes" => $return_attributes));
        } elseif ($flags === 'files') {
//        $size = filesize($filename);
            if (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION >= 5) { /* CURLFile */
                $cfile = curl_file_create($names); // curl_file_create($filename,'image/jpg','testpic')
            } else { /* Old way */
                $cfile = '@' . $names;
            }
            return $this->post_call("detect", array(
                        "image_file" => $cfile,
                        "return_landmark" => $return_landmark,
                        "return_attributes" => $return_attributes
            ));
        } else {
            return 'flags error!';
        }
    }
    
    //比对两张人脸
    //$flags 为数组，$flags['face1']和$flags['face2'] 都有三个值'token','urls','files',
    //分别表示使用token、网络图片、本地图片进行比较。
    public function face_compare($flags, $names1, $names2) {
        if ($flags['face1'] === 'token') {
            $param1 = "face_token1";
        } elseif ($flags['face1'] === 'urls') {
            $param1 = "image_url1";
        } elseif ($flags['face1'] === 'files') {
            $param1 = "image_file1";
//        $size = filesize($filename);
            if (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION >= 5) { /* CURLFile */
                $names1 = curl_file_create($names1); // curl_file_create($filename,'image/jpg','testpic')
            } else { /* Old way */
                $names1 = '@' . $names1;
            }
        } else {
            return "flags[face1] error!";
        }


        if ($flags['face2'] === 'token') {
            $param2 = "face_token2";
        } elseif ($flags['face2'] === 'urls') {
            $param2 = "image_url2";
        } elseif ($flags['face2'] === 'files') {
            $param2 = "image_file2";
//        $size = filesize($filename);
            if (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION >= 5) { /* CURLFile */
                $names2 = curl_file_create($names2); // curl_file_create($filename,'image/jpg','testpic')
            } else { /* Old way */
                $names2 = '@' . $names2;
            }
        } else {
            return "flags[face2] error!";
        }
        $params = array($param1 => $names1,
            $param2 => $names2);
        //var_dump($params);
        return $this->post_call("compare", $params);
    }
    
    //在Faceset中找出与目标人脸最相似的一张或多张人脸。
    //必选（三选一）            face_token          String          与Faceset中人脸比对的face_token，优先使用本参数。
    //                         image_url            String          图片的URL
    //                         image_file           File            一个图片，二进制文件，需要用post multipart/form-data的方式上传.如果同时传入了image_url1和image_file1参数，本API将使用image_file1参数。
    //必选（二选一）            faceset_token       String          Faceset的标识
    //                         outer_id             String          用户自定义的Faceset标识
    //可选                     return_result_count  Int             返回比对置信度最高的n个结果，范围[1,5]。默认值为1
    public function face_search($flags, $names1, $names2, $return_result_count = null) {
        if ($flags['face1'] === 'token') {
            $param1 = "face_token";
        } elseif ($flags['face1'] === 'urls') {
            $param1 = "image_url";
        } elseif ($flags['face1'] === 'files') {
            $param1 = "image_file";
//        $size = filesize($filename);
            if (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION >= 5) { /* CURLFile */
                $names1 = curl_file_create($names1); // curl_file_create($filename,'image/jpg','testpic')
            } else { /* Old way */
                $names1 = '@' . $names1;
            }
        } else {
            return "flags[face1] error!";
        }
        
        if ($flags['faceset2'] === 'token') {
            $param2 = "faceset_token";
        } elseif ($flags['faceset2'] === 'id') {
            $param2 = "outer_id";
        } else {
            return "flags[faceset2] error!";
        }
        $params = array($param1 => $names1,
            $param2 => $names2,
            'return_result_count' => $return_result_count);
        //var_dump($params);
        return $this->post_call("search", $params);
    }
   
    //创建faceset
    public function faceset_create($display_name = null, $outer_id = null, $tags = null, $face_tokens = null, $user_data = null, $force_merge = null) {
            return $this->post_call("faceset/create", array("display_name" => $display_name,
                        "outer_id" => $outer_id,
                        "tags" => $tags,
                        "face_tokens" => $face_tokens,
                        "user_data" => $user_data,
                        "force_merge" => $force_merge));
    }

    //在faceset中增加人脸
    public function faceset_addface($flags , $faceset, $face_tokens ) {
        if($flags === 'token') $title = 'faceset_token';
        elseif($flags === 'id') $title = 'outer_id';
        else return 'flags errors';
        return $this->post_call("faceset/addface", array($title => $faceset,"face_tokens" => $face_tokens));
    }
    
    
    //在faceset中删除人脸
    public function faceset_removeface($flags , $faceset, $face_tokens ) {
        if($flags === 'token') $title = 'faceset_token';
        elseif($flags === 'id') $title = 'outer_id';
        else return 'flags errors';
        return $this->post_call("faceset/removeface", array($title => $faceset,"face_tokens" => $face_tokens));
    }
    
    //更新feceset的信息
    public function faceset_update($flags , $faceset, $new_outer_id = null, $display_name = null, $user_data = null, $tags = null ) {
        if(empty($new_outer_id)&&empty($display_name)&&empty($user_data)&&empty($tags)){return '参数不全';}
        if($flags === 'token') $title = 'faceset_token';
        elseif($flags === 'id') $title = 'outer_id';
        else return 'flags errors';
        return $this->post_call("faceset/update", array($title => $faceset,
                                                    "face_tokens" => $face_tokens,
                                                    'new_outer_id' => $new_outer_id,
                                                    'display_name' => $display_name,
                                                    'user_data' => $user_data,
                                                    'tags' => $tags));
    }
    
    //获取feceset的信息
    public function faceset_getdetail($flags , $faceset ) {
        if($flags === 'token') $title = 'faceset_token';
        elseif($flags === 'id') $title = 'outer_id';
        else return 'flags errors';
        return $this->post_call("faceset/getdetail", array($title => $faceset));
    }
    
    //获取所有的FaceSet
    //可选	tags	String	包含需要查询的FaceSet标签的字符串，用逗号分隔
    //可选	start	Int	传入参数start，控制从第几个Faceset开始返回。返回的Faceset按照创建时间排序，每次返回1000个FaceSets。默认值为1。
    public function faceset_getfacesets($tags = null , $start = null ) {
        return $this->post_call("faceset/getfacesets", array('tags' => $tags,'start' => $start));
    }

    //删除一个人脸faceset集合。
    //必选（二选一）	faceset_token	String	FaceSet的标识
    //                  outer_id	String	用户提供的FaceSet标识
    //       可选	check_empty	Int	删除时是否检查FaceSet中是否存在face_token，默认值为1。 0：不检查  1：检查 如果设置为1，当FaceSet中存在face_token则不能删除
    public function faceset_delete($flags , $faceset ,$check_empty = null) {
        if($flags === 'token') $title = 'faceset_token';
        elseif($flags === 'id') $title = 'outer_id';
        else return 'flags errors';
        return $this->post_call("faceset/delete", array($title => $faceset,'check_empty' => $check_empty));
    }

    //分析得出人脸的五官关键点，人脸属性和人脸质量判断信息。最多支持分析5个人脸。
    //必选              face_tokens         String      一个字符串，由一个或多个人脸标识组成，用逗号分隔。最多支持5个face_token。
    //必选              return_landmark     Int         是否检测并返回人脸五官和轮廓的83个关键点。 1:检测  0:不检测 注：默认值为0
    //（至少检测一项）   return_attributes   String     是否检测并返回根据人脸特征判断出的年龄，性别，微笑、人脸质量等属性，需要将需要检测的属性组织成一个用逗号分隔的字符串。
    //                  目前支持：gender, age, smiling,headpose,facequality,blur,eyestatus,ethnicity 顺序没有要求。默认值为 none ，表示不检测属性。请注意none如果与任何属性共用则都不检测属性。
    public function face_analyze($face_tokens , $return_landmark = null ,$return_attributes = null) {
        if(empty($return_landmark)&&empty($return_attributes)){return '参数不全';}
        return $this->post_call("face/analyze", array('face_tokens' => $face_tokens,
                                                        'return_landmark' => $return_landmark,
                                                        'return_attributes' => $return_attributes));
    }

    //获取一个人脸的关联信息，包括源图片ID、归属的FaceSet。
    //必选      face_token      String      人脸标识face_token
    public function face_getdetail($face_token) {
        return $this->post_call("face/getdetail", array('face_token' => $face_token));
    }    

    //为检测出的某一个人脸添加标识信息，该信息会在Search接口结果中返回，用来确定用户身份。
    //必选          face_token          String          人脸标识face_token
    //必选          user_id             String          用户自定义的user_id，不超过255个字符，不能包括^@,&=*'" 建议将同一个人的多个face_token设置同样的user_id。
    public function face_setuserid($face_token,$user_id) {
        return $this->post_call("face/setuserid", array('face_token' => $face_token,'user_id' => $user_id));
    }    
    //////////////////////////////////////////////////////////
    // private mathods
    //////////////////////////////////////////////////////////

    protected function call($method, $params = array()) {
        $params = array_merge($this->auth_params, $params);
        $url = $this->api_server_url . "$method?" . http_build_query($params);

        if (DEBUG_MODE) {
            var_dump($params);
            echo "REQUEST: $url" . "\r\n";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);

        $result = null;
        if (!empty($data)) {
            if (DEBUG_MODE) {
                echo "RETURN: " . $data . "\r\n";
            }
            $result = $this->objtoarr(json_decode($data));
        }

        return $result;
    }

    protected function post_call($method, $params = array()) {
        $params = array_merge($this->auth_params, $params);
        $url = $this->api_server_url . "$method";

        if (DEBUG_MODE) {
            var_dump($params);
            echo "postREQUEST: $url?" . http_build_query($params) . "\r\n";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json: charset=utf-8" ,"Content-Length: ".strlen($params)));
//        curl_setopt($ch, CURLOPT_INFILESIZE,$size); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);

        $result = null;
        if (!empty($data)) {
            if (DEBUG_MODE) {
                echo "postRETURN: " . $data . "\r\n";
            }
            $result = $this->objtoarr(json_decode($data));
        }

        return $result;
    }
    
    //json对象转为数组
    protected function objtoarr($obj){
        $ret = array();
            foreach($obj as $key =>$value){
                if(gettype($value) == 'array' || gettype($value) == 'object'){
                    $ret[$key] = $this->objtoarr($value);
                }else{
                    $ret[$key] = $value;
            }
        }
        return $ret;
    }

}

?>
