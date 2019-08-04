<?php

namespace BotRuleEngine\Actions;


use BotRuleEngine\RuleEngine;

interface IAction {

    public function execute();

    public function next(IAction $action);

    public function setEngine(RuleEngine $engine);

    /**
     * @param $data
     * @return IAction
     */
    public function setData($data);

}