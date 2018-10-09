<?php

namespace leRisen\MailSubscription\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use leRisen\MailSubscription\Models\Subscription;

class MailSubscriptionController extends Controller
{
    use ValidatesRequests;

    /**
     * @var Subscription
     */
    protected $subscription;

    /**
     * Constuctor.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Checks if email is subscribed.
     *
     * @param string $email
     *
     * @return Subscription
     */
    public function subscribed($email)
    {
        return $this->subscription->where('email', $email)->first();
    }

    /**
     * Subscribe email to the newsletter.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $subscribed = $this->subscribed($email);

        if ($subscribed) {
            $code = 422;
            $data = [
                'success' => false,
                'message' => trans('translate-mailsubscription::subscription.alreadyExists'),
            ];
        } else {
            $this->subscription->create(['email' => $email]);

            $code = 200;
            $data = [
                'success' => true,
                'message' => trans('translate-mailsubscription::subscription.successfully'),
            ];
        }

        return response()->json($data, $code);
    }
}
