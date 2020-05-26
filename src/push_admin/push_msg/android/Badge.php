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
 * function: Badge class    =>AndroidNotification(badge)
 *                          =>AndroidConfig(notification)
 *                          =>PushMessage(android)
 */
namespace push_admin\push_msg\android;

use Exception;

class Badge
{

    private $add_num;

    private $class;

    private $set_num;

    private $fields;

    public function __construct()
    {
        $this->fields = array();
    }

    public function add_num($value)
    {
        $this->add_num = $value;
    }

    public function setclass($value)
    {
        $this->class = $value;
    }

    public function set_num($value)
    {
        $this->set_num = $value;
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
            'add_num',
            'class',
            'set_num'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function check_parameter()
    {
        if (($this->add_num) && (gettype($this->add_num) != "integer")) {
            throw new Exception("type of add_num is wrong.");
        }
        if (is_int($this->add_num) && ($this->add_num < 1 || $this->add_num > 100)) {
            throw new Exception("add_num should locate between 0 and 100");
        }
        if (($this->set_num) && (gettype($this->set_num) != "integer")) {
            throw new Exception("type of set_num is wrong.");
        }
        if (is_int($this->set_num) && ($this->set_num < 1 || $this->set_num > 100)) {
            throw new Exception("set_num should locate between 0 and 100");
        }
        
    }
}