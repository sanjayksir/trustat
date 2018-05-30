<script>
//========= js code ===========

function filesValidation(type){
	$('#extra-progress-wrapperID').hide();
	var f2 				=	$.trim($("#videoFile").val());
	var validateFlag 	= 	true;
	if (f2 == null || f2 == "") {
		$('#extra-progress-wrapperID').show();
		$('#videoFile_err').html("Please choose video file");
	  	$('#videoFile_err').show();
		validateFlag = false;
	}else{
		var ext = f2.substring(f2.lastIndexOf('.') + 1);
		ext 	=	ext.toLowerCase();
		if(ext != type ){//&& ext != "jpg" && ext != "png" && ext != "gif" && ext != "mp3"){
 			$('#innerDivHide').hide();
			$.trim($("#offStart").val('0'));
			$.trim($("#videosupload").val(''));
			$.trim($("#ugc_video_size").html(''));
			$('#video_progBar').css('width','0%'); 
			$('#videoProgBar').hide();
			$('#extra-progress-wrapperID').show();
			$('#videoFile_err').addClass('ugc_browseerror');
			$('#videoFile_err').html("Please choose only "+type+" file");
			$('#videoFile_err').show();
			validateFlag = false;	 
		}else{
			var files = document.getElementById('videoFile').files;
			var videofile = files[0];
			var fileDivideSize	=	1*1024*1024;
			var sizevideo =( videofile.size/fileDivideSize).toFixed(2);
			if(sizevideo<=200){	
				var videofilename = '';//videofile.name;
				$('#ugc_video_size').show();
				//document.getElementById("ugc_video_size").innerHTML ="Size "+(videofile.size/fileDivideSize).toFixed(2)+" MB video uploading";									
				document.getElementById("filename").innerHTML = videofilename.substring(0, videofilename.lastIndexOf(".") + 0);	
				$('#innerDivHide').show();	
				$('#extra-progress-wrapperID').hide();			
				$('#videoFile_error').hide();
				$('#videoFile_error').html();
				$('#videoFile_err').hide();
				if(validateFlag) validateFlag 	= 	true;
			}else{
				$('#extra-progress-wrapperID').show();
				html("Please choose max 200 MB file");
				$('#extra-progress-wrapperID').show();
				$('#videoFile_err').show();
				validateFlag = false;
			}
		}			
	}
	
	return validateFlag;	
}
var closeStatus = 0;
function ajaxuploadFile(type){
	$('#video_progBar').css('width','0%');
	document.getElementById("videosupload").value="";
	document.getElementById("offStart").value=0;
	document.getElementById("videosupload").value="";
	document.getElementById("ugc_video_size").value="";
	$("#videoupload").hide();
	var counter = 1;
	var fileFlag = filesValidation(type);
	if(fileFlag){
    closeStatus = 0;
	readBlob('videoFile');
	$("#hideBrowseButton").hide();
	$("#removeFade").hide();
	}
}
var counter = 1;
var start = 0;
var end = 2*1024*1024;
var videofile;
var resumableIdentifier;
var totalChunk;
var vfilename = "";
function readBlob(id){
	end = 2*1024*1024;
	var fileDivideSize	=	1*1024*1024;
	if(document.getElementById("offStart").value >1){
	  counter = document.getElementById("offStart").value;
	  start = counter*end;
	  end = start + 2*1024*1024;
	  counter++;
	}else{
	  start = 0;
	}
	var videoddate = new Date();
	var videotime = videoddate.getTime();

	totalChunk = 0;
	vfilename = "";
    var files = document.getElementById(id).files;
	var vid   =	document.getElementById("token").value;
	
    videofile = files[0];
	dots = videofile.name.split(".")
	fileType = "." + dots[dots.length-1];
	//document.getElementById("filesize").innerHTML = (videofile.size/fileDivideSize).toFixed(2)+" MB";
	totalChunk = Math.ceil(videofile.size/end);
	vfilename = "video_"+vid+"_"+videotime+fileType;
	document.getElementById("videonewfile").value=vfilename;
	document.getElementById("savetoken").value="video_"+vid+"_"+videotime;
	
	resumableIdentifier = 'video_'+videotime;
	//movePointer(counter,start,end);
	movePointer(counter,start,end,totalChunk);
}

function movePointer(counter,start,end,totalChunk){
	var blob = videofile.slice(start, end);
	if( start < videofile.size ) {
		uploadFile(blob, counter,videofile.size,vfilename,totalChunk,end);
		//$("#videosaction").prop('disabled', true);
	}else{	
		//success
		if(closeStatus==0){
		document.getElementById("offStart").value = 1; 
		document.getElementById("videoFile").value="";
		document.getElementById("videosupload").value="sucess";
		$('#innerDivHide').show();
		$('#videoupload').show();
		//$("#videosaction").prop('disabled', false);
		}
	}	
}

function uploadFile(blobFile, part,fsize,name,totalChunk,end) {
	$("#progressHide").hide();		
	var videoBaseUrl 	= 	$.trim($("#videoBaseUrl").val());	
	var fd = new FormData();    
	fd.append( 'file', blobFile );
	fd.append( 'resumableIdentifier', resumableIdentifier );
	fd.append( 'resumableFilename', name );
	fd.append( 'resumableChunkNumber', part );
	fd.append( 'resumableChunkSize', blobFile.size );
	fd.append( 'resumableTotalSize', fsize );
	fd.append( 'totalChunk', totalChunk );
	var progressVal =  Math.ceil((part*100)/totalChunk);
	var chunkdate = new Date();
	var chunktime = chunkdate.getTime();
	 $('#videoProgBar, #progressHide').show();	
	$.ajax({
		url:"<?php echo base_url();?>uploads/product/upload_ProductMediafiles/"+chunktime,
		 data: fd,
		 processData: false,
		 contentType: false,
		 type: 'POST',
		 beforeSend: function(){
     				//$("#videoupload").show().text('Uploading Video.....');
					//$(':input[type="submit"]').prop('disabled', true);
   		},
		 
		
		
		
		
		 success: function(data){
			   if(data==1){
					//dataReset('hide');
					$('#extra-progress-wrapperID').show();
					$('#videoFile_err').addClass('ugc_browseerror');
					$('#videoFile_err').html("Please choose only mp4 video file");
					$('#videoFile_err').show();
				}else{
					if(closeStatus==0){
						document.getElementById("offStart").value = part;
								
						part++;
						start = end;
						end = start + 2*1024*1024;
						movePointer(part,start,end,totalChunk);
						 progress(progressVal, $('#videoProgBar'));	 
						 $('#video_progBar').css('width',progressVal+'%');
						 $("#video_progBar").text(progressVal+'%');
						
						
						if(parseInt(progressVal)==100){
 							<!----------------Comma Separated Value--------------------->
							var videonewfile = $("#videonewfile").val(); 
							allids=[];
							allids.push(videonewfile);
							$('#all_videos_list').val(allids.join(","));
							<!----------------Comma Separated Value--------------------->
  							//$("#progressHide").hide();						
							//$("#videoupload").show().text('Video successfully uploaded.').css('color','green');
							//$(':input[type="submit"]').prop('disabled', false); 
 						}
					}
				}
				$("#hideBrowseButton").show();
		 },
		 error: function (ajaxContext) {
			//alert(ajaxContext.responseText)
			console.log("netIssue");
		}
	});
  }
  function progress(percent, $element) {
   $('#progBar').attr('value',percent);
  }
  window.addEventListener('online',  resumeUpload);
 function resumeUpload(){
	var f2	=	$.trim($("#videoFile").val());
	if(f2 != null || f2 != "") {
	  end = 2*1024*1024;
	  counter = document.getElementById("offStart").value;
	  start = counter*end;
	  end = start + 2*1024*1024;
	  counter++;
	  var files = document.getElementById("videoFile").files;
	  var videofile = files[0];
	   var divideSize	=	2*1024*1024;
		totalChunk = Math.ceil(videofile.size/divideSize);
	  movePointer(counter,start,end,totalChunk);
	}
}
function validateUgcVideo()
{
	var validateFlag = true;
   	if ($.trim($("#videosupload").val()) == '') {
		$('#extra-progress-wrapperID').show();
	  	$('#videoFile_err').html("Please choose video file");
		$('#videoFile_err').show(); 
		$('#videoFile_err').fadeOut(4000); 
        validateFlag= false;
   }   
	else if ($.trim($("#videoHeadline").val()) == '') {	
		$("#videoHeadline").focus();
		$('#videoHeadline_err').show(); 
		$('#videoHeadline_err').fadeOut(3500); 
        validateFlag= false;
   }    
	else if ($.trim($("#videosCategory").val()) == '') {
		$('#videosCategory_err').show(); 
		$('#videosCategory_err').fadeOut(4000); 
        validateFlag =  false;
   }    
   else if ($.trim($("#videosCategory").val()) == '10' && $.trim($("#videosCategoryOption").val()) == '') {	 
		$("#videosCategoryOption").focus();
		$('#videosCategoryOption_err').show(); 
		$('#videosCategoryOption_err').fadeOut(4000); 
       validateFlag= false;		
	} 	  
   else {
			var videosCategory 			= 	$.trim($("#videosCategory").val());
			var videosCategoryOption 	= 	$.trim($("#videosCategoryOption").val());
			var videoHeadline			= 	encodeURIComponent($.trim($("#videoHeadline").val()));
			var videosKeywords			= 	encodeURIComponent($.trim($("#videosKeywords").val()));
			var savetoken				= 	$.trim($("#savetoken").val());
			var folder_path				= 	$.trim($("#folder_path").val());
			var videonewfile			= 	$.trim($("#videonewfile").val());			
			var videoDescription		= 	encodeURIComponent($.trim($("#videoDescription").val()));
			var videoBaseUrl 			= 	$.trim($("#videoBaseUrl").val());	
			var fname 					= 	$.trim($("#fname").val());
			var state_name 				= 	$.trim($("#state_name").val());
			var city_name				= 	$.trim($("#city_name").val());
			var country 				= 	$.trim($("#country").val());
			var uid 					= 	$.trim($("#uid").val());	
			$("#video_loader").css("display", "block");
			//$("#videosaction").prop('disabled', true);		
	           $.ajax({
                type:"POST",
                        url:videoBaseUrl+"ugc-save/",
                        data: {videosCategory:videosCategory, videosCategoryOption:videosCategoryOption, videoHeadline:videoHeadline, savetoken:savetoken, videonewfile:videonewfile,videoDescription:videoDescription,videosKeywords:videosKeywords,folder_path:folder_path,requestType:'savevideo',uid:uid,fname:fname,state_name:state_name,city_name:city_name,country:country},
                        success: function(response) {						
							$("#video_loader").css("display", "none");
							if ( response.indexOf("saved") > -1 ) {							
							$('#videos_msg').html("<div class='ugc_popdiv'><div class='ugc_popcontent'><div class='ugc_ptext'><h6>Dear "+ fname +"</h6><p>Your video is uploaded successfully. It would be visible on user videos after moderation. Thanks for your patience.</p></div></div></div>").fadeIn('slow');
							$('#videos_msg').delay(3000).fadeOut('slow');
							$('#videoProgBar').hide();														
							document.getElementById("ugc_video_form").reset();
							var newUrlStringObj = new Date();
							var newUrlString = newUrlStringObj.getTime();					
							setTimeout(function () {
								window.location.href="/ugc-insight-page/";
							}, 2000);
							} else { 							
									$('#videos_msg').html("Videos not saved.").fadeIn('slow');
									$('#videos_msg').delay(2000).fadeOut('slow');
								  }                            
                        },
                        error: function(errResponse) {
						$("#video_loader").css("display", "none");
                        console.log(response);
                        }
                });
				//$("#videosaction").prop('disabled', false);
	
	}
	return false;
   
}

function ugcGetSelectVideoVal(sel)
{
	if (sel.value == '10') {
		$('#video_type').show(); 
	} else {
		$('#video_type').hide(); 
	}
}

var maxVideoLength = 250;
$('#videoDescription').keyup(function() {
var length = $(this).val().length;
if(length <= maxVideoLength) {
 $('#video_characters').text(length);
} else {
	$('#max_video_char_err').show(); 
	$('#max_video_char_err').fadeOut(4000); 
}

});
//========== End Code =========
</script>