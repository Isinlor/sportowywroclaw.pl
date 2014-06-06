@layout('templates.main')
@section('content')
@foreach ($galleries as $gallery)
<div class="post">
<h1>{{ HTML::link('view_gallery/'.$gallery->id, $gallery->title) }}</h1>
<p>{{ substr($gallery->body,0, 320).' [..]' }}</p>
<p>{{ HTML::link('view_gallery/'.$gallery->id, 'Zobacz galerię &rarr;') }}</p>
</div>
<hr/>
@endforeach
{{$paginate->links()}}
@endsection