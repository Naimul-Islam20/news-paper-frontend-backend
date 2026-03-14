<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteAllPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:delete-all
                            {--with-images : Delete post image files from storage too}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all posts and their related data (category links). Use --with-images to also remove image files from storage.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $withImages = $this->option('with-images');
        $count = Post::count();

        if ($count === 0) {
            $this->info('No posts found. Nothing to delete.');
            return self::SUCCESS;
        }

        if (! $this->confirm("Do you really want to delete all {$count} post(s)? This cannot be undone.")) {
            $this->info('Cancelled.');
            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        $posts = Post::all();
        foreach ($posts as $post) {
            if ($withImages && $post->image) {
                try {
                    Storage::disk('public')->delete($post->image);
                } catch (\Throwable) {
                    // ignore missing file
                }
            }
            $post->delete();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Deleted {$count} post(s)." . ($withImages ? ' Image files removed from storage.' : ''));

        return self::SUCCESS;
    }
}
