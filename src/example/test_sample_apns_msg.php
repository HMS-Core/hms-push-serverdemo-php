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
 * function: two kinds of method to send apn msg: 
 *              1) sendPushMsgMessageByMsgType(code class object);
 *              2) sendPushMsgRealMessage(text msg)
 *              3) ios format may change,sometimes push msg depends of ios msg format
 */
include_once (dirname(__FILE__) . './push_common/test_sample_push_msg_common.php');
include_once (dirname(__FILE__) . '/../push_admin/Constants.php');
use push_admin\Constants;

$testPushMsgSample = new TestPushMsgCommon();
$testPushMsgSample->sendPushMsgMessageByMsgType(Constants::APN_MSG_TYPE);

$message_arr = array(
    '{
	"token": [*push_token*],
	"apns": {
		"hms_options": {
			"target_user_type": 1
		},
		"payload": {
			"aps": {
				"alert": {
					"title": "hw1 message title",
					"body": "hw message body",
					"action-loc-key": "PLAY"
				},
				"badge": 5
			},
			"acme1": "bar",
			"acme2": ["bang",
			"whiz"]
		}
	}
}',
    '{
	"token": [*push_token*],
	"apns": {
		"hms_options": {
			"target_user_type": 1
		},
		"payload": {
			"aps": {
				"alert": {
					"title": "hw2 message title",
					"body": "hw3 message body",
					"action-loc-key": "PLAY"
				},
				"badge": 5
			},
			"acme1": "bar",
			"acme2": ["bang",
			"whiz"],
            "sound": "default",
            "launch-image": "https://developer-portalres-drcn.dbankcdn.com/system/modules/org.opencms.portal.template.core/resources/images/icon_Promotion.png"
		}
	}
}',
    '{
	"token": [*push_token*],
	"apns": {
		"hms_options": {
			"target_user_type": 1
		},
		"payload":{
            "aps" : {
                "alert" : {
                    "title" : "Game3 Request",
                    "body" : "Bob3 wants to play poker",
                    "action-loc-key" : "PLAY"
                },
                "badge" : 5
            },
            "acme1" : "bar",
            "acme2" : [ "bang",  "whiz" ]
        }
	}
}'
);

foreach ($message_arr as $message) {
    $message=str_ireplace("*push_token*", '"'.$testPushMsgSample->apn_push_token_key.'"',$message);
    $testPushMsgSample->sendPushMsgRealMessage(json_decode($message));
}




