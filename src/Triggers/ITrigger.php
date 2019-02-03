<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\Actions\IAction;

interface ITrigger {

    public function action(IAction $action);

}