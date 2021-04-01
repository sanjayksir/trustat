<script type="text/javascript">
function showHide_fld(cls, fld, span){ 
	var isChecked = $("."+cls).prop('checked');
	if(isChecked==true){
		$("#"+fld).show('slow');
		$("#"+span).show('slow');
	}else{
		$("#"+fld).hide('slow');
		$("#"+span).hide('slow');
	}
}
function showHide_special(cls, fld, span){ 
	var isChecked = $("."+cls).prop('checked');
	if(isChecked==true){
		$("#"+fld).show('slow');
		$("#"+span).show('slow');
		$("#enable_special_section").css('display','');
	}else{
		$("#"+fld).hide('slow');
		$("#"+span).hide('slow');
		$("#enable_special_section").css('display','none');
	}
}
 $( function() {
    $('.date-picker').datepicker({
                                autoclose: true,
                                todayHighlight: true,
                                format: 'dd-mm-yyyy',
								startDate: '0',
                })
                .next().on(ace.click_event, function(){  //show datepicker when clicking on the icon
                                $(this).prev().focus();
                });

                // Date Range - Release date must ne greater than equal to Release date
                $("#start_special_section").datepicker({
                                format: 'dd-mm-yyyy',
                                autoclose: true,
                }).on('changeDate', function (selected) {
                                var startDate = new Date(selected.date.valueOf());
                                $('#end_special_section').datepicker('setStartDate', startDate);
                });

                $("#end_special_section").datepicker({
                                format: 'dd-mm-yyyy',
                                autoclose: true,
                }).on('changeDate', function (selected) {
                                var endDate = new Date(selected.date.valueOf());
                                $('#start_special_section').datepicker('setEndDate', endDate);
                });

  } );	
//amlesh upload image
$(document).on('click', '.browse', function(){
  var file = $(this).parent().parent().parent().find('.file');
  file.trigger('click');
});

$(document).on('change', '.file', function(){
  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});
//amlesh upload image									

bkLib.onDomLoaded(function () {
	new nicEditor({
		maxHeight: 100,
		buttonList: ['fontSize', 'bold', 'italic', 'underline']
	}).panelInstance('headline');
	new nicEditor({fullPanel: true}).panelInstance('pickDesc');
	var editor = nicEditors.findEditor('headline');
	editor.getElm().onkeyup = function () {
		nicCount(editor, 'mycounter1', 250);
	}

	$('.nicEdit-main')[0].addClass('short_desc');
	$('.nicEdit-main')[1].addClass('full_desc');
});

function spideyAutoSave() {
	/*$.post('/spideypicks/Buzzadmn/saveAutoSaveSpidyBuzz',
	 $("#spidey_buyzz_save").serialize(),
	 function (result) {
	 if (document.getElementById('spidypickId').value == '')
	 $('#spidypickId').val(result);
	 //console.log('result - ' + result);
	 });

	 setInterval(function () {
	 spideyAutoSave();
	 }, 1000 * 120);*/
}

$(document).ready(function () {
	setTimeout(function () {
		$(".nicEdit-short_desc").keyup(function () {
			//console.log($(this).html());
			document.getElementById('headline').innerHTML = $(this).html();
		});
		$(".nicEdit-full_desc").keyup(function () {
			//console.log($(this).html());
			document.getElementById('pickDesc').innerHTML = $(this).html();
		});
	}, 1000);
	
	
	
});

function getSubcategory(val){
$("#sub_category_id").html('<option value="">-Select Sub Category-</option>');  
if(val!=''){
$.ajax({
	type: "POST",
	url:"<?php echo base_url().'buzzadmn/getSubCategoryList'?>",
	data: {id:val},
	   success: function (res) {
		  if(res!='' ) {
			$("#sub_category_id").append(res);  	
		  }	
	   }
	})
}
}

 
function form_validate(){
	 
	var isSubmit 	= true;
	var title 		= $("#title").val();
	var subHeadLine = $("#subHeadLine").val();	
	$("#subHeadLine").css("border",'1px lightblue #555');
	var category_id = $("#category_id").val();
	$("#category_id").css("border",'1px light blue #555');
	
	var sub_category_id = $("#sub_category_id").val();
	$("#sub_category_id").css("border",'1px lightblue #555');
	var video_media = $("#video_media").val();
	$("#video_media").css("border",'1px lightblue #555');
	
	var isIframe = $("#video_media").val().indexOf("<IFRAME".toLowerCase() );
 
	if(title=='' || title.length<'10'){
		$("#title").addClass('error');	return false;
		title.focus();
		isSubmit = false;
		return false; 
	}else{
		$("#title").removeClass('error');
	}
	
	
	if(video_media!='' && (urlvalidate(video_media)==false && isIframe==-1)){
		$("#video_media").addClass('error');return false;
		video_media.focus();
		isSubmit = false;
		return false; 
	}else{
		
		
		
		
		
		
		$("#video_media").removeClass('error');
	}
	
	
	if(subHeadLine==''){
		$("#subHeadLine").addClass('error');return false;
		subHeadLine.focus();
		isSubmit = false;
		return false; 
	}else{
		$("#subHeadLine").removeClass('error');
	}
	
	
	
	
	
	
	if(category_id==''){
		$("#category_id").addClass('error');return false;
		category_id.focus();
		isSubmit = false;
		return false; 
	}else{
		$("#category_id").removeClass('error');
	} 
	
	if(sub_category_id==''){
		$("#sub_category_id").addClass('error');return false;
		sub_category_id.focus();
		isSubmit = false;
		return false; 
	}else{
		$("#sub_category_id").removeClass('error');
	}
 
	return true; 
}

 

function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}	
			
			
	//=============== Image dimention chcek =====================//
	var _URL = window.URL || window.webkitURL;
	function validateImage(files,width,height,fileID) { 
	var _URL = window.URL || window.webkitURL;
	   var file = files[0]
	   var img = new Image();
	   var sizeKB = file.size / 1024;
	   var isImage = file.type.match('image.*'); 
	   if(!(isImage)){
			   alert("Size Missmatch: Please Upload only Image"); 
				 $('#'+fileID).val('');
   				 return false;
		   }
	   img.onload = function() {
 			if(img.width!=width && img.height!=height){
 				alert("Size Missmatch: Allowed Size is: width: "  +width + " Height: " +height); 
				$('#'+fileID).val('');
   				return false;
			}
	   }
	   img.src = _URL.createObjectURL(file);
	}
	
	function validateImage2(files,width,height,fileId=	'') {
		var _URL = window.URL || window.webkitURL;
 	   var file = files[0]
	   var img = new Image();
	   var sizeKB = file.size / 1024;
	   	   var isImage = file.type.match('image.*');
	   if(!(isImage)){
			   alert("Size Missmatch: Please Upload only Image"); 
				// $('#'+fileID).val('');
   				 return false;
		   }
	   img.onload = function() {// alert(img.width+'==11=='+width+'====>'+img.height+'=='+height)
			//alert(img.width+'==11=='+width+'====>'+img.height+'=='+height)
			if(img.width<width || img.height<height){
  				alert("Min Uploaded Image Size is:: width: "  +width + " Height: " + height);
				 $('#largeImageBx').val('');return false;
 				//$(".ace-file-name").attr('data-title','No File..');
			} 
	   }
	   img.src = _URL.createObjectURL(file);
	}
 	//=============== Image dimention chcek =====================//	
	   
	function urlvalidate(url,fld){
			var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
			if (!re.test(url)) { 
 				return false;
			}
	}
   </script>