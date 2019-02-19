<?php


namespace BotRuleEngine;


use BotRuleEngine\Actions\IAction;
use BotMan\BotMan\BotMan;

interface IRuleFacade {

    /**
     * @param BotMan $bot
     * @return mixed
     */
    public function getUserId(BotMan $bot);

    /**
     * @param $tag
     * @param $userId
     * @return boolean
     */
    public function hasTag($tag, $userId);

    /**
     * @param $tag
     * @param $userId
     * @return boolean
     */
    public function addTag($tag, $userId);

    /**
     * @param $tag
     * @param $userId
     * @return boolean
     */
    public function removeTag($tag, $userId);

    /**
     * @param $userId
     * @return mixed
     */
    public function closeChat($userId);

    /**
     * @param $userId
     * @return mixed
     */
    public function openChat($userId);

    /**
     * @param IAction $action
     * @param $delay
     * @return mixed
     */
    public function delay(IAction $action, $delay);

    /**
     * @param $userId
     * @param $blockName
     * @return boolean
     */
    public function sendBlock($userId, $blockName);

    /**
     * @param $userId
     * @param $flowName
     * @return boolean
     */
    public function sendFlow($userId, $flowName);

    /**
     * @param $userId
     * @return boolean
     */
    public function unsubscribe($userId);

    /**
     * @param $userId
     * @param $variable
     * @return boolean
     */
    public function removeVariable($userId, $variable);

    /**
     * @param $variable
     * @param $value
     * @param $userId
     * @return mixed
     */
    public function saveVariable($variable, $value, $userId);

    /**
     * @param $variable
     * @param $userId
     * @return mixed
     */
    public function getVariable($variable, $userId);

    /**
     * @param $variable
     * @param $userId
     * @return boolean
     */
    public function hasVariable($variable, $userId);

    /**
     * @param $userId
     * @return boolean
     */
    public function clearVariables($userId);

    /**
     * @param $userId
     * @return boolean
     */
    public function clearCache($userId);

    /**
     * @return mixed
     */
    public function notifyAdmin();

    /**
     * @return \DateTime
     */
    public function getLastTimerRan();

    /**
     * @param \DateTime $date
     * @return mixed
     */
    public function saveLastTimerRan(\DateTime $date);

    /**
     * @param $amount
     * @param $provider
     * @param $description
     * @param $userId
     * @return string
     */
    public function getCheckoutUrl($amount, $provider, $description, $userId);

}