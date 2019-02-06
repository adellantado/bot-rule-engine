<?php


namespace BotRuleEngine\Actions;


class ClearCacheAction extends AbstractAction {

    public $userId;

    public static function create($userId) {
        $instance = new ClearCacheAction();
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        if ($this->getEngine()->getRuleFacade()->clearCache($this->userId) === false) {
            return $this;
        }
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['userId']);
    }

}