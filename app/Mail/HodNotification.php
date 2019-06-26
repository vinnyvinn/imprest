<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Queue\ShouldQueue;

class HodNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public $data;
     protected $recepient;

    public function __construct($data,$recepient=null)
    {
        //$this
        $this->data = $data;
        $this->recepient=$recepient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $imprest = $this->data->imprest_number;
      $imprest_id =$this->data->id;
      $description = $this->data->nature_of_duty;
      $adv_amount = $this->data->advance_amount;

            if(is_null($this->recepient)){
                return $this->view('emails.hodnotification')->with(['imprestnum' => $imprest,'description' => $description,'amount' => $adv_amount,'imprest_id'=>$imprest_id]);

            }else if($this->recepient=='Admin'){

                return $this->view('emails.admin')->with(['imprestnum' => $imprest,'description' => $description,'amount' => $adv_amount,'imprest_id'=>$imprest_id]);
                
            }else if($this->recepient == 'surrender'){

                return $this->view('emails.usersurrender')->with(['imprestnum' => $imprest,'description' => $description,'amount' => $adv_amount,'imprest_id'=>$imprest_id]);

            }
            else if($this->recepient == 'user'){

                return $this->view('emails.decline')->with(['imprestnum' => $imprest,'description' => $description,'amount' => $adv_amount,'imprest_id'=>$imprest_id]);

            }
            else{
                return $this->view('emails.accounts')->with(['imprestnum' => $imprest,'description' => $description,'amount' => $adv_amount,'imprest_id'=>$imprest_id]);
            }

    }
}
