<?php

Route::post(config('mailsubscription.url', 'feedback'), 'leRisen\MailSubscription\Http\Controllers\MailSubscriptionController@subscribe')->name('mailsubscription:subscribe');
