<?php


namespace BotRuleEngine\Events;


use BotTemplateFramework\Events\Event;

class UserInteractionEvent extends Event {

    public function __construct() {
        parent::__construct('userInteraction');
    }

}