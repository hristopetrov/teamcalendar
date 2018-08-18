<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class WelcomeWithPass extends Mailable
{
    use Queueable, SerializesModels;

	/**
     * The password unhashed.
     *
     * @var obj
     */
    public $user;
    
    /**
     * The password unhashed.
     *
     * @var string
     */
    public $password;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $pass)
    {
        $this->user = $user;
        $this->password = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.welcome_pass')
        			->subject('Welcome to the team');
    }
}
