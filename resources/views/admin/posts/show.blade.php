@extends('layouts.admin')

@section('content')
<h1>{{$post->title}}</h1>
<p>{{$post->content}}</p>
<h5>Pubblicato: {{$post->published}}</h5>


    
@endsection