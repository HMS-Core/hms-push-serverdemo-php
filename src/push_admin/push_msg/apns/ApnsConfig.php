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
namespace push_admin\push_msg\apns;


include_once (dirname(__FILE__) . '/../../../push_admin/PushLogConfig.php');
use push_admin\PushLogConfig;
use push_admin\Constants;

class ApnsConfig
{
    private $payload;
    private $headers;
    private $hms_options;
    
    private $fields;

    public function __construct()
    {
        $this->fields = array();
    }

    public function payload($value)
    {
        $this->payload = $value;
    }
    public function headers($value)
    {
        $this->headers = $value;
    }
    public function hms_options($value)
    {
        $this->hms_options = $value;
    }
    public function getFields()
    {
        return $this->fields;
    }

    public function buildFields()
    {

        $keys = array(
            'headers',
            'hms_options',
            'payload'
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

