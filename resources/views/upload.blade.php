@extends('layouts.main')

@section('css')
	<link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
	<style type="text/css">
		.removeImage {  position: absolute; right: 15px; top: 10px; border-radius: 50%; padding: 5px; cursor: pointer; }
		.upldPhoto{ text-align: center; margin-bottom: 20px; }
	</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Upload</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
				</div>
				
				<!-- <div class="dropzone" id="dropzoneFileUpload">
                    <div class="dz-message">
                        <center> <h4>Drag Photos to Upload</h4>
                            <span>Or click to browse</span>
                        </center>
                    </div>
                </div> -->

                <form method="POST" action="{{ route('storeImage') }}" enctype="multipart/form-data" class="dropzone" id="my-awesome-dropzone">
                	{{ csrf_field() }}
                	<div class="fallback">
					    <input name="file" type="file" />
					</div>
                </form>

            </div>
            <div class="allImages">
            	@include('partials.imagelist')
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script async src="{{ asset('js/dropzone.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){

		var token = $('meta[name="csrf-token"]').attr('content');
		var baseUrl = "{{url('/')}}";

		$(document).on("click",".removeImage", function(e){
	        e.preventDefault();
	        var imageId = $(this).data('id');
	        $.ajax({
	            url: baseUrl + '/deleteImage/'+imageId,
	            type: 'delete',
	            data: {'_token': token},
	            success: function (result) {
	                $('.allImages').html(result.html);
	            }
	        });
	    });


		Dropzone.options.myAwesomeDropzone = {
		  paramName: "file", // The name that will be used to transfer the file
		  maxFilesize: 2, // MB
		  init: function () {
            var self = this;
            // config
            self.options.addRemoveLinks = true;
            self.options.dictRemoveFile = "Remove";
            // bind events

            /*
            * Success file upload
            */
            self.on("success", function (file, response) {
                file.serverId = response.id;
			});

            /*
            * On delete file
            */
			self.on("removedfile", function (file) {
                $.ajax({
                    url : baseUrl + '/deleteImage/'+file.serverId,
                    type: 'delete',
                    data: {'_token': token},
                    success: function (result) {
                        $('.allImages').html(result.html);
                    }
                });
            });

			/*
			* Queue completed event
			*/

			self.on("queuecomplete", function () {
                $.ajax({
                    url: "{{ route('allImages') }}",
                    type: "get",
                    success: function (response) {
                        $('.allImages').html(response);
                    }
                });
            });
		}
		};
	})
</script>
@endsection
