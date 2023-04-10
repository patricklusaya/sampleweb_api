<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller

{

    public function show(){
        return Post::all();
       }
       public function find($id){
          return Post::find($id);
         }

   public function store(Request $request){
    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'required',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'attachment' => 'nullable|mimes:pdf,docx|max:2048'
    ]);
    if ($request->hasFile('cover_image')) {
        $image = $request->file('cover_image')->store('public');
        $validatedData['cover_image'] = Storage::url($image);
    }

    if ($request->hasFile('attachment')) {
        $attachment = $request->file('attachment')->store('public');
        $validatedData['attachment'] = Storage::url($attachment);
    }
   
$created_by = auth()->user()->role;
$validatedData['created_by'] = $created_by;
    Post::create($validatedData);

    return response()->json(
        'Post Created'
    );
   }


   public function update(Request $request , $id){
    $post = Post::find($id);

  $request->validate([
      'title' => 'sometimes|unique:posts,title,' . $id,
      'content' => 'sometimes',
  ]);

  $post->update($request->all());

  return response()->json([
      'message' => 'Post updated',
      
  ]);



 }
 public function destroy($id){
    $post = Post::find($id);
    $post->destroy();

 }

 public function search(Request $request){

    $posts = Post::query();
    if ($request->filled('keyword')) {
       $keyword = '%' . $request->input('keyword') . '%';
       $posts->where(function($query) use ($keyword) {
          $query->where('title', 'ILIKE', "%$keyword%")
                ->orWhere('content', 'ILIKE', "%$keyword%");
      });

      
    }
    
    $posts = $posts->get();

    return response()->json([
        'posts' => $posts,
    ]);

 }

  
}
