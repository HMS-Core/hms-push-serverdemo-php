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
namespace push_admin\push_msg\android;
include_once (dirname(__FILE__) . '/../ValidatorUtil.php');

use push_admin\ValidatorUtil;
use Exception;

class LightSetting
{

    private $color;

    private $light_on_duration;

    private $light_off_duration;

    private $fields;

    public function __construct()
    {
        $this->color = array();
        $this->fields = array();
    }

    public function color($value)
    {
        $this->color = $value;
    }

    public function light_on_duration($value)
    {
        $this->light_on_duration = $value;
    }

    public function light_off_duration($value)
    {
        $this->light_off_duration = $value;
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
            'color',
            'light_on_duration',
            'light_off_duration'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function check_parameter()
    {
        if (empty($this->color)){
            throw new Exception("color must be selected when light_settings is set");
        }
        if (empty($this->light_on_duration)){
            throw new Exception("light_on_duration must be selected when light_settings is set");
        }
        if (empty($this->light_off_duration)){
            throw new Exception("light_off_duration must be selected when light_settings is set");
        }
        $LIGTH_DURATION_PATTERN = "/\\d+|\\d+[sS]|\\d+.\\d{1,9}|\\d+.\\d{1,9}[sS]/";
        if ( FALSE == ValidatorUtil::validatePattern($LIGTH_DURATION_PATTERN,$this->light_on_duration)) {
            throw new Exception("light_on_duration format is wrong");
        }
        if (FALSE == ValidatorUtil::validatePattern($LIGTH_DURATION_PATTERN,$this->light_off_duration) ) {
            throw new Exception("light_off_duration format is wrong");
        }

       
    }
}