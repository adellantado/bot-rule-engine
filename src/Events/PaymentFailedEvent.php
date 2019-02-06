<?php


namespace BotRuleEngine\Events;


use BotTemplateFramework\Events\Event;

class PaymentFailedEvent extends Event {

    public $payment;

    public function __construct($payment) {
        $this->payment = $payment;
        parent::__construct('paymentFailed');
    }
}