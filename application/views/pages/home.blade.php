@layout('templates.main')
@section('content')
@foreach ($posts as $post)
<div class="post">
<h1>{{ HTML::link('view_post/'.$post->id, $post->title) }}</h1>
<p>{{ HTML::image('img/miniatures/'.$post->miniatures, $post->title, array('class' => 'img-polaroid'));}}{{ substr($post->body,0, 320).' [..]' }}</p>
<p>{{ HTML::link('view_post/'.$post->id, 'Przeczytaj więcej &rarr;') }}</p>
</div>
<hr/>
@endforeach
{{$paginate->links()}}
@endsection