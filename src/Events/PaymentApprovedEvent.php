<?php


namespace BotRuleEngine\Events;


use BotTemplateFramework\Events\Event;

class PaymentApprovedEvent extends Event {

    public $payment;

    public function __construct($payment) {
        $this->payment = $payment;
        parent::__construct('paymentApproved');
    }
}