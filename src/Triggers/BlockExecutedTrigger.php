<?php

namespace BotRuleEngine\Triggers;

use BotRuleEngine\RuleEngine;

class BlockExecutedTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine, $blockName) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addBlockListener($blockName, function(){
            $this->trigger();
        });
    }

}