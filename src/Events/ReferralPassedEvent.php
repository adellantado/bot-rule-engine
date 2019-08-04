<?php


namespace BotRuleEngine\Events;


use BotTemplateFramework\Events\Event;

class ReferralPassedEvent extends Event {

    public $data;

    public function __construct($data) {
        $this->data = $data;
        parent::__construct('referralPassed');
    }

}