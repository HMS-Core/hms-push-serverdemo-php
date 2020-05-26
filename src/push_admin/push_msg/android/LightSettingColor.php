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
 * function: LightSettingColor =>LightSetting(color)
 *                             =>AndroidNotification(light_setting)
 *                             =>AndroidConfig(notification)
 *                             =>PushMessage(android)
 */
namespace push_admin\push_msg\android;

use Exception;

class LightSettingColor
{

    private $alpha;

    private $red;

    private $green;

    private $blue;

    private $fields;

    public function __construct()
    {
        $this->alpha = 1;
        $this->red = 0;
        $this->green = 0;
        $this->blue = 0;
        $this->fields = array();
    }

    public function setgenFullcolor($alpha, $red, $green, $blue)
    {
        $this->alpha = $alpha;
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public function alpha($value)
    {
        $this->alpha = $value;
    }

    public function red($value)
    {
        $this->red = $value;
    }

    public function green($value)
    {
        $this->green = $value;
    }

    public function blue($value)
    {
        $this->blue = $value;
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
            'alpha',
            'red',
            'green',
            'blue'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function check_parameter()
    {
        if (empty($this->alpha) && (gettype($this->alpha) != "integer")) {
            throw new Exception("type of alpha is wrong.");
        }
        if (empty($this->red) && (gettype($this->red) != "integer")) {
            throw new Exception("type of red is wrong.");
        }
        if (empty($this->green) && (gettype($this->green) != "integer")) {
            throw new Exception("type of green is wrong.");
        }
        if (empty($this->blue) && (gettype($this->blue) != "integer")) {
            throw new Exception("type of blue is wrong.");
        }
    }
}