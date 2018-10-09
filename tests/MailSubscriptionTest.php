<?php

namespace leRisen\MailSubscription\Tests;

use leRisen\MailSubscription\Models\Subscription;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $router = $this->app['router'];
        $router->post('feedback', '\leRisen\MailSubscription\Http\Controllers\MailSubscriptionController@subscribe');
    }

    /** @test */
    public function it_subscribe_to_newsletter()
    {
        $response = $this->post('/feedback', ['email' => 'lemmas.online@gmail.com']);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'message' => 'You successfully subscribed to the newsletter!',
            ]);
    }

    /** @test */
    public function it_can_not_subscribe_to_newsletter_if_already_subscribed()
    {
        $email = 'lemmas.online@gmail.com';
        Subscription::create(['email' => $email]);

        $response = $this->post('/feedback', ['email' => $email]);

        $response
            ->assertStatus(422)
            ->assertExactJson([
                'success' => false,
                'message' => 'This mail has already been subscribed to the newsletter!'
            ]);
    }

    /** @test */
    public function it_not_subscribe_if_validation_fails()
    {
        $response = $this->post('/feedback', []);

        $response
            ->assertStatus(302)
            ->assertRedirect(url('/'))
            ->assertSessionHasErrors([
                'email' => 'The email field is required.',
            ]);
    }

    /** @test */
    public function it_not_subscribe_with_an_invalid_email()
    {
        $this->withoutExceptionHandling();

        $cases = ['lemmas.online', 'lemmas.online@', 'lemmas.online@test'];

        foreach ($cases as $case) {
            try {
                $this->post('/feedback', ['email' => $case]);
            } catch (ValidationException $e) {
                $this->assertEquals(
                    'The email must be a valid email address.',
                    $e->validator->errors()->first('email')
                );

                continue;
            }

            $this->fail("The email $case passed validation when it should have failed.");
        }
    }

    /** @test */
    public function max_length_fail_when_too_long()
    {
        $domain = '@gmail.com';

        $email = str_repeat('a', 75 - strlen($domain));
        $email .= $domain;

        $response = $this->post('/feedback', ['email' => $email]);

        $response
            ->assertStatus(302)
            ->assertRedirect(url('/'))
            ->assertSessionHasErrors([
                'email' => 'The email must be a valid email address.',
            ]);
    }

    /** @test */
    public function max_length_succeeds_when_under_max()
    {
        $domain = '@gmail.com';

        $email = str_repeat('a', 74 - strlen($domain));
        $email .= $domain;

        $response = $this->post('/feedback', ['email' => $email]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'message' => 'You successfully subscribed to the newsletter!',
            ]);
    }
}
