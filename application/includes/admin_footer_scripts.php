		<!-- page specific plugin scripts -->

		<script src="<?php echo ASSETS_PATH;?>js/jquery.dataTables.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/dataTables.buttons.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/buttons.flash.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/buttons.html5.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/buttons.print.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/buttons.colVis.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/dataTables.select.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/bootstrap-tab.js"></script>

		<script src="<?php echo ASSETS_PATH;?>js/spinbox.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/bootstrap-timepicker.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/moment.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/daterangepicker.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/bootstrap-datetimepicker.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/bootstrap-colorpicker.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/jquery.knob.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/autosize.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/jquery.inputlimiter.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/jquery.maskedinput.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/bootstrap-tag.min.js"></script>

		<!-- Editor Specific -->
		<script src="<?php echo ASSETS_PATH;?>js/markdown.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/bootstrap-markdown.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/jquery.hotkeys.index.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/bootstrap-wysiwyg.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/bootbox.js"></script>

		<!-- ace scripts -->
		<script src="<?php echo ASSETS_PATH;?>js/ace-elements.min.js"></script>
		<script src="<?php echo ASSETS_PATH;?>js/ace.min.js"></script>

		<!-- jQuery Validation Library -->
		<script src="<?php echo ASSETS_PATH;?>js/jquery.validate.js"></script>

		<!-- Notification script for every 10 seconds -->
		<script type="text/javascript">
		 function get_notification(){
			var feedback = $.ajax({
				type: "POST",
				dataType:"html",
				url: "<?php echo base_url().'buzzadmn/editorial/show_notifications/';?>",
				async: false
			}).success(function(response){
				setTimeout(function(){
						get_notification();
				}, 10000);
			}).responseText;
 				//$('div.text-info').html(feedback);
				 var resDataRESULT = JSON.parse(feedback);
 				 
				 if (! $.isEmptyObject(resDataRESULT.resData)) {
					//$('#notifications-box').show('slow');
 				 	setTimeout(function(){
 					 var str = resDataRESULT.resData.title;
					 var id = resDataRESULT.resData.id;
					 if(str.length > 40){
						 str = str.substring(0,30)+'..';
					 }
					 var linkStr  = '<a href="<?php echo base_url().'view_story_idea/';?>'+id+'">'+str+'</a>';
  					 $("#story_title").html(linkStr);
			     	 $("#reported_by").html(resDataRESULT.resData.user_name); 
					 //$('#notifications-box').css({'position':'absolute', 'width':'380px'}).animate({"left":"100%"});

					 $('#notifications-box').show('slow').delay(7000);;

					 update_notification(resDataRESULT.resData.id);
					  $('#notifications-box').hide('slow');
				  }, 5000);
				 }
 	 			//$('#notifications-box').hide();
  			}
			
 		//get_notification();	
		
		function update_notification(id){
			$.ajax({
				'url': "<?php echo base_url().'buzzadmn/editorial/update_notifications/';?>",
				data:{"id":id},
				type:"POST",
				success:function(msg){
				}					
			})
		}
			
		function close_notification(){
			$('#notifications-box').css({'position':'fixed','right':'0px' ,'bottom':'10px' ,'width':'380px'}).animate({"left":"100%"});
				 
		}
	  </script>
