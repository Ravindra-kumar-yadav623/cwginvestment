<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WalletTransferSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $codeOrRef;
    public bool $isFinal;
    public ?float $amount;

    /**
     * Create a new message instance.
     */
     public function __construct(string $codeOrRef, bool $isFinal = false, ?float $amount = null)
    {
        $this->codeOrRef = $codeOrRef;
        $this->isFinal   = $isFinal;
        $this->amount    = $amount;
    }

    public function build()
    {
        if ($this->isFinal) {
            return $this->subject('Wallet Transfer Successful')
                ->view('emails.wallet_transfer_success');
        }

        return $this->subject('Your Wallet Transfer OTP')
            ->view('emails.wallet_transfer_otp');
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Wallet Transfer Success Mail',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
