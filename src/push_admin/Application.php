<?php
/**
Copyright 2020. Huawei Technologies Co., Ltd. All rights reserved.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
 */

/**
 * function: Application support ability of push msg:
 *           push_send_msg   => push msg
 *           common_send_msg => topic msg
 */
namespace push_admin;

include_once (dirname(__FILE__) . './Constants.php');
include_once (dirname(__FILE__) . './PushLogConfig.php');

class Application
{

    private $appid;

    private $appsecret;

    private $token_expiredtime;

    private $access_token;

    private $validate_only;

    private $hw_token_server;

    private $hw_push_server;

    private $fields;


    public function __construct($appid, $appsecret, $hw_token_server, $hw_push_server)
    {
        $this->appid = $appid;
        $this->appsecret = $appsecret;
        $this->hw_token_server = $hw_token_server;
        $this->hw_push_server = $hw_push_server;
        $this->token_expiredtime = null;
        $this->accesstoken = null;
        $this->validate_only = false;
    }

    public function appid($value)
    {
        $this->appid = $value;
    }

    public function appsecret($value)
    {
        $this->appsecret = $value;
    }

    public function validate_only($value)
    {
        $this->validate_only = $value;
    }

    public function getApplicationFields()
    {
        $keys = array(
            'appid',
            'appsecret',
            'hw_token_server',
            'hw_push_server',
            'validate_only',
            'accesstoken',
            'token_expiredtime'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }

        return $this->fields;
    }

    private function printLogMethodOperate($dataFlow, $functionName = "", $logLevel = Constants::HW_PUSH_LOG_INFO_LEVEL)
    {
        if (empty($functionName)) {
            PushLogConfig::getSingleInstance()->LogMessage('[' . __CLASS__ . ']' . $dataFlow, $logLevel);
        } else {
            PushLogConfig::getSingleInstance()->LogMessage('[' . __CLASS__ . ']' . '[' . $functionName . ']' . $dataFlow, $logLevel);
        }
    }

    private function is_token_expired()
    {
        if (empty($this->accesstoken)) {
            return true;
        }
        if (time() > $this->token_expiredtime) {
            return true;
        }
        return false;
    }

    private function refresh_token()
    {
        $result = json_decode($this->curl_https_post($this->hw_token_server, http_build_query(array(
            "grant_type" => "client_credentials",
            "client_secret" => $this->appsecret,
            "client_id" => $this->appid
        )), array(
            "Content-Type: application/x-www-form-urlencoded;charset=utf-8"
        )));
        $this->printLogMethodOperate('refresh_token result:' . json_encode($result), __FUNCTION__ . ':' . __LINE__);
        if ($result == null || ! array_key_exists("access_token", $result)) {
            $this->printLogMethodOperate('refresh_token result error!', __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_ERROR_LEVEL);
            return null;
        }
        $this->printLogMethodOperate('refresh_token result:' . json_encode($result), __FUNCTION__ . ':' . __LINE__);
        $this->accesstoken = $result->access_token;
        $this->token_expiredtime = time() + $result->expires_in;
        return $this->access_token;
    }

    private function curl_https_post($url, $data = array(), $header = array())
    {
        $this->printLogMethodOperate('curl_https_post enter url:' . $url, __FUNCTION__ . ':' . __LINE__);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $this->printLogMethodOperate('curl_https_post curl send headers:' . json_encode($header), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);
        
        // resolve SSL: no alternative certificate subject name matches target host name
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // check verify
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, 1); // regular post request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Post submit data

        $this->printLogMethodOperate('curl_https_post curl send body:' . $data, __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);

        $ret = @curl_exec($ch);
        if ($ret === false) {
            return null;
        }

        $info = curl_getinfo($ch);

        $this->printLogMethodOperate('curl_https_post curl send info:' . json_encode($info), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);

        curl_close($ch);

        return $ret;
    }

    /**
     * push_send_msg for push msg
     */
    public function push_send_msg($msg)
    {
        $this->printLogMethodOperate('push_send_msg enter msg:' . json_encode($msg), __FUNCTION__ . ':' . __LINE__);
        $body = array(
            "validate_only" => $this->validate_only,
            "message" => $msg
        );

        $this->printLogMethodOperate('push_send_msg new body:' . json_encode($body), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);

        if ($this->is_token_expired()) {
            $this->refresh_token();
        }
        
        if (empty($this->accesstoken)){
            $this->printLogMethodOperate("accesstoken is empty!", 
                __FUNCTION__ . ':' . __LINE__,Constants::HW_PUSH_LOG_ERROR_LEVEL);
            return null;
        }

        $result = json_decode($this->curl_https_post(str_replace('{appid}', $this->appid, $this->hw_push_server), json_encode($body), array(
            "Content-Type: application/json",
            "Authorization: Bearer {$this->accesstoken}"
        ) // Use bearer auth
        ));

        $this->printLogMethodOperate("push_send_msg leave,result:" . json_encode($result), __FUNCTION__ . ':' . __LINE__);
        // $result ==> eg: {"code":"80000000","msg":"Success","requestId":"157278422841836431010901"}

        if (! empty($result)) {
            $arrResult = json_decode(json_encode($result), true);
            if (!empty($arrResult["code"]) && !in_array($arrResult["code"], array( "80000000",80000000))) {
                $this->printLogMethodOperate("push_send_msg leave,result:" . json_encode($result), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_WARN_LEVEL);
            }
        }

        return $result;
    }

    /**
     * common_send_msg for topic msg/other
     */
    public function common_send_msg($msg)
    {
        $this->printLogMethodOperate('common_send_msg enter msg:' . json_encode($msg), __FUNCTION__ . ':' . __LINE__);
        if ($this->is_token_expired()) {
            $this->refresh_token();
        }
        
        if (empty($this->accesstoken)){
            $this->printLogMethodOperate("accesstoken is empty!",
                __FUNCTION__ . ':' . __LINE__,Constants::HW_PUSH_LOG_ERROR_LEVEL);
            return null;
        }

        $result = json_decode($this->curl_https_post(str_replace('{appid}', $this->appid, $this->hw_push_server), json_encode($msg), array(
            "Content-Type: application/json",
            "Authorization: Bearer {$this->accesstoken}"
        ) // Use bearer auth
        ));

        // $result ==> eg: {"code":"80000000","msg":"Success","requestId":"157278422841836431010901"}
        $this->printLogMethodOperate('common_send_msg leave result:' . json_encode($result), __FUNCTION__ . ':' . __LINE__);
        

        if (! empty($result)) {
            $arrResult = json_decode(json_encode($result), true);
            if (isset($arrResult["code"]) && $arrResult["code"] != "80000000") {
                $this->printLogMethodOperate("push_send_msg leave,result:" . json_encode($result), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_WARN_LEVEL);
            }
        }

        return $result;
    }
}
