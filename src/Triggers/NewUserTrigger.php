<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\RuleEngine;

class NewUserTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('newUserAdded', function(){
            $this->trigger();
        });
    }

}