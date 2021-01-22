<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfilesController extends Controller
{
    public function index($user)
    {
        $user = User::findOrFail($user);
        return view('profiles/index', compact('user'));
        /* Gamla sättet att skriva:
        return view('profiles/index', [
            'user' => $user,
        ]);
        */
    }

    public function edit(User $user) //istället för findorfail som ovan & App\Models\User för vi har use
    {
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        $user->profile->update($data);
        return redirect("/profile/{$user->id}");
    }
}
