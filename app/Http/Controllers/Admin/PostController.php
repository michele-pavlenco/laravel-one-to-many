<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Doctrine\DBAL\Tools\Dumper;
use Facade\Ignition\DumpRecorder\Dump;
use Psy\VarDumper\Dumper as VarDumperDumper;
use Symfony\Component\Console\Helper\Dumper as HelperDumper;

class PostController extends Controller
{
       protected $validationRule = [
        'title'=>'required|max:250',
        'content' => 'required|max:255'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $data = $request->all();
     $newPost = new Post();
     $newPost->title = $data['title'];
     $slug = Str::of($data['title'])->slug('-');
     $newPost->content = $data['content'];
     $newPost->published = isset($data['published']);
     $count = 1;
     while(Post::where('slug', $slug)->first()){
        $slug = Str::of($data['title'])->slug('-')."-{$count}";
        $count++;
     }
     $newPost->slug = $slug;
     $newPost->save();
     return redirect()->route('admin.posts.show',$newPost->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
         return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->validationRule);
        $data = $request->all();
        $post->update($data);
        return redirect()->route('admin.posts.show', $post->id);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}