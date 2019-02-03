<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\RuleEngine;

class DriverEventTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine, $event) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->getBot()->on($event, function(){
            $this->trigger();
        });
    }

}