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
 * function: WebPushHmsOptions class  =>WebPushConfig(hms_options)
 *                                    =>PushMessage(webpush)
 */
namespace push_admin\push_msg\webpush;


class WebPushHmsOptions
{    
    private $link;

    private $fields;

    public function __construct()
    {
        $this->fields = array();      
    }

    public function link($value) {
        $this->link = $value;
    }
   
    

    public function getFields() {
        return $this->fields;
    }

    public function buildFields() {


        $keys = array(
            'link'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

  

}