<?php


namespace BotRuleEngine\Actions;


class HasVariableAction extends AbstractAction {

    public $variable;

    public $operator;

    public $value;

    public $userId;

    public static function create($userId, $variable, $operator, $value) {
        $instance = new HasVariableAction();
        $instance->variable = $variable;
        $instance->operator = $operator;
        $instance->value = $value;
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        if ($this->checkVariable() === false) {
            return $this;
        }
        return parent::execute();
    }

    protected function checkVariable() {
        $value = $this->getEngine()->getRuleFacade()->getVariable($this->variable, $this->userId);
        if (
            ($this->operator == '==' && $value == $this->value) ||
            ($this->operator == '!=' && $value != $this->value) ||
            ($this->operator == '>'  && $value > $this->value) ||
            ($this->operator == '<'  && $value < $this->value) ||
            ($this->operator == '>=' && $value >= $this->value) ||
            ($this->operator == '<=' && $value <= $this->value)
        ) {
            return true;
        }
        return false;
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['variable', 'operator', 'value', 'userId']);
    }

}