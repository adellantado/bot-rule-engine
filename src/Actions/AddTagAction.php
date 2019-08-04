<?php


namespace BotRuleEngine\Actions;


use BotRuleEngine\Events\TagAddedEvent;

class AddTagAction extends AbstractAction {

    public $userId;

    public $tag;

    public static function create($userId, $tag) {
        $instance = new AddTagAction();
        $instance->tag = $tag;
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        if ($this->tag === null) {
            $this->tag = $this->data;
        }
        if ($this->getEngine()->getRuleFacade()->addTag($this->tag, $this->userId) === false) {
            return $this;
        }
        $this->dispatchEvent(new TagAddedEvent($this->tag));
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['userId', 'tag']);
    }

}