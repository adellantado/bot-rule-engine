<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\RuleEngine;

class ExternalTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('external', function(){
            $this->trigger();
        });
    }

}