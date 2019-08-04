<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\Events\PaymentFailedEvent;
use BotRuleEngine\RuleEngine;

class PaymentFailedTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('paymentFailed', function(PaymentFailedEvent $event) {
            $this->action->setData($event->payment);
            $this->trigger();
        });
    }

}