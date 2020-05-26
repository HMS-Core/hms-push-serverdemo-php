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
 * function: webpush message push control parameter, which is required for webpush msg=>PushMessage(webpush)
 */
namespace push_admin\push_msg\webpush;

class WebPushConfig
{

    private $headers;

    private $data;

    private $notification;

    private $hms_options;

    private $fields;

    public function __construct()
    {
        $this->headers = array();
        $this->notification = array();
        $this->hmsOptions = array();
        $this->fields = array();
    }

    public function headers($value)
    {
        $this->headers = $value;
    }

    public function data($value)
    {
        $this->data = $value;
    }

    public function notification($value)
    {
        $this->notification = $value;
    }

    public function hmsOptions($value)
    {
        $this->hms_options = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function buildFields()
    {
        $keys = array(
            'headers',
            'data',
            'notification',
            'hms_options'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }
}

