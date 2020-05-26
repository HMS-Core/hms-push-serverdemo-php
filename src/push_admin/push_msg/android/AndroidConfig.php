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
namespace push_admin\push_msg\android;

include_once (dirname(__FILE__) . '/../../Constants.php');
include_once (dirname(__FILE__) . '/../ValidatorUtil.php');

use push_admin\ValidatorUtil;
use push_admin\Constants;
use push_admin\AndroidConfigDeliveryPriority;
use Exception;
use push_admin\PushLogConfig;

class AndroidConfig
{

    private $collapse_key;

    private $category;

    private $urgency;

    private $ttl;

    private $bi_tag;

    private $fast_app_target;

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

    public function collapse_key($value)
    {
        $this->collapse_key = $value;
    }

    public function category($value)
    {
        $this->category = $value;
    }

    public function urgency($value)
    {
        $this->urgency = $value;
    }

    public function ttl($value)
    {
        $this->ttl = $value;
    }

    public function bi_tag($value)
    {
        $this->bi_tag = $value;
    }

    public function fast_app_target($value)
    {
        $this->fast_app_target = $value;
    }

    public function notification($value)
    {
        $this->notification = $value;
    }

    public function data($value)
    {
        $this->data = $value;
    }

    public function buildFields()
    {
        try {
            $this->check_parameter();
        } catch (Exception $e) {
//             echo $e;
            PushLogConfig::getSingleInstance()->LogMessage($e,Constants::HW_PUSH_LOG_ERROR_LEVEL);
            return;
        }
        $keys = array(
            'collapse_key',
            'category',
            'urgency',
            'ttl',
            'bi_tag',
            'fast_app_target',
            'notification',
            'data'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function check_parameter()
    {
        if (! empty($this->collapse_key) && ($this->collapse_key < - 1 || $this->collapse_key > 100)) {
            throw new Exception("Collapse Key should be [-1, 100]");
        }
        if (! empty($this->fast_app_target) && ! in_array($this->fast_app_target, array(
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
            if (FALSE == ValidatorUtil::validatePattern(Constants::TTL_PATTERN, $this->ttl)) {
                throw new Exception("The TTL's format is wrong");
            }
        }
    }

    public function get_all_vars()
    {
        var_dump(get_object_vars($this));
    }
}