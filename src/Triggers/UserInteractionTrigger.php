<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\RuleEngine;

class UserInteractionTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('userInteraction', function(){
            $this->trigger();
        });
    }

}