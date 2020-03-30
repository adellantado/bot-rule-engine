<?php


namespace BotRuleEngine\Actions;


use BotRuleEngine\Events\TagRemovedEvent;

class RemoveTagAction extends AbstractAction {

    public $userId;

    public $tag;

    public static function create($userId, $tag) {
        $instance = new RemoveTagAction();
        $instance->tag = $tag;
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        if ($this->tag === null) {
            $tag = $this->data;
        } else {
            $tag = $this->getValue($this->tag);
        }
        if ($this->getEngine()->getRuleFacade()->removeTag($tag, $this->userId) === false) {
            return $this;
        }
        $this->dispatchEvent(new TagRemovedEvent($tag));
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['userId', 'tag']);
    }

}