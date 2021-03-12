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

namespace Huawei\PushNotifications\PushAdmin\PushMessage\Apns;

use Huawei\PushNotifications\PushAdmin\Constants;
use Huawei\PushNotifications\PushAdmin\PushLogConfig;

class Aps
{
    private $alert;
    private $badge;
    private $sound;
    private $contentAvailable;
    private $category;
    private $threadId;
    
    private $fields;
    
    public function setAlert($value)
    {
        $this->alert = $value;
    }
    public function setBadge($value)
    {
        $this->badge = $value;
    }
    public function setSound($value)
    {
        $this->sound = $value;
    }
    public function setContentAvailable($value)
    {
        $this->contentAvailable = $value;
    }
    public function setCategory($value)
    {
        $this->category = $value;
    }
    public function setThreadId($value)
    {
        $this->threadId = $value;
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
            'contentAvailable',
            'category',
            'threadId'
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
