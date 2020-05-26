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
 * function: Notification message push control parameter =>PushMessage(notification) for ios channel
 */
namespace push_admin\push_msg\notification;

/**
 * optional for message
 */
use Exception;
class Notification
{

    /**
     * optional
     */
    private $title;

    /**
     * optional
     */
    private $body;

    /**
     * optional
     */
    private $image;

    private $fields;

    public function __construct($title, $body, $image)
    {
        $this->title = $title;
        $this->body = $body;
        $this->image = $image;
        $this->fields = array();
    }

    public function title($value)
    {
        $this->title = $value;
    }

    public function body($value)
    {
        $this->body = $value;
    }

    public function image($value)
    {
        $this->image = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function buildFields()
    {  try {
        $this->check_parameter();
    } catch (Exception $e) {
        echo $e;
    }
        $keys = array(
            'title',
            'body',
            'image'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }
    
    private function check_parameter()
    {
        if (empty($this->title))
        {
            throw new Exception("title should be set");
        }
        if (empty($this->body))
        {
            throw new Exception("body should be set");
        }
    }
}