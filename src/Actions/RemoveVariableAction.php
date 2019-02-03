<?php


namespace BotRuleEngine\Actions;


use BotTemplateFramework\Events\VariableRemovedEvent;

class RemoveVariableAction extends AbstractAction {

    public $variable;

    public $userId;

    public static function create($userId, $variable) {
        $instance = new RemoveVariableAction();
        $instance->userId = $userId;
        $instance->variable = $variable;
        return $instance;
    }

    public function execute() {
        if ($this->getEngine()->getRuleFacade()->removeVariable($this->userId, $this->variable) === false) {
            return $this;
        }
        $this->dispatchEvent(new VariableRemovedEvent($this->variable));
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['variable', 'userId']);
    }

}