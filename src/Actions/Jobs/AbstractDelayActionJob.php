<?php

namespace BotRuleEngine\Actions\Jobs;

use BotRuleEngine\Actions\IAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AbstractDelayActionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
    use SerializesModels {
        __sleep as __sleepTrait;
        __wakeup as __wakeupTrait;
    }

    /** @var IAction */
    public $next;

    /**
     * Create a new job instance.
     *
     */
    public function __construct(IAction $next)
    {
        $this->next = $next;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->next) {
            $this->next->setEngine($this->initEngine());
            $this->next->execute();
        }
    }

    protected function initEngine() {
        throw new \Exception('Override "initEngine" method');
        return null;
    }

    public function __sleep() {
        $this->next = serialize($this->next);
        $res = $this->__sleepTrait();
        return $res;
    }

    public function __wakeup() {
        $this->__wakeupTrait();
        $this->next = unserialize($this->next);
    }
}
