<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\RuleEngine;
use BotTemplateFramework\Events\VariableRemovedEvent;

class VariableRemovedTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine, $variable) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('variableRemoved', function(VariableRemovedEvent $event) use ($variable) {
            if ($event->variable == $variable) {
                $this->action->setData($event->variable);
                $this->trigger();
            }
        });
    }

}