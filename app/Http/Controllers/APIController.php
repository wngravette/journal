<?php

namespace App\Http\Controllers;

use Auth;
use App\Entry;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class APIController extends Controller
{
    public function contribs()
    {
        if (Auth::check()) {
            $user = User::find(Auth::user()->id);
            $entries = $user->entries;
            $contribs = [];
            $value = 1;

            foreach ($entries as $entry) {
                $timestamp = date_timestamp_get($entry->updated_at);
                $contribs[$timestamp] = $value;
            }

            return $contribs;
        }
    }
}
