<?php

namespace App\Jobs;

//use Exception;
use App\Services\ParseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessingParseCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;
    protected $file;

    /**
     * Create a new job instance.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $parseService = new ParseService();
        try {
            $parseService->parseCSV($this->file);
            Cache::put('processing', false);
        } catch (\Exception $exception) {
            Log::error('Something went wrong ' . $exception->getMessage());
            Cache::put('processing', false);
//            $this->failed($exception->getMessage());
        }
    }

    /**
     * Handle a job failure.
     *
     * @param \Exception $exception
     * @return void
     */
    public function failed($exception)
    {
        Log::error('Something went wrong ' . $exception);
        Cache::put('processing', false);
    }
}
