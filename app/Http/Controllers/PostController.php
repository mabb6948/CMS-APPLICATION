<?php

namespace App\Http\Controllers;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    //
    public function index(){

        //$posts = Post::all(); // Con: Anyone can come and see your posts

        //$posts = auth()->user()->posts(); // Only show your posts
        $posts = auth()->user()->posts()->paginate(5); // Only show your posts with 5 posts in single page.

        return view('admin.posts.index', ['posts'=> $posts]);
        // second argument saving all posts in the variable

    }



    public function show(Post $post){
        
        return view('blog-post', ['post'=> $post]);
    }

    public function create(Post $post){

        $this->authorize('create', Post::class); // // if I am authorised through policy, I can create the post
        
        return view('admin.posts.create');
    }

    public function store(){

        $this->authorize('create', Post::class); // // if I am authorised through policy, I can save the post

        /* For validation */
        $input = request()->validate([
            'title'=> 'required|min:8|max:255',
            'post_image'=> 'file',
            'body'=>'required'
        ]);

        /* if image exists, put it on image directory */
        if(request('post_image')){
            /* alternative to display original name and do the same thing */
            // $name = $file->getClientOriginalName();
            // $file->move('images', $name);
            // $input['post_image'] = $name;
            $input['post_image'] = request('post_image')->store('images');
        }

        auth()->user()->posts()->create($input);

        session()->flash('post-created-message', 'Post with title was created '. $input['title']);

        return redirect()->route('post.index');
    }

    public function edit(Post $post){

         $this->authorize('view', $post); // // if I am authorised through policy, I can edit the post

        /* Alternative for using middleware in routes */
//        if(auth()->user()->can('view', $post)){
//
//
//        }
        return view('admin.posts.edit', ['post'=> $post]);
    }

    public function destroy(Post $post ,Request $request){

       $this->authorize('delete', $post); // if I am authorised through policy, I can delete the post


        $post->delete();

        $request->session()->flash('message', 'Post was deleted');

        return back();
    }


    public function update(Post $post){

        $input = request()->validate([
            'title'=> 'required|min:8|max:255',
            'post_image'=> 'file',
            'body'=> 'required'
        ]);


        if(request('post_image')){
            $input['post_image'] = request('post_image')->store('images');
            $post->post_image = $input['post_image'];
        }
        /* the save method requires an object so we have to save values in another object post */
        $post->title = $input['title'];
        $post->body = $input['body'];


        $this->authorize('update', $post); // if I am authorised through policy, I can update the post

        //auth()->user()->posts()->save($post);


        $post->save();

        session()->flash('post-updated-message', 'Post with title was updated '. $input['title']);

        return redirect()->route('post.index');

    }

}
