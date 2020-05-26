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
 * function: WebPushNotification class  =>WebPushConfig(notification)
 *                                      =>PushMessage(webpush)
 */
namespace push_admin\push_msg\webpush;

use Exception;
class WebPushNotification
{

    private $title;
    private $body;
    private $icon;
    private $image;  
    private $lang;
    private $tag;
    private $badge;
    private $dir;   
    private $vibrate;
    private $renotify;

    private $require_interaction;
    private $silent;
    private $timestamp;
    
    private $actions;
    
    private $fields;

    public function __construct()
    {
        $this->actions = array();
        $this->fields = array();     
    }

    public function title($value) {
        $this->title = $value;
    }
    public function body($value) {
        $this->body = $value;
    }
    public function icon($value) {
        $this->icon = $value;
    }
    public function image($value) {
        $this->image = $value;
    }
    public function lang($value) {
        $this->lang = $value;
    }
    public function tag($value) {
        $this->tag = $value;
    }

    public function badge($value) {
        $this->badge = $value;
    }
    
    public function dir($value) {
        $this->dir = $value;
    }
    public function vibrate($value) {
        $this->vibrate = $value;
    }
    public function renotify($value) {
        $this->renotify = $value;
    }
    public function require_interaction($value) {
        $this->require_interaction = $value;
    }
    
    
    public function silent($value) {
        $this->silent = $value;
    }
    public function timestamp($value) {
        $this->timestamp = $value;
    }
    public function actions($value) {
        $this->actions = $value;
    }
    

    public function getFields() {
        return $this->fields;
    }

    public function buildFields() {
        try{
            $this->check_parameter();
        }catch (Exception $e) {
            echo $e;
        }

        $keys = array(
            'title',
            'body',
            'icon',
            'image',
            'lang',
            'tag',
            'badge',
            'dir',
            'vibrate',
            'renotify',  
            'require_interaction',
            'silent',
            'timestamp',
            'actions'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function check_parameter() {
        if (($this->renotify) && (gettype($this->renotify) != "boolean")) {
            throw new Exception("type of renotify is wrong.");
        }
        if (($this->require_interaction) && (gettype($this->require_interaction) != "boolean")) {
            throw new Exception("type of requireInteraction is wrong.");
        }
        if (($this->silent) && (gettype($this->silent) != "boolean")) {
            throw new Exception("type of silent is wrong.");
        }

        
    }

}