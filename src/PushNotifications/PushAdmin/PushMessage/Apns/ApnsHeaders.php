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

use Exception;
use Huawei\PushNotifications\PushAdmin\Constants;
use Huawei\PushNotifications\PushAdmin\PushLogConfig;
use Huawei\PushNotifications\PushAdmin\PushMessage\ValidatorUtil;
use Huawei\PushNotifications\PushAdmin\ApnConstant;

class ApnsHeaders
{
    private $authorization;
    private $apnsId;
    private $apnsExpiration;
    private $apnsPriority;
    private $apnsTopic;
    private $apnsCollapseId;
    private $fields;

    public function setAuthorization($value)
    {
        $this->authorization = $value;
    }

    public function setApnsId($value)
    {
        $this->apnsId = $value;
    }

    public function setApnsExpiration($value)
    {
        $this->apnsExpiration = $value;
    }

    public function setApnsPriority($value)
    {
        $this->apnsPriority = $value;
    }

    public function setApnsTopic($value)
    {
        $this->apnsTopic = $value;
    }

    public function setApnsCollapseId($value)
    {
        $this->apnsCollapseId = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function buildFields()
    {
        try {
            $this->checkParameter();
        } catch (Exception $e) {
            echo $e;
        }
        $keys = array(
            'authorization',
            'apnsId',
            'apnsExpiration',
            'apnsPriority',
            'apnsTopic',
            'apnsCollapseId'
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

    private function checkParameter()
    {
        if (! empty($this->authorization)) {
            if (false == ValidatorUtil::validatePattern(Constants::APN_AUTHORIZATION_PATTERN, $this->authorization)) {
                throw new Exception("authorization must start with bearer");
            }
        }
        if (! empty($this->apnsId)) {
            if (false == ValidatorUtil::validatePattern(Constants::APN_ID_PATTERN, $this->apnsId)) {
                throw new Exception("apns-id format error");
            }
        }
        if (! empty($this->apnsPriority)) {
            if (! in_array($this->apnsPriority, array(
                ApnConstant::ANP_PRIORITY_SEND_BY_GROUP,
                ApnConstant::ANP_PRIORITY_SEND_IMMEDIATELY
            ))) {
                throw new Exception("apns-priority should be SEND_BY_GROUP:5  or SEND_IMMEDIATELY:10");
            }
        }
        if (! empty($this->apnsCollapseId)) {
            if (strlen($this->apnsPriority) >= 64) {
                throw new Exception("Number of apnsCollapseId bytes should be less than 64");
            }
        }
    }
}
