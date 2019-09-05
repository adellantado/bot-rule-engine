<?php

namespace BotRuleEngine\Triggers;

use BotRuleEngine\RuleEngine;

class BlockExecutedTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine, $blockName, $capturingPhase = false) {
        parent::__construct($engine);
        $engine->getTemplateEngine()->addBlockListener($blockName, function(){
            $this->trigger();
        }, (boolean)$capturingPhase);
    }

}