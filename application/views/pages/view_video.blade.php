@layout('templates.main')
@section('content')
	<style>
		#thumbs { overflow: auto; height: 298px; width: 100%; border: 1px solid #E7E7DE; padding: 0; float: left; }
		#thumbs ul { list-style-type: none; margin: 0 10px 0; padding: 0 0 10px 0; }
		#thumbs ul li { height: 80px; }

		.thumb { border: 0; float: left; width: 100px; height: 75px; background: url(http://a.vimeocdn.com/thumbnails/defaults/default.75x100.jpg); margin-right: 10px; }

		#embed { background-color: #E7E7DE; height: 280px; width: 552px; float: left; padding: 10px; }

		#portrait { float: left; margin-right: 5px; max-width: 100px; }
		#stats { clear: both; margin-bottom: 20px; }
	</style>
	<script>

		var apiEndpoint = 'http://vimeo.com/api/v2/';
		var oEmbedEndpoint = 'http://vimeo.com/api/oembed.json'
		var oEmbedCallback = 'switchVideo';
		var videosCallback = 'setupGallery';
		var vimeoUsername = 'brad';

		// Get the user's videos
		$(document).ready(function() {
			$.getScript(apiEndpoint + vimeoUsername + '/videos.json?callback=' + videosCallback);
		});

		function getVideo(url) {
			$.getScript(oEmbedEndpoint + '?url=' + url + '&width=552&height=280&callback=' + oEmbedCallback);
		}

		function setupGallery(videos) {

			// Set the user's thumbnail and the page title
			$('#stats').prepend('<img id="portrait" src="' + videos[0].user_portrait_medium + '" />');
			$('#stats h2').text(videos[0].user_name + "'s Videos");

			// Load the first video
			getVideo(videos[0].url);

			// Add the videos to the gallery
			for (var i = 0; i < videos.length; i++) {
				var html = '<li><a href="' + videos[i].url + '"><img src="' + videos[i].thumbnail_medium + '" class="thumb" />';
				html += '<p>' + videos[i].title + '</p></a></li>';
				$('#thumbs ul').append(html);
			}

			// Switch to the video when a thumbnail is clicked
			$('#thumbs a').click(function(event) {
				event.preventDefault();
				getVideo(this.href);
				return false;
			});

		}

		function switchVideo(video) {
			$('#embed').html(unescape(video.html));
		}

	</script>
		<h1>Galeria video</h1>
	<div id="wrapper">
		<div id="embed"></div>
		<div id="thumbs">
			<ul></ul>
		</div>
	</div>
@endsection