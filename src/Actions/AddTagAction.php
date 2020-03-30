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
            $tag = $this->data;
        } else {
            $tag = $this->getValue($this->tag);
        }

        if ($this->getEngine()->getRuleFacade()->addTag($tag, $this->userId) === false) {
            return $this;
        }
        $this->dispatchEvent(new TagAddedEvent($tag));
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['userId', 'tag']);
    }

}