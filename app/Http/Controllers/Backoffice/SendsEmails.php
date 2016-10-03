<?php

namespace App\Http\Controllers\Backoffice;

use Digbang\Security\Users\User;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

trait SendsEmails
{
    /**
     * @param User   $user
     * @param string $link
     */
    public function sendPasswordReset(User $user, $link)
    {
        $this->send('backoffice::emails.reset-password', $user, $link, trans(
            'backoffice::emails.reset-password.subject'
        ));
    }

    /**
     * @param User   $user
     * @param string $link
     */
    public function sendActivation(User $user, $link)
    {
        $this->send('backoffice::emails.activation', $user, $link, trans(
            'backoffice::emails.activation.subject'
        ));
    }

    /**
     * @param string $view
     * @param User   $user
     * @param string $link
     * @param string $subject
     */
    protected function send($view, User $user, $link, $subject)
    {
        $from = config('backoffice.emails');

        $name = $user->getName() ?: $user->getUsername();

        Mail::send($view, ['name' => $name, 'link' => $link], function (Message $message) use ($user, $from, $subject, $name) {
            $message
                ->from($from['address'], $from['name'])
                ->to($user->getEmail(), $name)
                ->subject($subject);
        });
    }
}
