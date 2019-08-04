<?php


namespace BotRuleEngine\Actions;


class ValidateAction extends AbstractAction {

    public $value;

    public $type;

    public $userId;

    public static function create($userId, $type, $value) {
        $instance = new ValidateAction();
        $instance->userId = $userId;
        $instance->value = $value;
        $instance->type = $type;
        return $instance;
    }

    public function execute() {
        if ($this->value === null) {
            $this->value = $this->data;
        }
        if ($this->getEngine()->getRuleFacade()->validate($this->type, $this->value, $this->userId) === false) {
            return $this;
        }
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['type', 'value', 'userId']);
    }

}