<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use Illuminate\Console\Command;

class DiagnoseAdsCommand extends Command
{
    protected $signature = 'ads:diagnose {slug? : Optional slot slug}';

    protected $description = 'Local ad slot status — live server-এ check করতে';

    public function handle(): int
    {
        $this->info('Frontend: শুধু Local ad (Google ad frontend থেকে সরানো)');
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
                implode('; ', $d['reasons']),
            ];
        }

        $this->table(
            ['Slug', 'Frontend', 'Local চলছে', 'Reasons'],
            $rows
        );

        $local = collect($rows)->where('1', 'Local')->count();
        $empty = collect($rows)->where('1', 'খালি')->count();
        $this->newLine();
        $this->line("Local দেখাবে: {$local} slot | খালি: {$empty} slot");

        return self::SUCCESS;
    }
}
