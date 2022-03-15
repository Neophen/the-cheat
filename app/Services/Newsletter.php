<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Newsletter
{
  public function subscribe(string $email, string $list = null)
  {
    $list ??= config('services.mailchimp.lists.subscribers');

    return $this->client()->lists->addListMember($list, [
      "email_address" => $email,
      "status" => "pending",
    ]);
  }

  public function listSubscribers()
  {
    $list ??= config('services.mailchimp.lists.subscribers');

    $members = collect($this->client()->lists->getListMembersInfo($list)->members, []);

    // dd($members);
    return $members->map(fn ($member) => [
      // 'id' => $member->id,
      'status' => $member->status,
      'email' => $member->email_address,
    ])->all();
  }

  private function client(): ApiClient
  {
    $mailchimp = new ApiClient();;
    $mailchimp->setConfig([
      'apiKey' => config('services.mailchimp.key'),
      'server' => config('services.mailchimp.prefix'),
    ]);

    return $mailchimp;
  }



  public function handleSubscribeError(\Exception $e)
  {
    $message = Str::of($e->getMessage());

    if ($message->contains('"title":"Member Exists"')) {
      throw ValidationException::withMessages([
        'email' => "You're already subscribed to our beta users email list!",
      ]);
    }

    throw ValidationException::withMessages([
      'email' => 'This email could not be added to our beta users email list.',
    ]);
  }
}
