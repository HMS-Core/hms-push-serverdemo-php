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
 * function: push message push control parameter:
 *           5 kinds of msg payload:$data,$notification,$android,$apns,$webpush
 *           3 kinds of Message sending object:$token,$topic,$condition
 */
namespace push_admin\push_msg;

class PushMessage
{

    private $data;

    private $notification;

    private $android;

    private $apns;

    private $webpush;

    private $token;

    private $topic;

    private $condition;

    private $fields;

    public function __construct()
    {
        $this->fields = array();
        $this->token = null;
        $this->condition = null;
        $this->topic = null;
        $this->notification = null;
    }

    public function data($value)
    {
        $this->data = $value;
    }

    public function notification($value)
    {
        $this->notification = $value;
    }

    public function android($value)
    {
        $this->android = $value;
    }

    public function token($value)
    {
        $this->token = $value;
    }
    public function get_token(){
        return $this->token;
    }

    public function topic($value)
    {
        $this->topic = $value;
    }

    public function condition($value)
    {
        $this->condition = $value;
    }

    public function apns($value)
    {
        $this->apns = $value;
    }

    public function webpush($value)
    {
        $this->webpush = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function buildFields()
    {
        $keys = array(
            'data',
            'notification',
            'android',
            'token',
            'topic',
            'condition',
            'apns',
            'webpush'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }
}