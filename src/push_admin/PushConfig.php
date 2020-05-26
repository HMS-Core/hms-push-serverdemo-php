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
 * function: read config file and make it applicaitonable
 */
namespace push_admin;

class PushConfig
{
    // ORDINAL APP
    public $HW_APPID;
    public $HW_APPSECRET;
    public $HW_PUSH_TOKEN_ARR;
    public $APN_PUSH_TOKEN_ARR; 
    public $WEBPUSH_PUSH_TOKEN_ARR;
    
    // FAST APP
    public $HW_FAST_APPID;
    public $HW_FAST_APPSECRET;
    public $HW_FAST_PUSH_TOKEN;
    
    public $HW_TOKEN_SERVER;
    public $HW_PUSH_SERVER;
    public $HW_TOPIC_SUBSCRIBE_SERVER;
    public $HW_TOPIC_UNSUBSCRIBE_SERVER;
    public $HW_TOPIC_QUERY_SUBSCRIBER_SERVER;

    public $HW_DEFAULT_LOG_LEVEL = 3;




    private $log_read_flag = false;

    private function __construct()
    {
        if ($this->log_read_flag == false) {
            $file_path = "../config.ini";
            if (file_exists($file_path)) {
                $file_contents = file($file_path);
                // read line
                for ($i = 0; $i < count($file_contents); $i ++) {
                    $this->processConfigData($file_contents[$i]);
                }
                $this->log_read_flag = true;
            } else {
                echo $file_path . " not exist,please config first!!!<br>";
            }
        }
    }

    public static function getSingleInstance()
    {
        static $obj;
        if (! isset($obj)) {
            $obj = new PushConfig();
        }
        return $obj;
    }

    private function processConfigData($lineData)
    {
        if (empty($lineData)) {
            return;
        }
        if (strncmp($lineData, "#", 1) == 0) {
            return;
        }
        $lineData = str_replace("\"", "", $lineData);
        $lineData = str_replace("\'", "", $lineData);
        $lineData = str_replace(" ", "", $lineData);
        $lineData = str_replace(";", "", $lineData);
        $lineData = str_replace(PHP_EOL, '', $lineData);
        $resultPos = stripos($lineData, "=");
        if (FALSE == $resultPos) {
            return;
        }
        $key = substr($lineData, 0, $resultPos);

        if (FALSE == $key) {
            return;
        }

        $value = $this->processConfigValueData(substr($lineData, $resultPos + 1));
        switch ($key) {
            case "HW_APPID":
                {
                    $this->HW_APPID = $value;
                }
                break;
            case "HW_APPSECRET":
                {
                    $this->HW_APPSECRET = $value;
                }
                break;
            case "HW_TOKEN_SERVER":
                {
                    $this->HW_TOKEN_SERVER = $value;
                }
                break;
            case "HW_PUSH_SERVER":
                {
                    $this->HW_PUSH_SERVER = $value;
                }
                break;
            case "HW_TOPIC_SUBSCRIBE_SERVER":
                {
                    $this->HW_TOPIC_SUBSCRIBE_SERVER = $value;
                }
                break;
            case "HW_TOPIC_UNSUBSCRIBE_SERVER":
                {
                    $this->HW_TOPIC_UNSUBSCRIBE_SERVER = $value;
                }
                break;
            case "HW_TOPIC_QUERY_SUBSCRIBER_SERVER":
                {
                    $this->HW_TOPIC_QUERY_SUBSCRIBER_SERVER = $value;
                }
                break;

            case "HW_PUSH_TOKEN_ARR":
                {
                    $this->HW_PUSH_TOKEN_ARR = $value;
                }
                break;

            case "APN_PUSH_TOKEN_ARR":
                {
                    $this->APN_PUSH_TOKEN_ARR = $value;
                }
                break;

            case "WEBPUSH_PUSH_TOKEN_ARR":
                {
                    $this->WEBPUSH_PUSH_TOKEN_ARR = $value;
                }
                break;
            case "HW_DEFAULT_LOG_LEVEL":
                {
                    $this->HW_DEFAULT_LOG_LEVEL = $value;
                } 
                break;
                
            case "HW_FAST_APPID":
                {
                    $this->HW_FAST_APPID = $value;
                }
                break;
            case "HW_FAST_APPSECRET":
                {
                    $this->HW_FAST_APPSECRET = $value;
                }
                break;
            case "HW_FAST_PUSH_TOKEN":
                {
                    $this->HW_FAST_PUSH_TOKEN = $value;
                }
                break;
               
        }
    }

    private function processConfigValueData($lineDataMapValue)
    {
        $key = stripos($lineDataMapValue, "\"");
        if (FALSE == $key) {
            return $lineDataMapValue;
        }
        if ($key > 0) {
            return str_replace("\"", "", substr($lineDataMapValue, $key));
        }
        return $lineDataMapValue;
    }
}

