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
 * function: WebPush Headers class  =>WebPushConfig(headers)
 *                                  =>PushMessage(webpush)
 */
namespace Huawei\PushNotifications\PushAdmin\PushMessage\WebPush;

class WebPushHeaders
{
    private $ttl;
    private $topic;
    private $urgency;
    private $fields;

    public function __construct()
    {
        $this->fields = array();
    }

    public function setTtl($value)
    {
        $this->ttl = $value;
    }

    public function setTopic($value)
    {
        $this->topic = $value;
    }

    public function setUrgency($value)
    {
        $this->urgency = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function buildFields()
    {
        $keys = array(
            'ttl',
            'topic',
            'urgency'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }
}
