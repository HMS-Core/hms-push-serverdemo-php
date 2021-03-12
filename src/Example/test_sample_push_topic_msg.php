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
 * function: two kinds of method to send topic msg: sendPushTopicMsgMessage for subscribe topic
 *              1) sendPushMsgMessageByMsgType(code class object);
 *              2) sendPushMsgRealMessage(text msg)
 *              3) topic and condition not real time, maybe delay
 */
use Huawei\PushNotifications\PushAdmin\Constants;
use Huawei\Example\PushCommon\TestPushMsgCommon;

$testPushMsgSample = new TestPushMsgCommon();

$topicSubscribeFlag = true;
$topic = '111';

//first time,must subscribe then could receive push msg;
if ($topicSubscribeFlag == false) {
    $testPushMsgSample->sendPushTopicMsgMessage($topic);
}

$testPushMsgSample->sendPushMsgMessageByMsgType(Constants::PUSHMSG_TOPIC_MSG_TYPE, $topic);

$message_arr = array('{
	"data": "1111",
	"android": {
		"notification": {
			"title": " topic1 default hw title  topic ",
			"body": " topic1 default hw body topic ",
			"color": "#AACCDD",
			"tag": "tagBoom",
			"click_action": {
				"type": 1,
				"intent": "#Intent;compo=com.rvr\/.Activity;S.W=U;end",
				"rich_resource": "test rich resource",
				"action": "test add"
			}
		}
	},
	"topic": *topic*
}','{
	"data": "1111",
	"android": {
		"notification": {
			"title": " topic2 default hw title  topic ",
			"body": " topic2 default hw body topic ",
			"click_action": {
				"type": 1,
				"intent": "#Intent;compo=com.rvr\/.Activity;S.W=U;end"
			}
		}
	},
	"topic": *topic*
}');

foreach ($message_arr as $message) {
    $message=str_ireplace("*topic*", '"'.$topic.'"', $message);
    $testPushMsgSample->sendPushMsgRealMessage(json_decode($message));
}
