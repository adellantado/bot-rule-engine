<?php


namespace BotRuleEngine\Actions;


class SendBlockAction extends AbstractAction {

    public $block;

    public $userId;

    public static function create($userId, $block) {
        $instance = new SendBlockAction();
        $instance->block = $block;
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        if ($this->getEngine()->getRuleFacade()->sendBlock($this->userId, $this->block) === false) {
            return $this;
        }
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['block', 'userId']);
    }

}