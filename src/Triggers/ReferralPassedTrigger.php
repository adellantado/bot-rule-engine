<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\Events\ReferralPassedEvent;
use BotRuleEngine\RuleEngine;

class ReferralPassedTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine) {
        parent::__construct($engine);
        if ($engine->getTemplateEngine()->getDriverName() == 'viber') {
            $engine->getTemplateEngine()->getBot()->on('conversation_started', function($payload, $bot){
                $this->action->setData($payload['context'] ?? null);
                $this->trigger();
            });
        } elseif ($engine->getTemplateEngine()->getDriverName() == 'facebook') {
            $engine->getTemplateEngine()->getBot()->on('messaging_referrals', function($payload, $bot) use ($engine){
                $this->action->setData($payload['referral']['ref'] ?? null);
                $this->trigger();
            });
            $engine->getTemplateEngine()->getBot()->hears('GET_STARTED', function($bot) use ($engine){
                $payload = $bot->getMessage()->getPayload();
                $this->action->setData($payload['postback']['referral']['ref'] ?? null);
                $this->trigger();
            });
        } elseif ($engine->getTemplateEngine()->getDriverName() == 'telegram') {
            $engine->getTemplateEngine()->getBot()->hears('/start {ref}', function($bot, $ref) use ($engine){
                $this->action->setData($ref ?? null);
                $this->trigger();
            });
        } else {
            $engine->getTemplateEngine()->addEventListener('referralPassed', function(ReferralPassedEvent $event) {
                $this->action->setData($event->data);
                $this->trigger();
            });
        }

    }

}