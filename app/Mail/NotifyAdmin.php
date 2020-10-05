<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Import;

class NotifyAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * the imported file
     *
     * @var Import
     */
    protected $import;

    /**
     * Create a new message instance.
     * @param Import $import
     *
     * @return void
     */
    public function __construct(Import $import)
    {
        $this->import = $import;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('notifyAdmin')
                    ->with('import', $this->import);
    }
}
