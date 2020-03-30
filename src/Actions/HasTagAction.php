<?php


namespace BotRuleEngine\Actions;


class HasTagAction extends AbstractAction {

    public $userId;

    public $tag;

    public static function create($userId, $tag) {
        $instance = new HasTagAction();
        $instance->tag = $tag;
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        $tag = $this->getValue($this->tag);
        if ($this->getEngine()->getRuleFacade()->hasTag($tag, $this->userId) === false) {
            return $this;
        }
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['tag', 'userId']);
    }

}