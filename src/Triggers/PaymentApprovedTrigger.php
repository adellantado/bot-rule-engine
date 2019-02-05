<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\Events\PaymentApprovedEvent;
use BotRuleEngine\RuleEngine;

class PaymentApprovedTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('paymentApproved', function(PaymentApprovedEvent $event) {
            $this->trigger();
        });
    }

}