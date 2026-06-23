<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use Illuminate\Console\Command;

class DiagnoseAdsCommand extends Command
{
    protected $signature = 'ads:diagnose {slug? : Optional slot slug}';

    protected $description = 'Google/Local ad slot status — live server-এ check করতে';

    public function handle(): int
    {
        $client = google_adsense_client();
        $defaultSlot = google_adsense_default_slot();
        $envEnabled = filter_var(config('app.adsense_frontend', false), FILTER_VALIDATE_BOOL);
        $jsEnabled = google_adsense_frontend_enabled();

        $this->info('Client ID: '.($client ?: '❌ নেই / ভুল format'));
        $this->info('Default Slot: '.($defaultSlot ?: '— (Meta-তে set করুন)'));
        $this->info('GOOGLE_ADSENSE_FRONTEND_ENABLED (.env): '.($envEnabled ? 'true ✓' : 'false ❌'));
        $this->info('AdSense JS লোড হবে: '.($jsEnabled ? 'হ্যাঁ ✓' : 'না ❌ (true করুন + config:clear)'));
        $this->newLine();

        $query = Advertisement::query()->orderBy('slug');
        if ($slug = $this->argument('slug')) {
            $query->where('slug', $slug);
        }

        $rows = [];
        foreach ($query->get() as $ad) {
            $d = $ad->frontAdDebug();
            $rows[] = [
                $ad->slug,
                $d['mode'],
                $ad->hasRunningLocalAd() ? 'হ্যাঁ' : 'না',
                ($ad->google_ad_auto ?? false) ? 'ON' : 'OFF',
                $ad->google_ad_slot ?: ($defaultSlot ?: '—'),
                implode('; ', $d['reasons']),
            ];
        }

        $this->table(
            ['Slug', 'Frontend', 'Local চলছে', 'Auto', 'Slot ID', 'Reasons'],
            $rows
        );

        $googleReady = collect($rows)->where('1', 'Google')->count();
        $empty = collect($rows)->where('1', 'খালি')->count();
        $this->newLine();
        $this->line("Google দেখাবে: {$googleReady} slot | খালি: {$empty} slot");
        if (! $jsEnabled && $googleReady > 0) {
            $this->warn('⚠️  Slot Google-ready কিন্তু JS বন্ধ — .env-এ GOOGLE_ADSENSE_FRONTEND_ENABLED=true এবং php artisan config:clear');
        }
        $this->line('Frontend=Google হলে page source-এ data-ad-slot থাকা উচিত।');

        return self::SUCCESS;
    }
}
