<?php

namespace BotRuleEngine\Events;

use BotTemplateFramework\Events\Event;

class TagAddedEvent extends Event {

    public $tag;

    public function __construct($tag) {
        $this->tag = $tag;
        parent::__construct('tagAdded');
    }

}