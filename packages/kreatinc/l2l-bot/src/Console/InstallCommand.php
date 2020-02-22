<?php

namespace Kreatinc\Bot\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class InstallCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Bot resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Bot Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'bot-provider']);
        $this->comment('Publishing Bot Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'bot-config']);
        $this->info('Bot scaffolding installed successfully.');
    }

}
