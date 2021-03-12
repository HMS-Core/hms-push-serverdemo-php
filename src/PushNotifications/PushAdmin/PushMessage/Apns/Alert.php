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
 * function: Alert => =>PushMessage(apns) for ios channel
 */
namespace Huawei\PushNotifications\PushAdmin\PushMessage\Apns;

use Huawei\PushNotifications\PushAdmin\Constants;
use Huawei\PushNotifications\PushAdmin\PushLogConfig;

class Alert
{
    private $title;
    private $body;
    private $titleLocKey;
    private $titleLocArgs;
    private $actionLocKey;
    private $locKey;
    private $locArgs;
    private $launchImage;
    
    private $fields;
    
    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function setBody($value)
    {
        $this->body = $value;
    }

    public function setTitleLocKey($value)
    {
        $this->titleLocKey = $value;
    }

    public function setTitleLocArgs($value)
    {
        $this->titleLocArgs = $value;
    }

    public function setActionLocKey($value)
    {
        $this->actionLocKey = $value;
    }

    public function setLocKey($value)
    {
        $this->locKey = $value;
    }

    public function setLocArgs($value)
    {
        $this->locArgs = $value;
    }

    public function setLaunchImage($value)
    {
        $this->launchImage = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }
    
    public function buildFields()
    {
        $keys = array(
            'title',
            'body',
            'titleLocKey',
            'titleLocArgs',
            'actionLocKey',
            'locKey',
            'locArgs',
            'launchImage'
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
