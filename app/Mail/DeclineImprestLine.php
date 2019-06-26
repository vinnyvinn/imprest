<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeclineImprestLine extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $type;
    public $data;
    public $line;
    public function __construct($data,$line= null,$type = null)
    {
        
        $this->type = $type;
        $this->data = $data;
        $this->line = $line;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   

        if($this->type == 'partial'){
        $imprest = $this->data->imprest_number;
        $description = $this->line->description;
        $amount = $this->line->amount;
        return $this->view('emails.declineLine')->with(['imprest' => $imprest,'description' => $description,'amount' => $amount]); 

        }else{
        $imprest = $this->data->imprest_number;
        $description = $this->data->nature_of_duty;
        $amount = $this->data->advance_amount;
        return $this->view('emails.imprestdecline')->with(['imprest' => $imprest,'description' => $description,'amount' => $amount]); 
        }
    }
}
