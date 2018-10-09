<?php

Route::namespace('leRisen\MailSubscription\Http\Controllers')->group(function () {
    Route::post(config('mailsubscription.url', 'feedback'), 'MailSubscriptionController@subscribe')->name('mailsubscription:subscribe');
    Route::get(config('mailsubscription.verificationUrl', 'verify-feedback').'/{code}', 'MailSubscriptionController@verify')->name('mailsubscription:verify');
});
