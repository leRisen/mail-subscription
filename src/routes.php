<?php

Route::post(config('mailsubscription.url'), 'leRisen\MailSubscription\MailSubscriptionController@subscribe')->name('mailsubscription:subscribe');
