<?php


namespace BotRuleEngine\Actions;


class HasNotTagAction extends AbstractAction {

    public $userId;

    public $tag;

    public static function create($userId, $tag) {
        $instance = new HasNotTagAction();
        $instance->tag = $tag;
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        $tag = $this->getValue($this->tag);
        if ($this->getEngine()->getRuleFacade()->hasTag($tag, $this->userId) === false) {
            return parent::execute();
        }
        return $this;
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['tag', 'userId']);
    }

}