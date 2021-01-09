<?php

namespace App\Http\Controllers;
use App\Post as Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class PostController extends Controller
{

    public function __construct ()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
    //latest() = orderby(created, 'desc');
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption'=>'required',
            'image' => ['required', 'image']
            ]);

        $imagePath= request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);//fit != resize
        $image->save();
        auth()->user()->posts()->create([
            'caption'=> $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect('/profile/'.auth()->user()->id);

    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }


}