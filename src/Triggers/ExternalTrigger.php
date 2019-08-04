<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\Events\ExternalEvent;
use BotRuleEngine\RuleEngine;

class ExternalTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('external', function(ExternalEvent $event){
            $this->action->setData($event->data);
            $this->trigger();
        });
    }

}