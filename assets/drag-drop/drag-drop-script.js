 <!-------------- For Image Drap drop upload start------------------>
 allids1=[];
 allids2=[];
 allids3=[];
 allids4=[];
  $(".dropzoneImg").dropzone({
    url: '/backend/upload_file/uploadImages/', //url for the ajax to post
    width: 300, //width of the div
    height: 152, //height of the div
    progressBarWidth: 300, //width of the progress bars
    filesName: 'files', //name for the form submit
    margin: 0, //margin added if needed
    border: '', //border property
    background: '',
    textColor: '#ccc', //text color
    textAlign: 'center', //css style for text-align
    lineHeight: 300, //vertical text align
    text: '<label class="ace-file-input ace-file-multiple"><input multiple="" id="id-input-file-3" type="file"><span class="ace-file-container" data-title="Drop Image here or click to choose"><span class="ace-file-name" data-title="No File ..."><i class="ace-icon fa-file-image-o"></i></span></span><a class="remove" href="#"><i class=" ace-icon fa fa-times"></i></a></label>', //text inside the div
    uploadMode: 'single', //upload all files at once or upload single files, options: all or single
    progressContainer: '', //progress selector if null one will be created

    dropzoneWraper: 'nniicc-dropzoneParent', //wrap the dropzone div with custom class
    files: [], //Access to the files that are droped
    maxFileSize: '10MB', //max file size ['bytes', 'KB', 'MB', 'GB', 'TB']
    allowedFileTypes: 'jpg,png,gif,jpeg', //allowed files to be uploaded seperated by ',' jpg,png,gif
    clickToUpload: true, //click on dropzone to select files old way
    showTimer: false, //show time that has elapsed from the start of the upload,
    removeComplete: true, //delete complete progress bars when adding new files
    //functions
    load: function(){
        console.log("render done");
    },
	success: function(res, responseText){
        // alert('kam'+res.responseText);
		<!----------------Comma Separated Value--------------------->
		var Imagefile =res.responseText;
		allids1.push(Imagefile);
		$('#all_Images_list').val(allids1.join(","));
		//alert(allids1);
		<!----------------Comma Separated Value--------------------->
     },
	//callback when the div is loaded
	/*progress: function(percent, index){
	console.log(percent, index);
	$(".progress-"+index).children().css("width", percent+"%").html(percent.toFixed(0)+"%");
	}, //callback for the files procent*/
    uploadDone: function(){
     }});
	
	$(".dropzoneImg22").dropzone({
        url: '/backend/upload_file/uploadImages/', //url for the ajax to post
        margin: 20,
		filesName: 'files',
        success: function(res, responseText){
            //alert(res.responseText);
			<!----------------Comma Separated Value--------------------->
			var Imagefile =res.responseText;
 			allids1.push(Imagefile);
			$('#all_Images_list').val(allids1.join(","));
			//alert(allids1);
			<!----------------Comma Separated Value--------------------->
         }
    });
	
	
 <!-------------- For Image Drap drop upload End------------------>
 
 <!-------------- For Video Drap drop upload start------------------>
 $(".dropzoneVideo").dropzone({
    url: '/backend/upload_file/uploadDone/', //url for the ajax to post
    width: 300, //width of the div
    height: 152, //height of the div
    progressBarWidth: 300, //width of the progress bars
    filesName: 'files', //name for the form submit
    margin: 0, //margin added if needed
    border: '', //border property
    background: '',
    textColor: '#ccc', //text color
    textAlign: 'center', //css style for text-align
    lineHeight: 300, //vertical text align
    text: '<label class="ace-file-input ace-file-multiple"><input multiple="" id="id-input-file-3" type="file"><span class="ace-file-container" data-title="Drop Video here or click to choose"><span class="ace-file-name" data-title="No File ..."><i class="ace-icon fa fa-file-video-o"></i></span></span><a class="remove" href="#"><i class=" ace-icon fa fa-times"></i></a></label>', //text inside the div
    uploadMode: 'single', //upload all files at once or upload single files, options: all or single
    progressContainer: '', //progress selector if null one will be created

    dropzoneWraper: 'nniicc-dropzoneParent', //wrap the dropzone div with custom class
    files: [], //Access to the files that are droped
    maxFileSize: '10MB', //max file size ['bytes', 'KB', 'MB', 'GB', 'TB']
    allowedFileTypes: 'mp4', //allowed files to be uploaded seperated by ',' jpg,png,gif
    clickToUpload: true, //click on dropzone to select files old way
    showTimer: false, //show time that has elapsed from the start of the upload,
    removeComplete: true, //delete complete progress bars when adding new files

    //functions
    load: function(){
		ajaxuploadFile('mp4');
        console.log("render done");
    }, //callback when the div is loaded
    /*progress: function(percent, index){
        console.log(percent, index);
        $(".progress-"+index).children().css("width", percent+"%").html(percent.toFixed(0)+"%");
    }, //callback for the files procent*/
    uploadDone: function(){
       // alert("Upload done");
    }}); 
<!-------------- For Video Drap drop upload End------------------>

<!-------------- For Audio Drap drop upload start------------------>
/*$('.dropzone22').dropzone ({
        url: '/spideybuzz/backend/upload_file/uploadAttachment/',
        init: function() {
            this.on("sending", function(file, xhr, formData){
                formData.append("fpos", 777)
            }),
            this.on("success", function(file, xhr){
                alert(file.xhr.response);
            })
        },
});
*/
 $(".dropzoneAudio").dropzone({
    url: '/backend/upload_file/uploadAudio/', //url for the ajax to post
    width: 300, //width of the div
    height: 152, //height of the div
    progressBarWidth: 300, //width of the progress bars
    filesName: 'files', //name for the form submit
    margin: 0, //margin added if needed
    border: '', //border property
    background: '',
    textColor: '#ccc', //text color
    textAlign: 'center', //css style for text-align
    lineHeight: 300, //vertical text align
    text: '<label class="ace-file-input ace-file-multiple"><input multiple="" id="id-input-file-3" type="file"><span class="ace-file-container" data-title="Drop MP3 here or click to choose"><span class="ace-file-name" data-title="No File ..."><i class="ace-icon fa fa-file-audio-o"></i></span></span><a class="remove" href="#"><i class=" ace-icon fa fa-times"></i></a></label>', //text inside the div
    uploadMode: 'single', //upload all files at once or upload single files, options: all or single
    progressContainer: '', //progress selector if null one will be created
     dropzoneWraper: 'nniicc-dropzoneParent', //wrap the dropzone div with custom class
    files: [], //Access to the files that are droped
    maxFileSize: '10MB', //max file size ['bytes', 'KB', 'MB', 'GB', 'TB']
    allowedFileTypes: 'mp3', //allowed files to be uploaded seperated by ',' jpg,png,gif
    clickToUpload: true, //click on dropzone to select files old way
    showTimer: false, //show time that has elapsed from the start of the upload,
    removeComplete: true, //delete complete progress bars when adding new files

    //functions
    load: function(){
        console.log("render done");
    },  success: function(res, responseText){
             //alert(res.responseText);
			<!----------------Comma Separated Value--------------------->
			var Audiofile =res.responseText;
 			allids2.push(Audiofile);
			$('#all_audios_list').val(allids2.join(","));
			//alert(allids1);
			<!----------------Comma Separated Value--------------------->
         },
    uploadDone: function(){
       // alert("Upload done");
    }}); 
<!-------------- For Audio Drap drop upload End------------------>


<!-------------- For Attachment Drap drop upload start------------------>
 $(".dropzoneAttachment").dropzone({
     url: '/backend/upload_file/uploadAttachment/', //url for the ajax to post
    width: 300, //width of the div
    height: 152, //height of the div
    progressBarWidth: 300, //width of the progress bars
    filesName: 'files', //name for the form submit
    margin: 0, //margin added if needed
    border: '', //border property
    background: '',
    textColor: '#ccc', //text color
    textAlign: 'center', //css style for text-align
    lineHeight: 300, //vertical text align
    text: '<label class="ace-file-input ace-file-multiple"><input multiple="" id="id-input-file-3" type="file"><span class="ace-file-container" data-title="Drop Attachment here or click to choose"><span class="ace-file-name" data-title="No File ..."><i class="ace-icon fa fa-file-text"></i></span></span><a class="remove" href="#"><i class=" ace-icon fa fa-times"></i></a></label>', //text inside the div
    uploadMode: 'single', //upload all files at once or upload single files, options: all or single
    progressContainer: '', //progress selector if null one will be created
    dropzoneWraper: 'nniicc-dropzoneParent', //wrap the dropzone div with custom class
    files: [], //Access to the files that are droped
    maxFileSize: '10MB', //max file size ['bytes', 'KB', 'MB', 'GB', 'TB']
    allowedFileTypes: 'pdf', //allowed files to be uploaded seperated by ',' jpg,png,gif
    clickToUpload: true, //click on dropzone to select files old way
    showTimer: false, //show time that has elapsed from the start of the upload,
    removeComplete: true, //delete complete progress bars when adding new files
    //functions
    load: function(){
        console.log("render done");
    },
	success: function(res, responseText){
		 //alert(res.responseText);
		<!----------------Comma Separated Value--------------------->
		var Attachment =res.responseText;
		//alert(Attachment);
 		allids4.push(Attachment);
		$('#all_attachments_list').val(allids4.join(","));
		// alert(allids4);
		<!----------------Comma Separated Value--------------------->
    },  
    uploadDone: function(){
		//alert("Upload done");
    }}); 
<!-------------- For Attachment Drap drop upload End------------------>