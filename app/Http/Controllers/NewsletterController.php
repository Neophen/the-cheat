<?php

namespace App\Http\Controllers;

use App\Services\Newsletter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class NewsletterController extends Controller
{

  public function success()
  {
    return Inertia::render('BetaSuccess');
  }

  public function index()
  {
    $newsletter = new Newsletter();

    return Inertia::render('NewsletterIndex', [
      'members' => $newsletter->listSubscribers(),
    ]);
  }

  public function store(Request $request, Newsletter $newsletter): RedirectResponse
  {
    $request->validate([
      'email' => 'required|email',
    ]);

    try {
      $newsletter->subscribe($request->input('email'));
      return Redirect::route('landing')->with('success', "We've added you to our beta users email list!");
    } catch (\Exception $e) {

      $newsletter->handleSubscribeError($e);
    }
  }
}
