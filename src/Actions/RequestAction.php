<?php


namespace BotRuleEngine\Actions;


class RequestAction extends AbstractAction {

    public $postData;

    public $url;

    public $method;

    public $userId;

    public static function create($userId, $url, $data, $method = 'post') {
        $instance = new RequestAction();
        $instance->userId = $userId;
        $instance->method = $method;
        $instance->url = $url;
        $instance->postData = $data;
        return $instance;
    }

    public function execute() {
        if ($this->postData === null) {
            $this->postData = $this->data;
        }
        $this->postData = $this->getValue($this->postData);
        if ($this->getEngine()->getRuleFacade()->sendRequest($this->url, $this->method, $this->postData, $this->userId) === false) {
            return $this;
        }
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['postData', 'url', 'method', 'userId']);
    }

}