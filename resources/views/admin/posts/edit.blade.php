@extends('layouts.admin')
@section('content')

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')
    <h1>modifica dati</h1>
  <div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" id="title" name="title"  placeholder="inserisci titolo" value="{{ $post->title }}">
  </div>
  <div class="mb-3">
    <label for="content" class="form-label">Content</label>
   <textarea name="content" type="text" id="content" cols="30" rows="10" value="{{ $post->content }}">
   </textarea>
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="published" name="published" {{old('published') ? 'checked': ''}}>
    <label class="form-check-label" for="published">Published</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
    
    
@endsection