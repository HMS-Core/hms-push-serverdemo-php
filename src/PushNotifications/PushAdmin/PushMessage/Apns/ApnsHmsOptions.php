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

namespace Huawei\PushNotifications\PushAdmin\PushMessage\Apns;

use Exception;

class ApnsHmsOptions
{
    private $targetUserType;
    private $fields;
    
    public function getFields()
    {
        return $this->fields;
    }

    public function setTargetUserType($value)
    {
        $this->targetUserType = $value;
    }

    public function buildFields()
    {
        try {
            $this->checkParameter();
        } catch (Exception $e) {
            echo $e;
        }
        $keys = array(
            'targetUserType'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }
    
    private function checkParameter()
    {
        if (!empty($this->targetUserType)
            && !in_array($this->targetUserType, array(1,2,3))) {
            throw new Exception("target_user_type range TEST_USER:1,FORMAL_USER:2,VOIP_USER:3");
        }
    }
}
