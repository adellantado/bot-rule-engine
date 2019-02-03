<?php

namespace BotRuleEngine\Events;

use BotTemplateFramework\Events\Event;

class ChatOpenedEvent extends Event {

    public function __construct() {
        parent::__construct('chatOpened');
    }

}