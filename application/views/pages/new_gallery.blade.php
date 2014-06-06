@layout('templates.main')

@section('content')
{{ Form::open('new_gallery') }}
	{{ Form::hidden('author_id', $user->id) }}
    {{ $errors->first('title', '<span class="text-error">:message</span>') }}
    <div class="input-prepend">
        <span class="add-on">{{ Form::label('title', 'Tytuł galerii: ') }}</span>
        {{ Form::text('title', Input::old('title'), array('class' => 'input-xlarge')) }}
    </div>

    <p>{{ Form::label('body', 'Opis:') }}</p>
    {{ $errors->first('body', '<p class="text-error">:message</p>') }}
    <p>{{ Form::textarea('body', Input::old('body'), array('class' => 'input-block-level'))}}</p>
    <!-- submit button -->
    <p>{{ Form::submit('Dodaj', array('class' => 'btn')) }}</p>
{{ Form::close() }}
@endsection