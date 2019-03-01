<?php


namespace BotRuleEngine\Actions;


class NotifyAdminAction extends AbstractAction {

    public $email;

    public $userId;

    public static function create($email = null, $userId = null) {
        $instance = new NotifyAdminAction();
        $instance->email = $email;
        $instance->userId = $userId;
        return $instance;
    }

    public function execute() {
        if ($this->getEngine()->getRuleFacade()->notifyAdmin($this->email, $this->userId) === false) {
            return $this;
        }
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['email', 'userId']);
    }

}