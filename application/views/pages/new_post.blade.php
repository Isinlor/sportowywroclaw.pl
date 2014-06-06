@layout('templates.main')

@section('content')
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
    {{ Form::open_for_files('new_post') }}

        <!-- author -->
        {{ Form::hidden('author_id', $user->id) }}
        
        <!-- title field -->
        {{ $errors->first('title', '<span class="text-error">:message</span>') }}
        <div class="input-prepend">
            <span class="add-on">{{ Form::label('title', 'Tytuł wpisu: ') }}</span>
            {{ Form::text('title', Input::old('title'), array('class' => 'input-xlarge')) }}
        </div>

        <!-- miniture field -->
        {{ HTML::script('js/bootstrap-fileupload.min.js') }}
        {{ HTML::style('css/bootstrap-fileupload.min.css');}}
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=brak+obrazka" /></div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
                <span class="btn btn-file"><span class="fileupload-new">Wybierz miniaturkę</span><span class="fileupload-exists">Zmień</span>{{Form::file('image');}}</span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Usuń</a>
            </div>
        </div>
        {{ $errors->first('thumbnail', '<span class="text-error">:message</span>') }}
        {{--{var_dump($errors)--}}
        <!-- body field -->
        <p>{{ Form::label('body', 'Treść') }}</p>
        {{ $errors->first('body', '<p class="text-error">:message</p>') }}
        <p>{{ Form::textarea('body', Input::old('body'), array('class' => 'input-block-level'))}}</p>

        <!-- tags field -->
        <div class="input-prepend">
            <span class="add-on">{{ Form::label('tags', 'Tagi:') }}</span>
            {{ Form::text('tags', '', array('class' => 'input-xlarge')) }}
        </div>
        <span class="help-block">Oddziel tagi przecinkami.</span>
        <!-- submit button -->
        <p>{{ Form::submit('Dodaj', array('class' => 'btn')) }}</p>
    {{ Form::close() }}


<!-- <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" /> 
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<style>
#sortable1, #sortable2, #sortable3 { list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px; background: #eee; padding: 5px; width: 143px;}
#sortable1 li, #sortable2 li, #sortable3 li { margin: 5px; padding: 5px; font-size: 1.2em; width: 120px; }
</style>
<script>
$(function() {
$( "ul.droptrue" ).sortable({
connectWith: "ul",
      placeholder: "ui-state-highlight"
});
$( "#sortable1, #sortable2, #sortable3" ).disableSelection();
});
</script>
<ul id="sortable1" class="droptrue">
<li class="ui-state-default">Can be dropped..</li>
<li class="ui-state-default">..on an empty list</li>
<li class="ui-state-default">Item 3</li>
<li class="ui-state-default">Item 4</li>
<li class="ui-state-default">Item 5</li>
</ul>
<ul id="sortable2" class="dropfalse">
<li class="ui-state-highlight">Cannot be dropped..</li>
<li class="ui-state-highlight">..on an empty list</li>
<li class="ui-state-highlight">Item 3</li>
<li class="ui-state-highlight">Item 4</li>
<li class="ui-state-highlight">Item 5</li>
</ul>
<ul id="sortable3" class="droptrue">
</ul>-->
@endsection