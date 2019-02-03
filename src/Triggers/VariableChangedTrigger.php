<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\RuleEngine;
use BotTemplateFramework\Events\VariableChangedEvent;

class VariableChangedTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine, $variable, $operator, $value) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('variableChanged', function(VariableChangedEvent $event) use ($variable, $operator, $value) {
            if ($event->variable == $variable) {
                if (
                    ($operator == '==' && $event->value == $value) ||
                    ($operator == '!=' && $event->value != $value) ||
                    ($operator == '>'  && $event->value > $value) ||
                    ($operator == '<'  && $event->value < $value) ||
                    ($operator == '>=' && $event->value >= $value) ||
                    ($operator == '<=' && $event->value <= $value)
                ) {
                    $this->trigger();
                }
            }
        });
    }

}