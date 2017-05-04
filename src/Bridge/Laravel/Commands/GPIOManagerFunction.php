<?php

namespace ChickenTikkaMasala\GPIO\Bridge\Laravel\Commands;

use ChickenTikkaMasala\GPIO\GPIOManager;
use Illuminate\Console\Command;

/**
 * Class GPIOManagerGet
 * @package ChickenTikkaMasala\GPIO\Bridge\Laravel\Commands
 */
class GPIOManagerFunction extends Command
{
    /**
     * @var string
     */
    public $signature = 'gpio:function {name} {function}';

    /**
     * @var string
     */
    public $description = '';

    /**
     * @param GPIOManager $GPIOManager
     */
    public function handle(GPIOManager $GPIOManager)
    {
        $this->info($GPIOManager->{$this->argument('name')}->{$this->argument('function')}());
    }
}
