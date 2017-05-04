<?php

namespace ChickenTikkaMasla\GPIO\Bridge\Laravel\Commands;

use ChickenTikkaMasla\GPIO\GPIOManager;
use Illuminate\Console\Command;

/**
 * Class GPIOManagerGet
 * @package ChickenTikkaMasla\GPIO\Bridge\Laravel\Commands
 */
class GPIOManagerFunction extends Command
{
    /**
     * @var string
     */
    public $signature = 'gpiomanager:function {name} {function}';

    /**
     * @var string
     */
    public $description = '';

    /**
     *
     */
    public function handle(GPIOManager $GPIOManager)
    {
        $this->info($GPIOManager->{$this->argument('name')}->{$this->argument('function')}());
    }
}