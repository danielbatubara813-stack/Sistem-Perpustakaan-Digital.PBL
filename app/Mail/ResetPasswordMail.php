<?php

namespace App\Mail;

use App\Models\Anggota;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $anggota;
    public $url;

    public function __construct(Anggota $anggota, $url)
    {
        $this->anggota = $anggota;
        $this->url = $url;
    }

    public function build()
    {
        return $this
            ->subject('Reset Password Akun')
            ->view('emails.reset-password');
    }
}