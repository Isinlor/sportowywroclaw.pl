@layout('templates.main')
@section('content')
<link rel="stylesheet" href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
{{HTML::style('css/jquery.fileupload-ui.css');}}
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>{{HTML::style('css/jquery.fileupload-ui-noscript.css');}}</noscript>
<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <div class="page-header">
    	<h1>Tytuł galerii: {{ HTML::link('view_gallery/'.$gallery->id, $gallery->title) }}</h1>
    	<p><h4>Opis galerii:</h4> {{ $gallery->body }}</p>
    </div>
    <!-- The file upload form used as target for the file upload widget -->
    {{Form::open_for_files('new_gallery/'.$gallery->id.'/add_pictures', 'POST', array('enctype'=> 'multipart/form-data', 'id' => 'fileupload'));}}
		<div class="row fileupload-buttonbar">
			<div class="span7">
				<!-- The fileinput-button span is used to style the file input field as button -->
				<span class="btn btn-success fileinput-button">
					<i class="icon-plus icon-white"></i>
					<span>Dodaj pliki...</span>
					<input type="file" name="files[]" multiple>
				</span>
				<button type="submit" class="btn btn-primary start">
					<i class="icon-upload icon-white"></i>
					<span>Zacznij upload</span>
				</button>
				<button type="reset" class="btn btn-warning cancel">
					<i class="icon-ban-circle icon-white"></i>
					<span>Anuluj upload</span>
				</button>
				<button type="button" class="btn btn-danger delete">
					<i class="icon-trash icon-white"></i>
					<span>Usuń</span>
				</button>
				<input type="checkbox" class="toggle">
			</div>
			<!-- The global progress information -->
			<div class="span5 fileupload-progress fade">
				<!-- The global progress bar -->
				<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
					<div class="bar" style="width:0%;"></div>
				</div>
				<!-- The extended global progress information -->
				<div class="progress-extended">&nbsp;</div>
			</div>
		</div>
		<!-- The loading indicator is shown during file processing -->
		<div class="fileupload-loading"></div>
		<br>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    {{Form::close();}}
    <br>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<tr class="template-upload fade">
		<td class="preview"><span class="fade"></span></td>
		<td class="name"><span>{%=file.name%}</span></td>
		<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
		{% if (file.error) { %}
			<td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
		{% } else if (o.files.valid && !i) { %}
			<td>
				<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width:40px;"><div class="bar" style="width:0%;"></div></div>
			</td>
			<td class="start">{% if (!o.options.autoUpload) { %}
				<button class="btn btn-primary">
					<i class="icon-upload icon-white"></i>
					<span>{%=locale.fileupload.start%}</span>
				</button>
			{% } %}</td>
		{% } else { %}
			<td colspan="2"></td>
		{% } %}
		<td class="cancel">{% if (!i) { %}
			<button class="btn btn-warning">
				<i class="icon-ban-circle icon-white"></i>
				<span>{%=locale.fileupload.cancel%}</span>
			</button>
		{% } %}</td>
	</tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<tr class="template-download fade">
		{% if (file.error) { %}
			<td></td>
			<td class="name"><span>{%=file.name%}</span></td>
			<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
			<td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
		{% } else { %}
			<td class="preview">{% if (file.thumbnail_url) { %}
				<a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
			{% } %}</td>
			<td class="name">
				<a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
			</td>
			<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
			<td colspan="2"></td>
		{% } %}
		<td class="delete">
			<button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
				<i class="icon-trash icon-white"></i>
				<span>{%=locale.fileupload.destroy%}</span>
			</button>
			<input type="checkbox" name="delete" value="1">
		</td>
	</tr>
{% } %}
</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
{{HTML::script('js/vendor/jquery.ui.widget.js');}}
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<script src="http://blueimp.github.com/cdn/js/bootstrap.min.js"></script>
<script src="http://blueimp.github.com/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
{{HTML::script('js/jquery.iframe-transport.js');}}
<!-- The basic File Upload plugin -->
{{HTML::script('js/jquery.fileupload.js');}}
<!-- The File Upload file processing plugin -->
{{HTML::script('js/jquery.fileupload-fp.js');}}
<!-- The File Upload user interface plugin -->
{{HTML::script('js/jquery.fileupload-ui.js');}}
<!-- The localization script -->
{{HTML::script('js/locale.js');}}
<!-- The main application script -->
{{HTML::script('js/main.js');}}
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->
@endsection