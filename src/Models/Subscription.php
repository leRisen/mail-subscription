<?php

namespace leRisen\MailSubscription\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
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
}
