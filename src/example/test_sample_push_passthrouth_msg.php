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
 * function: two kinds of method to send passthrough msg: 
 *              1) sendPushMsgMessageByMsgType(code class object);
 *              2) sendPushMsgRealMessage(text msg)
 */
include_once (dirname(__FILE__) . '/push_common/test_sample_push_msg_common.php');
include_once (dirname(__FILE__) . '/../push_admin/Constants.php');
use push_admin\Constants;

$testPushMsgSample = new TestPushMsgCommon();
$testPushMsgSample->sendPushMsgMessageByMsgType(Constants::PUSHMSG_PASS_THROUGHT_MSG_TYPE);

$message_arr = array(
    '{
    	"data": "hw test default data1",
    	"token": [*push_token*]
}',
    '{
    	"data": "k=v,k=v2",
        "android": {
        		"collapse_key": -1,
        		"ttl": "10000s",
        		"bi_tag": "the_sample_bi_tag_for_receipt_service"
         },
    	"token": [*push_token*]
}',
    '{
    	"data": "k=v,k=v",
        "android": {
                "data": "pass through real data3",
        		"collapse_key": -1,
        		"ttl": "10000s",
        		"bi_tag": "the_sample_bi_tag_for_receipt_service"
         },
    	"token": [*push_token*]
}'
);



foreach ($message_arr as $message) {
    $message=str_ireplace("*push_token*", '"'.$testPushMsgSample->hw_push_token_key.'"',$message);
    $testPushMsgSample->sendPushMsgRealMessage(json_decode($message));
}