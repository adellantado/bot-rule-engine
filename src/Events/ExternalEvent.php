<?php


namespace BotRuleEngine\Events;


use BotTemplateFramework\Events\Event;

class ExternalEvent extends Event {

    public $data;

    public function __construct($data) {
        $this->data = $data;
        parent::__construct('external');
    }

}