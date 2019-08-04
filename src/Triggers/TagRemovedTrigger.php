<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\Events\TagRemovedEvent;
use BotRuleEngine\RuleEngine;

class TagRemovedTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine, $tag) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addEventListener('tagRemoved', function(TagRemovedEvent $event) use ($tag) {
            if ($event->tag == $tag) {
                $this->action->setData($event->tag);
                $this->trigger();
            }
        });
    }

}