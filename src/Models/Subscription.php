<?php

namespace leRisen\MailSubscription\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use leRisen\MailSubscription\Notifications\VerifySubscription;

class Subscription extends Model
{
    use Notifiable;

    const CREATED_AT = 'subscription_date';
    const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mail_subscribers';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Returns true if the subscribe is verified.
     *
     * @return bool
     */
    public function verified()
    {
        return $this->code === null;
    }

    /**
     * Send the user a subscription verification
     *
     * @return void
     */
    public function sendVerification()
    {
        $this->notify(new VerifySubscription($this->code));
    }
}
