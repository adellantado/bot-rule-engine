<?php


namespace BotRuleEngine\Actions;


class SendFlowAction extends AbstractAction {

    public $flow;

    public $userId;

    public static function create($userId, $flow) {
        $instance = new SendFlowAction();
        $instance->flow = $flow;
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        if ($this->flow === null) {
            $this->flow = $this->data;
        }
        if ($this->getEngine()->getRuleFacade()->sendFlow($this->userId, $this->flow) === false) {
            return $this;
        }
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['flow', 'userId']);
    }

}