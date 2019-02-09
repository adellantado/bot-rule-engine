<?php


namespace BotRuleEngine\Actions;


class GenerateCheckoutUrlAction extends AbstractAction {

    public $amount;

    public $description;

    public $provider;

    public $variable;

    public $userId;

    public static function create($userId, $amount, $provider, $description, $variable) {
        $instance = new GenerateCheckoutUrlAction();
        $instance->userId = $userId;
        $instance->variable = $variable;
        $instance->amount = $amount;
        $instance->description = $description;
        $instance->provider = $provider;
        return $instance;
    }

    public function execute() {
        $facade = $this->getEngine()->getRuleFacade();
        $url = $facade->getCheckoutUrl($facade->getVariable($this->amount, $this->userId), $this->provider, $this->description, $this->userId);
        if ($url === false) {
            return $this;
        }
        if ($facade->saveVariable($this->variable, $url, $this->userId) === false) {
            return $this;
        }

        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['variable', 'userId', 'description', 'amount', 'provider']);
    }

}