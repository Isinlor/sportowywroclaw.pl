<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::get('/', function() {
// lets get our posts and eager load the
// author
	$page = Input::get('page', 1) - 1;
	$per_page = 5;
	$posts = Post::with('author')->order_by('id', 'desc')->skip($per_page*$page)->take($per_page)->get();
	$paginate = DB::table('posts')->paginate($per_page);
	return View::make('pages.home')
	->with('posts', $posts)
	->with('paginate', $paginate);
});
Route::get('view_galleries', function() {
	$page = Input::get('page', 1) - 1;
	$per_page = 5;
	$paginate = DB::table('posts')->paginate($per_page);
	$galleries = Gallery::order_by('id', 'desc')->skip($per_page*$page)->take($per_page)->get();
	return View::make('pages.view_galleries')
	->with('galleries',$galleries)
	->with('paginate', $paginate);
});
Route::get('view_gallery/(:num)', function($gallery_id) {
	$gallery = gallery::find($gallery_id);
	$pictures = picture::where('gallery_id', '=', $gallery_id)->get();
	return View::make('pages.view_gallery')
	->with('gallery', $gallery)
	->with('pictures', $pictures);
});
Route::get('new_gallery', array('before' => 'auth', 'do' => function() {
	$user = Auth::user();
	return View::make('pages.new_gallery')->with('user', $user);
}));
Route::post('new_gallery', array('before' => 'auth', 'do' => function() {
// let's get the new gallery from the POST data
// this is much safer than using mass assignment
	$new_gallery = array(
		'title' => Input::get('title'),
		'body' => Input::get('body'),
		'author_id' => Input::get('author_id'),
		);
// let's setup some rules for our new data
// I'm sure you can come up with better ones
	$rules = array(
		'title' => 'required|min:3|max:128',
		'body' => 'required'
		);
// make the validator
	$v = Validator::make($new_gallery, $rules);
	if ($v->fails())
	{
// redirect back to the form with
// errors, input and our currently
// logged in user
		return Redirect::to('new_gallery')
		->with('user', Auth::user())
		->with_errors($v)
		->with_input();
	}

// // create the new gallery
	$gallery = new gallery($new_gallery);
	$gallery->save();
// redirect to viewing our new post
	return Redirect::to('new_gallery/'.$gallery->id.'/add_pictures');
}));
Route::get('new_gallery/(:num)/add_pictures', array('before' => 'auth', 'do' => function($gallery) {
	if (!Request::ajax()) {
		$gallery = gallery::find($gallery);
		return View::make('pages.add_pictures')
		->with('gallery', $gallery);
	}else{
		if ($gallery !== null){
			$gallery .= '/';
		}
		// $settings = array(
		// 	'script_url' => URL::to_route('new_gallery/'.$gallery.'/add_pictures'),
		// 	'upload_dir' => path('public').'/galleries//'.$gallery,
		// 	'upload_url' => URL::base().'/galleries//'.$gallery,
		// 	'delete_type' => 'POST',
		// 	'image_versions' => array(
		// 		'thumbnail' => array(
		// 			'upload_dir' => path('public').'/galleries//'.$gallery.'thumbnails/',
		// 			'upload_url' => URL::base().'/galleries//'.$gallery.'thumbnails/',
		// 			),
		// 		),
		// 	);
		$upload_handler = new UploadHandler();
		$upload_handler->get($gallery);
	}
}));
Route::post('new_gallery/(:num)/add_pictures', array('before' => 'auth', 'do' => function($gallery_id)
{
	if ( ! Request::ajax()){
		return;
	}
	$full_gallery_dir = dirname($_SERVER['SCRIPT_FILENAME']).'/galleries/'.$gallery_id.'/';
	if (!is_dir($full_gallery_dir)) {
    	mkdir($full_gallery_dir);
	}
	$full_thumbnails_dir = dirname($_SERVER['SCRIPT_FILENAME']).'/galleries/thumbnails/'.$gallery_id.'/';
	if (!is_dir($full_thumbnails_dir)) {
    	mkdir($full_thumbnails_dir);
	}
	$upload_handler = new UploadHandler();
	$info = $upload_handler->post($gallery_id.'/');
	$new_picture = array(
		'file_name' => 	$info[0]->name,
		'author_id' => Auth::user()->id,
		'gallery_id' => $gallery_id
		);
	$picture = new picture($new_picture);
	$picture->save();
	$upload_handler->post_send($info);
}));
Route::delete('new_gallery/(:num)/add_pictures', array('before' => 'auth', 'do' => function($gallery_id)
{
	if ( ! Request::ajax()){
		return;
	}

}));
Route::get('view_post/(:num)', function($post) {
	$post = Post::find($post);
	$post->tags = explode(', ', $post->tags);
	return View::make('pages.full')
	->with('post', $post);
});
Route::get('view_post/tag/(:all)', function($tag) {
	$page = Input::get('page', 1) - 1;
	$per_page = 5;
	$paginate = DB::table('posts')->where('tags', 'LIKE', '%'.$tag.'%')->paginate($per_page);
	$posts = DB::table('posts')
    ->where('tags', 'LIKE', '%'.$tag.'%')->order_by('id', 'desc')
    ->skip($per_page*$page)->take($per_page)
    ->get();
	return View::make('pages.home')
	->with('posts', $posts)
	->with('paginate', $paginate);
});
Route::get('new_post', array('before' => 'auth', 'do' => function() {
	$user = Auth::user();
	return View::make('pages.new_post')->with('user', $user);
}));
Route::post('new_post', array('before' => 'auth', 'do' => function() {
	$image = Input::file('image');
	$extension = File::extension($image['name']);
    $directory = path('public').'img/miniatures';
    $filename = sha1(time()).".{$extension}";
// let's get the new post from the POST data
// this is much safer than using mass assignment
	$new_post = array(
		'title' => Input::get('title'),
		'body' => Input::get('body'),
		'author_id' => Input::get('author_id'),
		'tags' => Input::get('tags'),
		'miniatures' => $filename
		);
	$directory = path('public').'img/miniatures';

	// Validator::register('resolution', function($attribute, $image, $resolution){
		
	// 	$size = getimagesize($image);
	// 	if($size[0]==$resolution[0] && $size[1]==$resolution[1]){
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// });

// let's setup some rules for our new data
// I'm sure you can come up with better ones
	$rules = array(
		'title' => 'required|min:3|max:128',
		'body' => 'required'
		);
// make the validator
	$v = Validator::make($new_post, $rules);
	// $check_thumbinal = Validator::make(array('thumbinal' => $image), array('thumbinal' => 'resolution:560,250', array('thumbinal' => 'Wrong size of image.')));
	// echo "<pre>";
	// var_dump($check_thumbinal->fails());
	if ($v->fails())
	{
// redirect back to the form with
// errors, input and our currently
// logged in user
		return Redirect::to('new_post')
		->with('user', Auth::user())
		->with_errors($check_thumbinal)
		->with_input();
	}

// // create the new post
	$post = new Post($new_post);
	$post->save();
	$thumbinal = Input::upload('image', $directory, $filename);
// redirect to viewing our new post
	return Redirect::to('view_post/'.$post->id);
}));
Route::get('view_video', function() {
	return View::make('pages.view_video');
});
Route::get('login', function() {
	return View::make('pages.login');
});
Route::post('login', function() {
	$userdata = array(
		'username' => Input::get('username'),
		'password' => Input::get('password')
		);
	if ( Auth::attempt($userdata) )
	{
		return Redirect::to('new_post');
	}
	else
	{
		return Redirect::to('login')
		->with('login_errors', true);
	}
});
Route::get('logout', function() {
	Auth::logout();
	return Redirect::to('/');
});
/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});