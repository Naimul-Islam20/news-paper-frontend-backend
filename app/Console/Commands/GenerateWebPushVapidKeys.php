<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minishlink\WebPush\VAPID;

class GenerateWebPushVapidKeys extends Command
{
    protected $signature = 'webpush:vapid';

    protected $description = 'Generate VAPID keys for browser push notifications (.env এ যোগ করুন)';

    public function handle(): int
    {
        $keys = VAPID::createVapidKeys();

        $this->newLine();
        $this->info('Add these lines to your .env file:');
        $this->newLine();
        $this->line('WEBPUSH_ENABLED=true');
        $this->line('VAPID_PUBLIC_KEY=' . $keys['publicKey']);
        $this->line('VAPID_PRIVATE_KEY=' . $keys['privateKey']);
        $this->line('VAPID_SUBJECT=' . config('app.url'));
        $this->newLine();
        $this->comment('Then run: php artisan config:clear && php artisan migrate');

        return self::SUCCESS;
    }
}
