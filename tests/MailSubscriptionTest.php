<?php

namespace leRisen\MailSubscription\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class MailSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function testWithValidEmail()
    {
        $response = $this->post('/feedback', ['email' => 'lemmas.online@gmail.com']);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'message' => 'You successfully subscribed to the newsletter!'
            ]);
    }

    public function testWithoutEmail()
    {
        $response = $this->post('/feedback', []);

        $response
            ->assertStatus(302)
            ->assertRedirect(url('/'))
            ->assertSessionHasErrors([
                'email' => 'The email field is required.'
            ]);
    }

    public function testWithInvalidEmail()
    {
        $response = $this->post('/feedback', ['email' => 'lemmas.online']);

        $response
            ->assertStatus(302)
            ->assertRedirect(url('/'))
            ->assertSessionHasErrors([
                'email' => 'The email must be a valid email address.'
            ]);
    }

    public function testWithTooLongEmail()
    {
        $domain = '@gmail.com';

        $email = str_repeat('a', 256 - strlen($domain));
        $email .= $domain;

        $response = $this->post('/feedback', ['email' => $email]);

        $response
            ->assertStatus(302)
            ->assertRedirect(url('/'))
            ->assertSessionHasErrors([
                'email' => 'The email may not be greater than 255 characters.'
            ]);
    }
}
