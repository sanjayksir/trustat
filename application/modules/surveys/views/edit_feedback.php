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
 		<div class="form-group row">
			<div class="col-sm-12">
			<label for="form-field-8">Question</label>
			<input name="customer_code" id="customer_code" type="text" class="form-control" value="<?php echo $random_no;?>" >
			 
			</div>
			
			
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Answer1:</label>
             <input name="answer1" id="answer1" type="text" class="form-control" placeholder="answer1"  maxlength="50">
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Answer2:</label>
             <input name="answer2" id="answer2" type="text" class="form-control" placeholder="Phone No." maxlength="12">
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Answer3:</label>
             <input name="answer3" id="answer3" type="text" class="form-control" placeholder="Email ID"  maxlength="50">
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Answer4:</label>
             <input name="answer4" id="answer4" type="text" class="form-control" placeholder="Phone No." maxlength="12">
			</div>
		</div>
		 
		
		 
            <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />

          </div>

        </div>

      </form>

    </div>

  </div>

</div>
 