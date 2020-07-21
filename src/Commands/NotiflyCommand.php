<?php

namespace Piscibus\Notifly\Commands;

use Illuminate\Console\Command;

class NotiflyCommand extends Command
{
    public $signature = 'notifly';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
