<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::when(isset(request()->search),function ($query){

            $keyword = request()->search;

            $query->orWhere('title','like','%'.$keyword.'%')->orWhere('description','like',"%$keyword%");

        })->with(['user','category'])->latest("id")->paginate(7);
//        return $posts;
        return view('post.index',compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {


        $request->validate([
            "title" => "required|min:3|unique:posts,title",
            "category"=> "required|exists:categories,id",
            "description"=> "required|min:10",
            "photo" => "required",
            "photo.*" => "file|mimes:jpeg,png|max:5000"
        ]);


//        return $request;


        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->category_id = $request->category;
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description,20);
        $post->user_id = Auth::id();
        $post->isPublish = '1';
        $post->save();

        if($request->hasFile('photo')){

            foreach ($request->file('photo') as $photo){

                $newName = uniqid()."_photo.".$photo->extension();
                $photo->storeAs('public/photo',$newName);


                $img = Image::make($photo);
                $img->fit(200,200);
                $img->save("storage/thumbnail/".$newName,100);

                $photo = new Photo();
                $photo->name = $newName;
                $photo->post_id = $post->id;
                $photo->user_id = Auth::id();
                $photo->save();
            }

        }


        return redirect()->route('post.index')->with("status","Post Created");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validate([
            "title" => "required|min:3|unique:posts,title,".$post->id,
            "category"=> "required|exists:categories,id",
            "description"=> "required|min:10"
        ]);


        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->category_id = $request->category;
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description,20);

        $post->update();

        return redirect()->route('post.index')->with("status","post updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index')->with("status","aung p aung p aung p");
    }
}
