<?php


namespace BotRuleEngine\Actions;


class NotifyAdminAction extends AbstractAction {

    public static function create() {
        $instance = new NotifyAdminAction();
        return $instance;
    }

    public function execute() {
        if ($this->getEngine()->getRuleFacade()->notifyAdmin() === false) {
            return $this;
        }
        return parent::execute();
    }

}