<?php

namespace leRisen\MailSubscription;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use leRisen\MailSubscription\Models\Subscription;

class MailSubscriptionController extends Controller
{
    use ValidatesRequests;

    /**
     * @var Subscription
     */
    protected $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function subscribed($email)
    {
        return $this->subscription->where('email', $email)->first();
    }

    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
        ]);

        $email = $request->email;
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
