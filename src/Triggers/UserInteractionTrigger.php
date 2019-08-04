<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\Events\UserInteractionEvent;
use BotRuleEngine\RuleEngine;

class UserInteractionTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine, $phrase) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('userInteraction', function(UserInteractionEvent $event) use ($phrase) {
            if (!$phrase) {
                $this->trigger();
            } elseif ($event->phrase == $this->getValue($phrase)) {
                $this->trigger();
            }
        });
    }

}