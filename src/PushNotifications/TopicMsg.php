<?php

declare(strict_types=1);

namespace Huawei\PushNotifications;

class TopicMsg
{
    // mandatory
    private $topic;

    // mandatory
    private $tokenArray;

    private $fields = array();

    public function setTopic($value)
    {
        $this->topic = $value;
    }

    public function setTokenArray($value)
    {
        $this->tokenArray = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function buildFields()
    {
        $keys = array(
            'topic',
            'tokenArray'
        );
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                $this->fields[$key] = $this->$key;
            }
        }
    }
}
