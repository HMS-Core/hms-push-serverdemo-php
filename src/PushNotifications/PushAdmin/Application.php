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
namespace Huawei\PushNotifications\PushAdmin;

class Application
{
    private $appId;
    private $appSecret;
    private $tokenExpiredTime;
    private $accessToken;
    private $validateOnly;
    private $hwTokenServer;
    private $hwPushServer;
    private $fields;

    public function __construct($appId, $appSecret, $hwTokenServer, $hwPushServer)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->hwTokenServer = $hwTokenServer;
        $this->hwPushServer = $hwPushServer;
        $this->tokenExpiredTime = null;
        $this->accesstoken = null;
        $this->validateOnly = false;
    }

    public function appId($value)
    {
        $this->appId = $value;
    }

    public function appSecret($value)
    {
        $this->appSecret = $value;
    }

    public function validateOnly($value)
    {
        $this->validateOnly = $value;
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

    private function isTokenExpired()
    {
        if (empty($this->accesstoken)) {
            return true;
        }
        if (time() > $this->tokenExpiredTime) {
            return true;
        }
        return false;
    }

    private function refreshToken()
    {
        $result = json_decode($this->curlHttpsPost($this->hwTokenServer, http_build_query(array(
            "grant_type" => "client_credentials",
            "client_secret" => $this->appSecret,
            "client_id" => $this->appId
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
        $this->tokenExpiredTime = time() + $result->expires_in;
        return $this->accessToken;
    }

    private function curlHttpsPost($url, $data = array(), $header = array())
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
            $this->printLogMethodOperate('curl_exec error #' . curl_errno($ch) . ' : ' . curl_error($ch), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_ERROR_LEVEL);
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
    public function pushSendMsg($msg)
    {
        $this->printLogMethodOperate('push_send_msg enter msg:' . json_encode($msg), __FUNCTION__ . ':' . __LINE__);
        $body = array(
            "validate_only" => $this->validateOnly,
            "message" => $msg
        );

        $this->printLogMethodOperate('push_send_msg new body:' . json_encode($body), __FUNCTION__ . ':' . __LINE__, Constants::HW_PUSH_LOG_DEBUG_LEVEL);

        if ($this->isTokenExpired()) {
            $this->refreshToken();
        }
        
        if (empty($this->accesstoken)) {
            $this->printLogMethodOperate(
                "accesstoken is empty!",
                __FUNCTION__ . ':' . __LINE__,
                Constants::HW_PUSH_LOG_ERROR_LEVEL
            );
            return null;
        }

        $result = json_decode($this->curlHttpsPost(
            str_replace('{appid}', $this->appId, $this->hwPushServer),
            json_encode($body),
            array(
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
    public function commonSendMsg($msg)
    {
        $this->printLogMethodOperate('common_send_msg enter msg:' . json_encode($msg), __FUNCTION__ . ':' . __LINE__);
        if ($this->isTokenExpired()) {
            $this->refreshToken();
        }
        
        if (empty($this->accesstoken)) {
            $this->printLogMethodOperate(
                "accesstoken is empty!",
                __FUNCTION__ . ':' . __LINE__,
                Constants::HW_PUSH_LOG_ERROR_LEVEL
            );
            return null;
        }

        $result = json_decode($this->curlHttpsPost(
            str_replace('{appid}', $this->appId, $this->hwPushServer),
            json_encode($msg),
            array(
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
