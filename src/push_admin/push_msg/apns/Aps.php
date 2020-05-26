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

namespace push_admin\push_msg\apns;

include_once (dirname(__FILE__) . '/../../../push_admin/PushLogConfig.php');
use push_admin\PushLogConfig;
use push_admin\Constants;

class Aps {
    
    private $alert;
    private $badge;
    private $sound;
    private $content_available;
    private $category;
    private $thread_id;
    
    private $fields;
    
    public function alert($value) {
        $this->alert = $value;
    }
    public function badge($value) {
        $this->badge = $value;
    }
    public function sound($value) {
        $this->sound = $value;
    }
    public function content_available($value) {
        $this->content_available = $value;
    }
    public function category($value) {
        $this->category = $value;
    }
    public function thread_id($value) {
        $this->thread_id = $value;
    }
   
    public function getFields()
    {
        return $this->fields;
    }
    
    public function buildFields()
    {
        $keys = array(
            'alert',
            'badge',
            'sound',
            'content-available',
            'category',
            'thread-id'
        );
        foreach ($keys as $key) {
            
            $value = str_replace('-', '_', $key);
            
            PushLogConfig::getSingleInstance()->LogMessage('[' . __CLASS__ . '][before key:' . $key . '][after key:' . $value . ']', Constants::HW_PUSH_LOG_DEBUG_LEVEL);
            if (isset($this->$value)) {
                $this->fields[$key] = $this->$value;
            }
        }
        PushLogConfig::getSingleInstance()->LogMessage('[' . __CLASS__ . '][buildFields result:' . json_encode($this->fields), Constants::HW_PUSH_LOG_DEBUG_LEVEL);
        
    }
    
}