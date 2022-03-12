<?php

namespace Huawei\PushNotifications\PushAdmin;

class ApnConstant
{
    //APN PRIORITY
    const ANP_PRIORITY_SEND_IMMEDIATELY = "10";
    const ANP_PRIORITY_SEND_BY_GROUP = "5";

    //APN TARGET USER
    const APN_TARGET_USER_TEST_USER = 1;
    const APN_TARGET_USER_FORMAL_USER = 2;
    const APN_TARGET_USER_VOIP_USER = 3;
}
