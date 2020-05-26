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

include_once (dirname(__FILE__) . '/../ValidatorUtil.php');

include_once (dirname(__FILE__) . '/../../../push_admin/PushLogConfig.php');

use Exception;
use push_admin\ValidatorUtil;
use push_admin\Constants;
use push_admin\ApnConstant;
use push_admin\PushLogConfig;

class ApnsHeaders
{

    private $authorization;

    private $apns_id;

    private $apns_expiration;

    private $apns_priority;

    private $apns_topic;

    private $apns_collapse_id;

    private $fields;

    public function authorization($value)
    {
        $this->authorization = $value;
    }

    public function apns_id($value)
    {
        $this->apns_id = $value;
    }

    public function apns_expiration($value)
    {
        $this->apns_expiration = $value;
    }

    public function apns_priority($value)
    {
        $this->apns_priority = $value;
    }

    public function apns_topic($value)
    {
        $this->apns_topic = $value;
    }

    public function apns_collapse_id($value)
    {
        $this->apns_collapse_id = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function buildFields()
    {
        try {
            $this->check_parameter();
        } catch (Exception $e) {
            echo $e;
        }
        $keys = array(
            'authorization',
            'apns-id',
            'apns-expiration',
            'apns-priority',
            'apns-topic',
            'apns-collapse-id'
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

    private function check_parameter()
    {
        if (! empty($this->authorization)) {
            if (FALSE == ValidatorUtil::validatePattern(Constants::APN_AUTHORIZATION_PATTERN, $this->authorization)) {
                throw new Exception("authorization must start with bearer");
            }
        }
        if (! empty($this->apns_id)) {
            if (FALSE == ValidatorUtil::validatePattern(Constants::APN_ID_PATTERN, $this->apns_id)) {
                throw new Exception("apns-id format error");
            }
        }
        if (! empty($this->apns_priority)) {
            if (! in_array($this->apns_priority, array(
                ApnConstant::ANP_PRIORITY_SEND_BY_GROUP,
                ApnConstant::ANP_PRIORITY_SEND_IMMEDIATELY
            ))) {
                throw new Exception("apns-priority should be SEND_BY_GROUP:5  or SEND_IMMEDIATELY:10");
            }
        }
        if (! empty($this->apns_collapse_id)) {
            if (strlen($this->apns_priority) >= 64) {
                throw new Exception("Number of apnsCollapseId bytes should be less than 64");
            }
        }
    }
}