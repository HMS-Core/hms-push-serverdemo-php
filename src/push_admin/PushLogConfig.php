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

namespace push_admin;

include_once (dirname(__FILE__) . './Constants.php');
include_once (dirname(__FILE__) . './PushConfig.php');

use Exception;

class PushLogConfig
{

    private $LogFile;

    private $logBanner = "
    ___ ___  __      __  __________ ____ ___  _________ ___ ___   __________  ___ _____________
    /   |   \/  \    /  \ \______   \    |   \/   _____//   |   \  \______   \/   |   \______   \
    /    ~    \   \/\/   /  |     ___/    |   /\_____  \/    ~    \  |     ___/    ~    \     ___/
    \    Y    /\        /   |    |   |    |  / /        \    Y    /  |    |   \    Y    /    |
    \___|_  /  \__/\  /    |____|   |______/ /_______  /\___|_  /   |____|    \___|_  /|____|
    \/        \/                               \/       \/                    \/          
";

    private $LOG_MODULE_FIXED_LEN = 20;

    private $default_log_level = Constants::HW_PUSH_LOG_INFO_LEVEL;

    private function __construct()
    {        
        $this->LogFile = @fopen(Constants::HW_PUSH_LOG_FILE_NAME, 'a+');
        if (! is_resource($this->LogFile)) {
            throw new Exception(Constants::HW_PUSH_LOG_FILE_NAME . 'invalid file Stream');
        }

        fwrite($this->LogFile, $this->logBanner);

        $pushConfig = PushConfig::getSingleInstance();
        
        $this->default_log_level = $pushConfig->HW_DEFAULT_LOG_LEVEL;
        if (empty($this->default_log_level)){
            $this->default_log_level = Constants::HW_PUSH_LOG_INFO_LEVEL;
        }
    }

    /**
     * single instance
     */
    public static function getSingleInstance()
    {
        static $obj;
        if (! isset($obj)) {
            $obj = new PushLogConfig();
        }
        return $obj;
    }

    /**
     * core log process
     */
    public function LogMessage($msg, $logLevel = Constants::HW_PUSH_LOG_INFO_LEVEL, $module = null, $timeZone = 'Asia/shanghai', $timeFormat = "%Y-%m-%d %H:%M:%S")
    {
        if (empty($logLevel)) {
            $logLevel = Constants::HW_PUSH_LOG_INFO_LEVEL;
        }

        if ($logLevel > $this->default_log_level) {
            return;
        }
        date_default_timezone_set($timeZone);
        $time = strftime($timeFormat, time());
        $msg = str_replace("\t", '', $msg);
        $msg = str_replace("\n", '', $msg);
        $strLogLevel = $this->levelToString($logLevel);
        if (isset($module)) {
            $module = '[' . str_pad(str_replace(array(
                "\n",
                "\t"
            ), array(
                "",
                ""
            ), $module), $this->LOG_MODULE_FIXED_LEN) . ']';
            $logLine = "$time\t$strLogLevel\t$module\t$msg\r\n";
        } else {
            $logLine = "$time\t$strLogLevel\t$msg\r\n";
        }

        print_r($logLine . '<br>');
        fwrite($this->LogFile, $logLine);
    }

    private function levelToString($logLevel)
    {
        $ret = 'LOG::UNKNOWN';
        switch ($logLevel) {
            case Constants::HW_PUSH_LOG_DEBUG_LEVEL:
                $ret = 'LOG::DEBUG';
                break;
            case Constants::HW_PUSH_LOG_INFO_LEVEL:
                $ret = 'LOG::INFO';
                break;
            case Constants::HW_PUSH_LOG_WARN_LEVEL:
                $ret = 'LOG::WARNING';
                break;
            case Constants::HW_PUSH_LOG_ERROR_LEVEL:
                $ret = 'LOG::ERROR';
                break;
        }
        return $ret;
    }
}

