<?php


namespace BotRuleEngine\Actions;


class SendEmailAction extends AbstractAction {

    public $email;

    public $text;

    public $title;

    public static function create($email, $text, $title) {
        $instance = new SendEmailAction();
        $instance->email = $email;
        $instance->text = $text;
        $instance->title = $title;
        return $instance;
    }

    public function execute() {
        $email = $this->getEngine()->getValue($this->email);
        $text = $this->getEngine()->getValue($this->text);
        $title = $this->getEngine()->getValue($this->title);
        if ($this->getEngine()->getRuleFacade()->sendEmail($email, $text, $title) === false) {
            return $this;
        }
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['email', 'text', 'title']);
    }

}