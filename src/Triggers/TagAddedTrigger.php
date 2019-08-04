<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\Events\TagAddedEvent;
use BotRuleEngine\RuleEngine;

class TagAddedTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine, $tag) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('tagAdded', function(TagAddedEvent $event) use ($tag) {
            if ($event->tag == $tag) {
                $this->action->setData($event->tag);
                $this->trigger();
            }
        });
    }

}