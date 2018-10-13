<?php
		$dt = $product_image_feedback_data[0];
		?>
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
		 <input name="ProductID" id="ProductID" type="hidden" value="<?php echo $dt['product_id']; ?>" class="form-control">
		 <div class="form-group row">
			<div class="col-sm-12">
			<label for="form-field-8">Question Type-<?php echo $this->uri->segment(3); ?></label> <?php //echo basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); ?>
			<select name="QuestionType" id="questiontype" class="form-control">
              <option value="0">-Select Question Type-</option>
				           
                     <option value="Product Description Feedback">Product Description Feedback</option>
					<option value="Product Image Feedback" selected>Product Image Feedback</option>
					<option value="Product Video Feedback">Product Video Feedback</option>
					<option value="Product Audio Feedback">Product Audio Feedback</option>
					<option value="Product PDF Feedback">Product PDF Feedback</option>
					<option value="Product Pushed Ad Feedback">Product Pushed Ad Feedback</option>
					<option value="Product Survey Feedback">Product Survey Feedback</option>
					<option value="Product VDemonstration Feedback">Product Demo Video Feedback</option>
					<option value="Product ADemonstration Feedback">Product Demo Audio Feedback</option>
                  
             </select>
			 
			</div>
			
			
		</div>
		
		 <input name="QuestionID" id="QuestionID" type="hidden" value="<?php echo $dt['question_id']; ?>" class="form-control">
 		<div class="form-group row">
			<div class="col-sm-12">
			<label for="form-field-8">Question</label>
			<input name="Question" id="Question" type="text" value="<?php echo $dt['question']; ?>" class="form-control">
			 
			</div>
			
			
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Answer1:</label>
             <input name="answer1" id="answer1" type="text" value="<?php echo $dt['answer1']; ?>" class="form-control" placeholder="Option 1"  maxlength="150">
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Answer2:</label>
             <input name="answer2" id="answer2" type="text" value="<?php echo $dt['answer2']; ?>" class="form-control" placeholder="Option 2" maxlength="150">
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Answer3:</label>
             <input name="answer3" id="answer3" type="text" value="<?php echo $dt['answer3']; ?>" class="form-control" placeholder="Option 3"  maxlength="150">
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Answer4:</label>
             <input name="answer4" id="answer4" type="text" value="<?php echo $dt['answer4']; ?>" class="form-control" placeholder="Option 4" maxlength="150">
			</div>
		</div>
        
        <div class="form-group row">
			<div class="col-sm-4">
			 <label for="form-field-8">Correct Answer:</label>
             <select name="correctAns" id="correctAns" class="form-control" >
              <option value="0">-Select Answer-</option>
			 	  <?php  for($i=1;$i<=4;$i++){?>   
			       <option value="<?php echo $i;?>" <?php if ($i==$dt['correct_answer']) {?> selected <?php }?> ><?php echo 'Option '.$i;?></option>
                  <?php }?>
             </select>
			</div>
			 
		</div>
		 
		
		 
            <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Save Question" id="save" />

          </div>

        </div>

      </form>
   
    </div>

  </div>

</div>
 