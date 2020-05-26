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
 * function: ClickAction class  =>AndroidNotification(clickaction)
 *                              =>AndroidConfig(notification)
 *                              =>PushMessage(android)
 */
namespace push_admin\push_msg\android;

include_once (dirname(__FILE__) . '/../ValidatorUtil.php');

use push_admin\ValidatorUtil;

use Exception;

class ClickAction
{

    private $type;

    private $intent;

    private $url;

    private $rich_resource;

    // added
    private $action;

    private $fields;

    public function __construct()
    {
        $this->rich_resource = null;
        $this->url = null;
    }

    public function type($value)
    {
        $this->type = $value;
    }

    public function intent($value)
    {
        $this->intent = $value;
    }

    public function url($value)
    {
        $this->url = $value;
    }

    public function rich_resource($value)
    {
        $this->rich_resource = $value;
    }

    // added
    public function action($value)
    {
        $this->action = $value;
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
            'type',
            'intent',
            'url',
            'rich_resource',
            // add
            'action'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }

    private function check_parameter()
    {
        if (($this->type) && (gettype($this->type) != "integer")) {
            throw new Exception("type of type is wrong.");
        }
        if (!in_array($this->type, array(1,2,3,4))){
            throw new Exception("click type should be one of 1: customize action, 2: open url, 3: open app, 4: open rich media");
        }
        $PATTERN = "/^https.*/";
        switch($this->type){
            case 1:{
                if (is_null($this->intent) && is_null($this->action)) {
                    throw new Exception("when type=1,intent/action at least one is valid");
                }
            }
            break;
            case 2:{
                if (is_null($this->url)){
                    throw new Exception("url is required when click type=2");
                }
                if (FALSE == ValidatorUtil::validatePattern($PATTERN,$this->url)){
                    throw new Exception("url must start with https");
                }
            }
            break;
            case 4:{
                if (is_null($this->richResource)){
                    throw new Exception("richResource is required when click type=4");
                }
                
                if (FALSE == ValidatorUtil::validatePattern($PATTERN,$this->richResource)){
                    throw new Exception("richResource must start with https");
                }
            }
            break;
        }
        
          
      
    }
}