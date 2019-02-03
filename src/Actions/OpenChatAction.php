<?php


namespace BotRuleEngine\Actions;


use BotRuleEngine\Events\ChatOpenedEvent;

class OpenChatAction extends AbstractAction {

    public $userId;

    public static function create($userId) {
        $instance = new OpenChatAction();
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        if ($this->getEngine()->getRuleFacade()->openChat($this->userId) === false) {
            return $this;
        }
        $this->dispatchEvent(new ChatOpenedEvent());
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['userId']);
    }

}