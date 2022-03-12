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

namespace Huawei\PushNotifications\PushAdmin\PushMessage\Android;

use Exception;
use Huawei\PushNotifications\PushAdmin\Constants;
use Huawei\PushNotifications\PushAdmin\PushLogConfig;
use Huawei\PushNotifications\PushAdmin\PushMessage\ValidatorUtil;
use Huawei\PushNotifications\PushAdmin\AndroidConfigDeliveryPriority;

class AndroidConfig
{
    private $collapseKey;
    private $category;
    private $urgency;
    private $ttl;
    private $biTag;
    private $fastAppTarget;
    private $notification;
    private $fields;
    private $data;

    public function __construct()
    {
        $this->urgency = null;
        $this->notification = null;
        $this->fields = array();
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setCollapseKey($value)
    {
        $this->collapseKey = $value;
    }

    public function setCategory($value)
    {
        $this->category = $value;
    }

    public function setUrgency($value)
    {
        $this->urgency = $value;
    }

    public function setTtl($value)
    {
        $this->ttl = $value;
    }

    public function setBiTag($value)
    {
        $this->biTag = $value;
    }

    public function setFastAppTarget($value)
    {
        $this->fastAppTarget = $value;
    }

    public function setNotification($value)
    {
        $this->notification = $value;
    }

    public function setData($value)
    {
        $this->data = $value;
    }

    public function buildFields()
    {
        try {
            $this->checkParameter();
        } catch (Exception $e) {
            PushLogConfig::getSingleInstance()->LogMessage($e, Constants::HW_PUSH_LOG_ERROR_LEVEL);
            return;
        }
        $keys = array(
            'collapseKey',
            'category',
            'urgency',
            'ttl',
            'biTag',
            'fastAppTarget',
            'notification',
            'data'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    public function getAllVars()
    {
        var_dump(get_object_vars($this));
    }

    private function checkParameter()
    {
        if (! empty($this->collapseKey) && ($this->collapseKey < - 1 || $this->collapseKey > 100)) {
            throw new Exception("Collapse Key should be [-1, 100]");
        }
        if (! empty($this->fastAppTarget) && ! in_array($this->fastAppTarget, array(
            1,
            2
        ))) {
            throw new Exception("Invalid fast app target type[one of 1 or 2]");
        }

        if (! empty($this->urgency) && ! in_array($this->urgency, array(
            AndroidConfigDeliveryPriority::PRIORITY_HIGH,
            AndroidConfigDeliveryPriority::PRIORITY_NORMAL
        ))) {
            throw new Exception("delivery priority shouid be [HIGH, NOMAL]");
        }

        if (! empty($this->ttl)) {
            if (false == ValidatorUtil::validatePattern(Constants::TTL_PATTERN, $this->ttl)) {
                throw new Exception("The TTL's format is wrong");
            }
        }
    }
}
