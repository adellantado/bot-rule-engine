<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\Actions\IAction;
use BotRuleEngine\RuleEngine;

class AbstractTrigger implements ITrigger {

    /** @var  IAction */
    protected $action;

    /** @var  RuleEngine */
    private $engine;

    public function __construct(RuleEngine $engine) {
        $this->engine = $engine;
    }

    public function action(IAction $action) {
        $this->action = $action;
        $this->action->setEngine($this->engine);
        return $this;
    }

    public function trigger() {
        $this->action->execute();
        return $this;
    }

    public function getEngine() {
        return $this->engine;
    }

}