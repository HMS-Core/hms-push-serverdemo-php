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
 * function: fast app,two kinds of method to send instance app msg: 
 *              1) sendPushMsgMessageByMsgType(code class object);
 *              2) sendPushMsgRealMessage(text msg)
 */
include_once (dirname(__FILE__) . '/push_common/test_sample_push_msg_common.php');
include_once (dirname(__FILE__) . '/../push_admin/Constants.php');
use push_admin\Constants;

$testPushMsgSample = new TestPushMsgCommon();
$testPushMsgSample->sendPushMsgMessageByMsgType(Constants::PUSHMSG_FASTAPP_MSG_TYPE);


$message = '{
	"data": "{\"pushtype\":1,\"pushbody\":{\"messageId\":\"111110001\",\"data\":\"test pass-through msg\"}}",
	"ssss":"{k1:v1}",
	"android": {
		"collapse_key": -1,
		"urgency": "HIGH",
		"ttl": "1448s",
		"bi_tag": "Trump",
		"fast_app_target": 1
	},
	"token": [
		*push_token*
		]
}';


$message=str_ireplace("*push_token*", '"'.$testPushMsgSample->fast_push_token.'"',$message);
$testPushMsgSample->sendPushMsgRealMessage(json_decode($message),Constants::PUSHMSG_FASTAPP_MSG_TYPE);

