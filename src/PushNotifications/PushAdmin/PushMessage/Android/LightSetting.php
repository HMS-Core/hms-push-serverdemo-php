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
 * function: LightSetting class =>AndroidNotification(light_setting)
 *                              =>AndroidConfig(notification)
 *                              =>PushMessage(android)
 */
namespace Huawei\PushNotifications\PushAdmin\PushMessage\Android;

use Exception;
use Huawei\PushNotifications\PushAdmin\PushMessage\ValidatorUtil;

class LightSetting
{
    private $color;
    private $lightOnDuration;
    private $lightOffDuration;
    private $fields;

    public function __construct()
    {
        $this->color = array();
        $this->fields = array();
    }

    public function setColor($value)
    {
        $this->color = $value;
    }

    public function setLightOnDuration($value)
    {
        $this->lightOnDuration = $value;
    }

    public function setLightOffDuration($value)
    {
        $this->lightOffDuration = $value;
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
            'color',
            'lightOnDuration',
            'lightOffDuration'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function checkParameter()
    {
        if (empty($this->color)) {
            throw new Exception("color must be selected when light_settings is set");
        }
        if (empty($this->lightOnDuration)) {
            throw new Exception("light_on_duration must be selected when light_settings is set");
        }
        if (empty($this->lightOffDuration)) {
            throw new Exception("light_off_duration must be selected when light_settings is set");
        }
        $LIGTH_DURATION_PATTERN = "/\\d+|\\d+[sS]|\\d+.\\d{1,9}|\\d+.\\d{1,9}[sS]/";
        if (false == ValidatorUtil::validatePattern($LIGTH_DURATION_PATTERN, $this->lightOnDuration)) {
            throw new Exception("light_on_duration format is wrong");
        }
        if (false == ValidatorUtil::validatePattern($LIGTH_DURATION_PATTERN, $this->lightOffDuration)) {
            throw new Exception("light_off_duration format is wrong");
        }
    }
}
