<?php


namespace BotRuleEngine\Actions;


use BotRuleEngine\Events\ChatClosedEvent;

class CloseChatAction extends AbstractAction {

    public $userId;

    public static function create($userId) {
        $instance = new CloseChatAction();
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        if ($this->getEngine()->getRuleFacade()->closeChat($this->userId) === false) {
            return $this;
        }
        $this->dispatchEvent(new ChatClosedEvent());
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['userId']);
    }

}