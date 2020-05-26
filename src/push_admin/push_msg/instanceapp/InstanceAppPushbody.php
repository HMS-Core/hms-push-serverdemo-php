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
 * function: ApnsConfig => =>PushMessage(apns) for ios channel
 */
namespace push_admin\push_msg\instanceapp;


include_once (dirname(__FILE__) . '/../../../push_admin/PushLogConfig.php');
use push_admin\PushLogConfig;
use push_admin\Constants;

class InstanceAppPushbody
{
    // for pass-through
    private $messageId;
    private $data;
    
    // for notification
    private $title;
    private $description;  
    private $page;
    private $params;
    private $ringtone;
    
    private $fields;

    public function __construct()
    {
    }

    public function messageId($value)
    {
        $this->messageId = $value;
    }
    public function data($value)
    {
        $this->data = $value;
    }
    
    public function title($value)
    {
        $this->title = $value;
    }
    public function description($value)
    {
        $this->description = $value;
    }
   
    public function page($value)
    {
        $this->page = $value;
    }
    public function params($value)
    {
        $this->params = $value;
    }
    
    public function ringtone($value)
    {
        $this->ringtone = $value;
    }
 
    public function getFields()
    {
        $result = "{";
        foreach ($this->fields as $key=>$value) {
            $result = $result .$key.":".json_encode($value).",";
            PushLogConfig::getSingleInstance()->LogMessage('[' . __CLASS__ . '][result:' .$result, Constants::HW_PUSH_LOG_DEBUG_LEVEL);
        }
        if (strlen($result) > 1){
            $result = rtrim($result, ",");
        }
        $result = $result."}";
        return $result;
    }

    public function buildFields()
    {

        $keys = array(
            'messageId',
            'data',
            'title',
            'description',
            'page',
            'params',
            'ringtone'
        );
        foreach ($keys as $key) {
            PushLogConfig::getSingleInstance()->LogMessage('[' . __CLASS__ . '][key:' . $key . '][value:' . json_encode($this->$key) . ']', Constants::HW_PUSH_LOG_DEBUG_LEVEL);
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
        PushLogConfig::getSingleInstance()->LogMessage('[' . __CLASS__ . '][buildFields result:' . json_encode($this->fields), Constants::HW_PUSH_LOG_DEBUG_LEVEL);
       
    }

}

