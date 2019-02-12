<?php


namespace BotRuleEngine\Events;


use BotTemplateFramework\Events\Event;

class UserInteractionEvent extends Event {

    public $phrase;

    public function __construct($phrase = null) {
        $this->phrase = $phrase;
        parent::__construct('userInteraction');
    }

}