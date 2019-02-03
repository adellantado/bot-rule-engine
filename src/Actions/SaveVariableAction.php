<?php


namespace BotRuleEngine\Actions;


use BotTemplateFramework\Events\VariableChangedEvent;

class SaveVariableAction extends AbstractAction {

    public $variable;

    public $value;

    public $userId;

    public static function create($userId, $variable, $value) {
        $instance = new SaveVariableAction();
        $instance->userId = $userId;
        $instance->variable = $variable;
        $instance->value = $value;
        return $instance;
    }

    public function execute() {
        if ($this->getEngine()->getRuleFacade()->saveVariable($this->variable, $this->value, $this->userId) === false) {
            return $this;
        }
        $this->dispatchEvent(new VariableChangedEvent($this->variable, $this->value));
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['variable', 'value', 'userId']);
    }

}