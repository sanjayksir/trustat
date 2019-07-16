<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">Add Question</h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
     </div>
     <div class="widget-body">
     <div id="ajax_msg"></div>
       </div>
       <form name="user_frm" id="user_frm" action="#" method="POST">
         <div class="widget-main">
		 <input name="ProductID" id="ProductID" type="hidden" value="<?php echo basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); ?>" class="form-control">
		 <div class="form-group row">
			<div class="col-sm-12">
			<label for="form-field-8">Question Type</label> <?php //echo basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); ?>
			<select name="QuestionType" id="questiontype" class="form-control" >
              <option value="0">-Select Question Type</option>
                    <!--<option value="Product Description Feedback">Product Description Feedback</option>-->
					<option value="Product">Product Image Feedback</option>
					<option value="Product" selected>Product Video Feedback</option>
					<option value="Product">Product Audio Feedback</option>
					<option value="Product">Product PDF Feedback</option>
             </select>
			</div>
		</div>
		
				<div class="form-group row">
			<div class="col-sm-12">
			<label for="form-field-8">Media Type</label> <?php //echo basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); ?>
			<select name="MediaType" id="MediaType" class="form-control">
              <option value="0">-Select Media Type</option>				           
                    <option value="Video" selected>Video</option>
					<option value="Audio">Audio</option>
					<option value="Image">Image</option>
					<option value="PDF">PDF</option>					
             </select>			 
			</div>	
		</div>
		 
 		<div class="form-group row">
			<div class="col-sm-12">
			<label for="form-field-8">Question</label>
			<input name="Question" id="Question" type="text" class="form-control">
			 
			</div>
			
			
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Answer1:</label>
             <input name="answer1" id="answer1" type="text" class="form-control" placeholder="Option 1"  maxlength="150">
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Answer2:</label>
             <input name="answer2" id="answer2" type="text" class="form-control" placeholder="Option 2" maxlength="150">
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Answer3:</label>
             <input name="answer3" id="answer3" type="text" class="form-control" placeholder="Option 3"  maxlength="150">
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Answer4:</label>
             <input name="answer4" id="answer4" type="text" class="form-control" placeholder="Option 4" maxlength="150">
			</div>
		</div>
        
        <div class="form-group row">
			<div class="col-sm-4">
			 <label for="form-field-8">Correct Answer:</label>
             <select name="correctAns" id="correctAns" class="form-control" >
              <option value="0">-Select Answer</option>
				  <?php  for($i=1;$i<=4;$i++){?>         
                    <option value="<?php echo $i;?>"><?php echo 'Option '.$i;?></option>
                  <?php }?>
             </select>
			</div>
			 
		</div>
		 
		
		 
            <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Save Question" id="save" onClick="this.disabled=true; this.value='Saving…';" />

          </div>

        </div>

      </form>
   
    </div>

  </div>

</div>
 