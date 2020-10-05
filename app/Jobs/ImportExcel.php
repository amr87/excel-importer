<?php

namespace App\Jobs;

use App\Book;
use App\Import;
use App\Mail\NotifyAdmin;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;

class ImportExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * sheet data
     *
     * @var [array]
     */
    protected $data;

    /**
     * import file
     *
     * @var Import
     */
    protected $import;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $importFile)
    {
        $this->data = $data;
        $this->import = $importFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $success = 0;
        $failed  = 0;

        foreach ($this->dataGenerator() as $data) {
            try {
                Book::create($data);
                $success++;
            } catch (QueryException $e) {
                $failed++;
            }
        }
       
        $now = Carbon::now();
        $duration =  Carbon::parse($this->import->startedAt)->diffInSeconds($now);
        $this->import->update([
            'inserted' => $success,
            'failed'   => $failed,
            'endedAt'  => $now,
            'duration' => $duration
        ]);

        // * notify admin
       
        Mail::to('amr.gamal878@gmail.com')->send(new NotifyAdmin($this->import));
    }

    private function dataGenerator()
    {
        foreach ($this->data as $item) {
            yield $item;
        }
    }
}
