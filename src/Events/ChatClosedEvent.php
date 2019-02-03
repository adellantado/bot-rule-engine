<?php

namespace BotRuleEngine\Events;

use BotTemplateFramework\Events\Event;

class ChatClosedEvent extends Event {

    public function __construct() {
        parent::__construct('chatClosed');
    }

}