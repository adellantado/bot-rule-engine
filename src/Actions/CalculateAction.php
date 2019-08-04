<?php


namespace BotRuleEngine\Actions;


class CalculateAction extends AbstractAction {

    public $operand1;

    public $operator;

    public $operand2;

    public $result;

    public $userId;

    public static function create($userId, $operand1, $operator, $operand2, $result) {
        $instance = new CalculateAction();
        $instance->operand1 = $operand1;
        $instance->operator = $operator;
        $instance->operand2 = $operand2;
        $instance->result = $result;
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        if ($this->calculate() === false) {
            return $this;
        }
        return parent::execute();
    }

    protected function calculate() {
        $operand1 = $this->getEngine()->getRuleFacade()->hasVariable($this->operand1, $this->userId) == true ?
            $this->getEngine()->getRuleFacade()->getVariable($this->operand1, $this->userId) : $this->operand1;
        $operand2 = $this->getEngine()->getRuleFacade()->hasVariable($this->operand2, $this->userId) == true ?
            $this->getEngine()->getRuleFacade()->getVariable($this->operand2, $this->userId) : $this->operand2;
        $result = 0;
        if ($this->operator == '+') {
            $result = $operand1 + $operand2;
        } elseif ($this->operator == '-') {
            $result = $operand1 - $operand2;
        } elseif ($this->operator == '*') {
            $result = $operand1 * $operand2;
        } elseif ($this->operator == '/') {
            $result = $operand1 / $operand2;
        }
        $this->setDataToNext($result);
        return $this->getEngine()->getRuleFacade()->saveVariable($this->result, $result, $this->userId);
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['operand1', 'operator', 'operand2', 'result', 'userId']);
    }

}