<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\Events\NewUserAddedEvent;
use BotRuleEngine\RuleEngine;

class NewUserTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('newUserAdded', function(NewUserAddedEvent $event){
            $this->action->setData($event->client);
            $this->trigger();
        });
    }

}