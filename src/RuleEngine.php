<?php

namespace BotRuleEngine;

use BotRuleEngine\Actions\AddTagAction;
use BotRuleEngine\Actions\CalculateAction;
use BotRuleEngine\Actions\ClearCacheAction;
use BotRuleEngine\Actions\ClearVariablesAction;
use BotRuleEngine\Actions\CloseChatAction;
use BotRuleEngine\Actions\DelayAction;
use BotRuleEngine\Actions\GenerateCheckoutUrlAction;
use BotRuleEngine\Actions\HasNotTagAction;
use BotRuleEngine\Actions\HasTagAction;
use BotRuleEngine\Actions\HasVariableAction;
use BotRuleEngine\Actions\IAction;
use BotRuleEngine\Actions\NotifyAdminAction;
use BotRuleEngine\Actions\OpenChatAction;
use BotRuleEngine\Actions\RemoveTagAction;
use BotRuleEngine\Actions\RemoveVariableAction;
use BotRuleEngine\Actions\SaveVariableAction;
use BotRuleEngine\Actions\SendBlockAction;
use BotRuleEngine\Actions\SendFlowAction;
use BotRuleEngine\Actions\UnsubscribeAction;
use BotRuleEngine\Triggers\BlockExecutedTrigger;
use BotRuleEngine\Triggers\DriverEventTrigger;
use BotRuleEngine\Triggers\ExternalTrigger;
use BotRuleEngine\Triggers\ITrigger;
use BotRuleEngine\Triggers\NewUserTrigger;
use BotRuleEngine\Triggers\PaymentApprovedTrigger;
use BotRuleEngine\Triggers\PaymentFailedTrigger;
use BotRuleEngine\Triggers\TagAddedTrigger;
use BotRuleEngine\Triggers\TagRemovedTrigger;
use BotRuleEngine\Triggers\TimerTrigger;
use BotRuleEngine\Triggers\UserInteractionTrigger;
use BotRuleEngine\Triggers\VariableChangedTrigger;
use BotRuleEngine\Triggers\VariableRemovedTrigger;
use BotTemplateFramework\TemplateEngine;


/**
 * Class RuleEngine
 * @package App
 *
 *  Examples:
 *
"rules": [
    {
        "name": "rule#1",
        "trigger": {"name": "blockExecuted", "block": "EgyptTourBlock"},
        "actions": [
            {"name": "hasTag", "tag": "Traveler"},
            {"name": "addTag", "tag": "Egypt"},
            {"name": "delay", "delay": "1d"},
            {"name": "sendBlock", "block": "EgyptDiscount"}
        ]
    },
    {
        "name": "rule#2",
        "trigger": {"name": "driverEvent", "event": "webhook"},
        "actions": [
            {"name": "notifyAdmin"}
        ]
    },
    {
        "name": "rule#3",
        "trigger": {"name": "newUser"},
        "actions": [
            {"name": "saveVariable", "variable": "userName", "value": "Patrick"},
            {"name": "unsubscribe"}
        ]
    },
    {
        "name": "rule#4",
        "trigger": {"name": "variableChanged", "equation": ["myVariable", ">", "5"]},
        "actions": [
            {"name": "hasVariable", "equation": ["email", "!=", ""]}
            {"name": "delay", "delay": "1d:2h:10m"},
            {"name": "notifyAdmin"}
        ]
    },
    {
        "name": "rule#5",
        "trigger": {"name": "tagAdded", "tag": "Test"},
        "actions": [
            {"name": "notifyAdmin"}
        ]
    },
    {
        "name": "rule#6",
        "trigger": {"name": "tagRemoved", "tag": "Test"},
        "actions": [
            {"name": "hasNotTag", "tag": "Test"},
            {"name": "notifyAdmin"}
        ]
    },
    {
        "name": "rule#7",
        "trigger": {"name": "variableRemoved", "variable": "TestVar"},
        "actions": [
            {"name": "removeVariable", "variable": "TestVar2"},
            {"name": "openChat"},
            {"name": "closeChat"},
            {"name": "removeTag", "tag": "TestTag"}
        ]
    },
    {
        "name": "rule#8",
        "trigger": {"name": "userInteraction", "phrase": "hey there!"},
        "actions": [
            {"name": "notifyAdmin"}
        ]
    },
    {
        "name": "rule#9",
        "trigger": {"name": "paymentApproved"},
        "actions": [
            {"name": "clearVariables"}
        ]
    },
    {
        "name": "rule#10",
        "trigger": {"name": "paymentFailed"},
        "actions": [
            {"name": "clearCache"}
        ]
    },
    {
        "name": "rule#11",
        "trigger": {"name": "timer", "every": "5d | 1w | 1m | once", "time":"3rd 15:24 | Thu 15:24 | 15:24"},
        "actions": [
            {"name": "generateCheckoutUrl", "provider": "fondy", "description": "bike rent payment", "amount": "myVariableWithSum", "variable": "myUrl"}
        ]
    },
    {
        "name": "rule#12",
        "trigger": {"name": "external"},
        "actions": [
            {"name": "calculate", "equation": ["firstVar", "+ | - | * | /", "secondVar", "myVariable"]},
            {"name": "sendFlow", "flow": "EgyptTour"}
        ]
    }
]
 *
 */
class RuleEngine {

    protected $scenario;

    protected $engine;

    protected $facade;

    protected $userId;

    public function __construct(TemplateEngine $engine, IRuleFacade $facade, $userId = null) {
        $this->engine = $engine;
        $this->scenario = $engine->getTemplate();
        $this->facade = $facade;
        $this->userId = $userId;
        $this->parse();
    }

    /**
     * @return TemplateEngine
     */
    public function getTemplateEngine() {
        return $this->engine;
    }

    /**
     * @return IRuleFacade
     */
    public function getRuleFacade() {
        return $this->facade;
    }

    public function getUserId() {
        return $this->userId ?? $this->userId = $this->facade->getUserId($this->engine->getBot());
    }

    protected function parse() {
        if (!array_key_exists('rules', $this->scenario)) {
            return null;
        }

        $trigger = null;
        foreach ($this->scenario['rules'] as $rule) {
            $trigger = $this->getTrigger($rule['trigger']);
            /** @var IAction $lastAction */
            $lastAction = null;
            foreach($rule['actions'] as $index=>$action) {
                $action = $this->getAction($action);
                if ($index == 0) {
                    $trigger->action($action);
                } else {
                    $lastAction->next($action);
                }
                $lastAction = $action;
            }
        }
        return $trigger;
    }

    /**
     * @param $trigger
     * @return ITrigger
     */
    protected function getTrigger($trigger) {
        switch($trigger['name']) {
            case 'blockExecuted':
                return new BlockExecutedTrigger($this, $trigger['block']);
            case 'driverEvent':
                return new DriverEventTrigger($this, $trigger['event']);
            case 'newUser':
                return new NewUserTrigger($this);
            case 'variableChanged':
                return new VariableChangedTrigger($this, $trigger['equation'][0], $trigger['equation'][1], $trigger['equation'][2]);
            case 'tagAdded':
                return new TagAddedTrigger($this, $trigger['tag']);
            case 'tagRemoved':
                return new TagRemovedTrigger($this, $trigger['tag']);
            case 'variableRemoved':
                return new VariableRemovedTrigger($this, $trigger['variable']);
            case 'userInteraction':
                return new UserInteractionTrigger($this, $trigger['phrase'] ?? null);
            case 'paymentApproved':
                return new PaymentApprovedTrigger($this);
            case 'paymentFailed':
                return new PaymentFailedTrigger($this);
            case 'timer':
                return new TimerTrigger($this, $trigger['time'] ?? '08:00', $trigger['every'] ?? 'once');
            case 'external':
                return new ExternalTrigger($this);
        }
        return null;
    }

    /**
     * @param $action
     * @return IAction
     */
    protected function getAction($action) {
        switch($action['name']) {
            case 'delay':
                return DelayAction::create($action['delay']);
            case 'sendBlock':
                return SendBlockAction::create($this->getUserId(), $action['block']);
            case 'sendFlow':
                return SendFlowAction::create($this->getUserId(), $action['flow']);
            case 'notifyAdmin':
                return NotifyAdminAction::create();
            case 'hasTag':
                return HasTagAction::create($this->getUserId(), $action['tag']);
            case 'addTag':
                return AddTagAction::create($this->getUserId(), $action['tag']);
            case 'hasNotTag':
                return HasNotTagAction::create($this->getUserId(), $action['tag']);
            case 'removeTag':
                return RemoveTagAction::create($this->getUserId(), $action['tag']);
            case 'clearVariables':
                return ClearVariablesAction::create($this->getUserId());
            case 'hasVariable':
                return HasVariableAction::create($this->getUserId(), $action['equation'][0], $action['equation'][1], $action['equation'][2]);
            case 'saveVariable':
                return SaveVariableAction::create($this->getUserId(), $action['variable'], $action['value']);
            case 'removeVariable':
                return RemoveVariableAction::create($this->getUserId(), $action['variable']);
            case 'calculate':
                return CalculateAction::create($this->getUserId(), $action['equation'][0], $action['equation'][1], $action['equation'][2], $action['equation'][3]);
            case 'openChat':
                return OpenChatAction::create($this->getUserId());
            case 'closeChat':
                return CloseChatAction::create($this->getUserId());
            case 'unsubscribe':
                return UnsubscribeAction::create($this->getUserId());
            case 'clearCache':
                return ClearCacheAction::create($this->getUserId());
            case 'generateCheckoutUrl':
                return GenerateCheckoutUrlAction::create($this->getUserId(), $action['amount'], $action['provider'], $action['description'], $action['variable'] ?? 'checkoutUrl');
        }
        return null;
    }

}