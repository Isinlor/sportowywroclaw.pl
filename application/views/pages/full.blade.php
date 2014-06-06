@layout('templates.main')
@section('content')
{{ HTML::script('js/lightbox.js') }}
{{ HTML::style('css/lightbox.css') }}
<div class="post">
<h1>{{ HTML::link('view_post/'.$post->id, $post->title) }}</h1>
        <a href="{{URL::base()}}/img/miniatures/{{$post->miniatures}}" rel="lightbox">
{{ HTML::image('img/miniatures/'.$post->miniatures, $post->title, array('class' => 'img-polaroid'));}}
        </a>
<p>{{ $post->body }}</p>
<span class="pull-right"> Tagi: 
	@foreach ($post->tags as $tag)
            {{ HTML::link('view_post/tag/'.$tag, $tag, array( 'class' => 'btn  btn-mini')) }}
	@endforeach
</span>
<p>{{ HTML::link('/', '&larr; Back to index.') }}</p>
    <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'karolinatest'; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>

</div>
@endsection