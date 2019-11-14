<?php


namespace BotRuleEngine\Actions;


class SendEmailAction extends AbstractAction {

    public $email;

    public $text;

    public static function create($email, $text) {
        $instance = new SendEmailAction();
        $instance->email = $email;
        $instance->text = $text;
        return $instance;
    }

    public function execute() {
        if ($this->getEngine()->getRuleFacade()->sendEmail($this->email, $this->text) === false) {
            return $this;
        }
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['email', 'text']);
    }

}