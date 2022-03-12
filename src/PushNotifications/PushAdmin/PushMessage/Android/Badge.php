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
namespace Huawei\PushNotifications\PushAdmin\PushMessage\Android;

use Exception;

class Badge
{
    private $addNum;
    private $class;
    private $setNum;
    private $fields;

    public function __construct()
    {
        $this->fields = array();
    }

    public function addNum($value)
    {
        $this->addNum = $value;
    }

    public function setClass($value)
    {
        $this->class = $value;
    }

    public function setNum($value)
    {
        $this->setNum = $value;
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
            'addNum',
            'class',
            'setNum'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function checkParameter()
    {
        if (($this->addNum) && (gettype($this->addNum) != "integer")) {
            throw new Exception("type of add_num is wrong.");
        }
        if (is_int($this->addNum) && ($this->addNum < 1 || $this->addNum > 100)) {
            throw new Exception("add_num should locate between 0 and 100");
        }
        if (($this->setNum) && (gettype($this->setNum) != "integer")) {
            throw new Exception("type of set_num is wrong.");
        }
        if (is_int($this->setNum) && ($this->setNum < 1 || $this->setNum > 100)) {
            throw new Exception("set_num should locate between 0 and 100");
        }
    }
}
