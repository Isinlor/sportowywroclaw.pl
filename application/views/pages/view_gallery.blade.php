@layout('templates.main')
@section('content')
{{ HTML::script('js/jquery.fancybox.pack.js') }}
{{ HTML::script('js/jquery.fancybox-buttons.js') }}

{{ HTML::style('css/jquery.fancybox.css') }}
{{ HTML::style('css/jquery.fancybox-buttons.css') }}

<script type="text/javascript">
$(document).ready(function() {
    $(".fancybox").fancybox({
        prevEffect  : 'none',
        nextEffect  : 'none'
    });
});
</script>
<div class="gallery">
<h1>{{ HTML::link('view_gallery/'.$gallery->id, $gallery->title) }}</h1>
<p>{{ $gallery->body }}</p>

@foreach ($pictures as $picture)
        <a href="{{URL::base()}}/galleries/{{$gallery->id}}/{{$picture->file_name}}" class="fancybox" rel="group">
{{ HTML::image('galleries/thumbnails/'.$gallery->id.'/'.$picture->file_name, $picture->file_name, array('class' => 'img-polaroid'));}}
        </a>
@endforeach

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