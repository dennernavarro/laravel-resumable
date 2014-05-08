@extends('master')

@section('content')
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <h1>Resumable.js</h1>
          <p>It's a JavaScript library providing multiple simultaneous, stable and resumable uploads via the HTML5 File API.</p>

          <p>The library is designed to introduce fault-tolerance into the upload of large files through HTTP. This is done by splitting each files into small chunks; whenever the upload of a chunk fails, uploading is retried until the procedure completes. This allows uploads to automatically resume uploading after a network connection is lost either locally or to the server. Additionally, it allows for users to pause and resume uploads without loosing state.</p>

          <p>Resumable.js relies on the HTML5 File API and the ability to chunks files into smaller pieces. Currently, this means that support is limited to Firefox 4+ and Chrome 11+.</p>

          <hr/>

          <h3>Demo</h3>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
          <script src="{{ asset('js/resumable.js') }}"></script>


          <div class="resumable-error">
          <div class="alert alert-danger alert-dismissable">
            Your browser, unfortunately, is not supported by Resumable.js. The library requires support for <a href="http://www.w3.org/TR/FileAPI/">the HTML5 File API</a> along with <a href="http://www.w3.org/TR/FileAPI/#normalization-of-params">file slicing</a>.
          </div>
          </div>

          <div id="upload-place" class="resumable-drop" ondragenter="jQuery(this).addClass('resumable-dragover');" ondragend="jQuery(this).removeClass('resumable-dragover');" ondrop="jQuery(this).removeClass('resumable-dragover');">
            Drop video files here to upload or 
            <a class="resumable-browse btn btn-success btn-lg"> select from your computer</a>
          </div>
      
          <div class="resumable-progress">
            <table>
              <tr>
                <td width="100%"><div class="progress-container"><div class="progress-bar"></div></div></td>

                <td class="progress-text" nowrap="nowrap"></td>

                <td class="progress-pause" nowrap="nowrap">
                  <a href="#" onclick="r.upload(); return(false);" class="progress-resume-link"><span class="glyphicon glyphicon-play"></span></a>
                  <a href="#" onclick="r.pause(); return(false);" class="progress-pause-link"><span class="glyphicon glyphicon-pause"></span></a>
                  <a href="#" onclick="r.cancel(); return(false);" class="progress-cancel-link"><span class="glyphicon glyphicon-remove"></span></a>
                </td>

              </tr>
            </table>
          </div>
      
      <ul class="resumable-list list-unstyled"></ul>

      <script>
        var r = new Resumable({
            target:'upload',
            chunkSize:1*1024*1024,
            simultaneousUploads:4,
            testChunks:true,
            throttleProgressCallbacks:1,
            maxFiles: 1,
            query: {
                serie_id: 999
            }
          });
        // Resumable.js isn't supported, fall back on a different method
        if(!r.support) {
          $('.resumable-error').show();
        } else {
          // Show a place for dropping/selecting files
          $('.resumable-drop').show();
          r.assignDrop($('.resumable-drop')[0]);
          r.assignBrowse($('.resumable-browse')[0]);

          // Handle file add event
          r.on('fileAdded', function(file){
              // Show progress pabr
              $('.resumable-progress, .resumable-list').show();
              // Show pause, hide resume
              $('.resumable-progress .progress-resume-link').hide();
              $('.resumable-progress .progress-pause-link').show();
              // Add the file to the list
              $('.resumable-list').append('<li class="resumable-file-'+file.uniqueIdentifier+'">Uploading <span class="resumable-file-name"></span> <span class="resumable-file-progress"></span>');
              $('.resumable-file-'+file.uniqueIdentifier+' .resumable-file-name').html(file.fileName);
              $('#upload-place').hide();
              // Actually start the upload
              r.upload();
            });
          r.on('pause', function(){
              // Show resume, hide pause
              $('.resumable-progress .progress-resume-link').show();
              $('.resumable-progress .progress-pause-link').hide();
            });
          r.on('complete', function(){
              // Hide pause/resume when the upload has completed
              $('#upload-place').show();
              $('.resumable-progress .progress-resume-link, .resumable-progress .progress-pause-link').hide();
            });
          r.on('fileSuccess', function(file,message){
              // Reflect that the file upload has completed
              $('.resumable-file-'+file.uniqueIdentifier+' .resumable-file-progress').html('(completed)');
              //console.log(file.fileName);
              document.location.href='/download?file='+file.fileName;

            });
          r.on('fileError', function(file, message){
              // Reflect that the file upload has resulted in error
              $('.resumable-file-'+file.uniqueIdentifier+' .resumable-file-progress').html('(file could not be uploaded: '+message+')');
            });
          r.on('fileProgress', function(file){
              // Handle progress for both the file and the overall upload
              $('.resumable-file-'+file.uniqueIdentifier+' .resumable-file-progress').html(Math.floor(file.progress()*100) + '%');
              $('.progress-bar').css({width:Math.floor(r.progress()*100) + '%'});
            });
          r.on('cancel', function(){
          	$('#upload-place').show();
            $('.resumable-file-progress').html('canceled');
          });
          r.on('uploadStart', function(){
              // Show pause, hide resume
              $('.resumable-progress .progress-resume-link').hide();
              $('.resumable-progress .progress-pause-link').show();
          });
        }
      </script>

          </div>
        </div>
      </div>
@stop


    
