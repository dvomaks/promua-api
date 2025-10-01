<?php

namespace Dvomaks\PromuaApi\Commands;

use Illuminate\Console\Command;

class PromuaApiCommand extends Command
{
    public $signature = 'promua-api';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
