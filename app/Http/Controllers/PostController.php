<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewPostMailJob;
use Illuminate\Support\Facades\Gate;   
 use Illuminate\Support\Facades\Storage; 
 use Illuminate\Support\Facades\File;


use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

   
    public function index()
    {
      
        $posts = Post::all();
        return view('posts.index',['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!auth()->check()) {
            return to_route('login');
        }
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //   dd($request->title);
    //   Post::create([
    //     'title'=>$request->title,
    //     'content'=>$request->content,
    //   ]);
      
    $validated = $request->validate([
        'title' => ['required', 'min:5', 'max:255'],
        'content' => ['required', 'min:10'],
        'thumbnail' => ['required', 'image'],
    ]);

    $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
    
    auth()->user()->posts()->create($validated);
    
    dispatch(new SendNewPostMailJob(['email' =>auth()->user()->email, 'name'=>auth()->user()->name, 'title'=>$validated
    ['title']]));
    // Mail::to('saidyare447@gmail.com')->send(new PostMail());
    return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // $post = Post::findOrFail($id);
        return view('posts.show', ['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
      Gate::authorize('update',$post);
            return view('posts.edit',['post'=>$post]);
        

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update',$post);
        $validated = $request->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'content' => ['required', 'min:10'],
            'thumbnail' => ['sometimes', 'image'],
        ]);
    
        // if($request->hasFile('thumbnail')){
        //     File::delete(storage_path('app/public/' . $post->thumbnail));
        //     $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
        // }
        if ($request->hasFile('thumbnail')) {
            // Corrected path concatenation
            File::delete(storage_path('app/public/' . $post->thumbnail));
            
            // Store new thumbnail and update the validated data
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        $post->update($validated);
    
        return to_route('posts.show', ['post' => $post]);

    }

    /**
     * Remove the specified resource from storage.
     */
        public function destroy(Post $post)
        {
            Gate::authorize('delete',$post);
            File::delete(storage_path('app/public/' . $post->thumbnail));

            $post->delete();
            return redirect()->route('posts.index');
                }
    }
