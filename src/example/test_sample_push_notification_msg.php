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
 * function: two kinds of method to send notification msg: 
 *              1) sendPushMsgMessageByMsgType(code class object);
 *              2) sendPushMsgRealMessage(text msg)
 */
include_once (dirname(__FILE__) . './push_common/test_sample_push_msg_common.php');
include_once (dirname(__FILE__) . '/../push_admin/Constants.php');
use push_admin\Constants;

$testPushMsgSample = new TestPushMsgCommon();
$testPushMsgSample->sendPushMsgMessageByMsgType(Constants::PUSHMSG_NOTIFICATION_MSG_TYPE);



$message_arr = array(
    '{
	"notification": {
		"title": "Big News1",
		"body": "This is a Big News!",
		"image": "https://res.vmallres.com/pimages//common/config/logo/SXppnESYv4K11DBxDFc2_0.png"
	},
	"android": {
		"notification": {
			"click_action": {
				"type": 1,
				"intent": "#Intent;compo=com.rvr/.Activity;S.W=U;end"
			}
    
		}
	},
	"token": [*push_token*]
}',
    '{
	"notification": {
		"title": "Big News",
		"body": "This is a Big News!",
		"image": "https://res.vmallres.com/pimages//common/config/logo/SXppnESYv4K11DBxDFc2_0.png"
	},
	"android": {
		"notification": {
            "title": " real notification default hw title notification2 ",
			"body": " real notification default hw body notification ",
			"color": "#AACCDD",
			"click_action": {
				"type": 1,
				"intent": "#Intent;compo=com.rvr/.Activity;S.W=U;end"
			}
    
		}
	},
	"token": [*push_token*]
}'
);

foreach ($message_arr as $message) {
    $message=str_ireplace("*push_token*", '"'.$testPushMsgSample->hw_push_token_key.'"',$message);
    $testPushMsgSample->sendPushMsgRealMessage(json_decode($message));
}