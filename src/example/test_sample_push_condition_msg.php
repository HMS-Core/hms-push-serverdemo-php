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
 * function: two kinds of method to send condition msg: sendPushTopicMsgMessage fro subscribe topic
 *              1) sendPushMsgMessageByMsgType(code class object);
 *              2) sendPushMsgRealMessage(text msg)
 *              3) topic and condition not real time, maybe delay
 */
include_once (dirname(__FILE__) . '/push_common/test_sample_push_msg_common.php');
include_once (dirname(__FILE__) . '/../push_admin/Constants.php');
use push_admin\Constants;

$testPushMsgSample = new TestPushMsgCommon();

$testPushMsgSample->sendPushMsgMessageByMsgType(Constants::PUSHMSG_CONDITION_MSG_TYPE);

$message = '{
	"android": {
		"collapse_key": -1,
		"urgency": "HIGH",
		"ttl": "1448s",
		"bi_tag": "Trump",
		"notification": {
			"title": " condition1 default hw title condition ",
			"body": " condition1 default hw body condition ",
			"color": "#AACCDD",
			"tag": "tagBoom",
			"click_action": {
				"type": 1,
				"intent": "#Intent;compo=com.rvr\/.Activity;S.W=U;end",
				"rich_resource": "test rich resource",
				"action": "test add"
			},
			"body_loc_key": "M.String.body",
			"body_loc_args": ["Boy",
			"Dog"],
			"title_loc_key": "M.String.title",
			"title_loc_args": ["Girl",
			"Cat"],
			"channel_id": "RingRing",
			"notify_summary": "Some Summary",
			"style": 0,
			"big_title": "Big Boom Title",
			"big_body": "Big Boom Body",
			"auto_clear": 86400000,
			"notify_id": 486,
			"group": "Espace",
			"badge": {
				"add_num": 99,
				"class": "Classic",
				"set_num": 99
			},
			"ticker": "i am a ticker",
			"auto_cancel": false,
			"when": "2019-11-05",
			"importance": "NORMAL",
			"use_default_vibrate": true,
			"use_default_light": false,
			"vibrate_config": ["1.5",
			"2.000000001",
			"3"],
			"visibility": "PUBLIC",
			"light_settings": {
				"color": {
					"alpha": 0,
					"red": 0,
					"green": 1,
					"blue": 1
				},
				"light_on_duration": "3.5",
				"light_off_duration": "5S"
			},
			"foreground_show": true
		}
	},
	"condition": *condition*
}';

$topic = '111';
$message=str_ireplace("*condition*", '"\''.$topic.'\' in topics"',$message);

$testPushMsgSample->sendPushMsgRealMessage(json_decode($message));

