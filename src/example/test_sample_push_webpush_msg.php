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
 * function: two kinds of method to send webpush msg: 
 *              1) sendPushMsgMessageByMsgType(code class object);
 *              2) sendPushMsgRealMessage(text msg)
 */
include_once (dirname(__FILE__) . './push_common/test_sample_push_msg_common.php');
include_once (dirname(__FILE__) . '/../push_admin/Constants.php');
use push_admin\Constants;

$testPushMsgSample = new TestPushMsgCommon();
$testPushMsgSample->sendPushMsgMessageByMsgType(Constants::WEB_PUSH_MSG_TYPE);

$message_arr = array('{
	"token": [*push_token*],
	"webpush": {
		"headers": {
			"ttl": "990",
			"topic": "12313ceshi",
			"urgency": "very-low"
		},
		"data": "test webpush data",
		"notification": {
			"title": "web2 push title test",
			"body": "web2 push body",
			"icon": "https://developer-portalres-drcn.dbankcdn.com/system/modules/org.opencms.portal.template.core/resources/images/icon_Promotion.png",
			"image": "https://developer-portalres-drcn.dbankcdn.com/system/modules/org.opencms.portal.template.core/resources/images/icon_Promotion.png",
			"lang": "string",
			"tag": "string",
			"badge": "string",
			"dir": "auto",
			"vibrate": [1,
			2,
			3],
			"renotify": false,
			"require_interaction": false,
			"silent": false,
			"timestamp": 1545201266,
			"actions": [{
				"title": "string",
				"icon": "https://developer-portalres-drcn.dbankcdn.com/system/modules/org.opencms.portal.template.core/resources/images/icon_Promotion.png",
				"action": "123"
			}]
		},
		"hms_options": {
			"link": "https://www.cctv.com/"
		}
	}
}',
    '{
	"token": [*push_token*],
	"webpush": {
        "headers": {
			"ttl": "11990",
			"topic": "test",
			"urgency": "low"
		},
		"data": "test webpush data",
		"notification": {
			"title": "hw default web push title test",
			"body": "hw default web push body",
			"require_interaction": false,
			"silent": false,
			"timestamp": 1545201266,
			"actions": [{
				"title": "string",
				"icon": "https://developer-portalres-drcn.dbankcdn.com/system/modules/org.opencms.portal.template.core/resources/images/icon_Promotion.png",
				"action": "123"
			}]
		},
		"hms_options": {
			"link": "https://www.huawei.com/"
		}
	}
}'
);
 
foreach ($message_arr as $message) {
    $message=str_ireplace("*push_token*", '"'.$testPushMsgSample->webpush_push_token_key.'"',$message);
    $testPushMsgSample->sendPushMsgRealMessage(json_decode($message));
}
