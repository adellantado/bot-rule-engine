<?php


namespace BotRuleEngine\Actions;


use BotRuleEngine\RuleEngine;
use BotTemplateFramework\Events\Event;

abstract class AbstractAction implements IAction {

    /** @var  IAction */
    public $action;

    public $data;

    /** @var  RuleEngine */
    private $engine;

    public function execute() {
        if ($this->action) {
            $this->action->execute();
        }
        return $this;
    }

    public function next(IAction $action) {
        $this->action = $action;
        $this->action->setEngine($this->engine);
        return $this;
    }

    public function getEngine() {
        return $this->engine;
    }

    public function setEngine(RuleEngine $engine) {
        $this->engine = $engine;
        if ($this->action) {
            $this->action->setEngine($engine);
        }
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function setDataToNext($data) {
        if ($this->action) {
            $this->action->setData($data);
        }
        return $this;
    }

    public function __sleep() {
        $this->action = serialize($this->action);
        return ['action', 'data'];
    }

    public function __wakeup() {
        $this->action = unserialize($this->action);
    }

    protected function dispatchEvent(Event $event) {
        $this->getEngine()->getTemplateEngine()->dispatchEvent($event);
    }

    protected function getValue($value){
        return $this->engine->getValue($value);
    }

}