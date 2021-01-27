<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id'); //user_id under profiles table
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5); //istället gör get() kör vi paginate() för att styra hur många vi vill visa per sida //istället för orderBy('created_at', 'DESC') så kör vi en kortare latest()
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create'); //kan köra med . istället för slash
    }

    public function store()
    {
        $data = request()->validate([
            // 'another' => '',
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->orientate()->fit(1200, 1200); //Intervention Image Package
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        // Post::create($data);

        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(\App\Models\Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
