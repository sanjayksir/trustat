<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">Add Industry</h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

      

      <form name="frm" id="frm" action="#" method="POST">

        <div class="widget-main">

          <div>

            <label for="form-field-8">Industry Name</label>

            <input name="category" id="category" type="text" class="form-control" placeholder="Default Text">

          </div>

          <hr>

          <div>

            <label for="form-field-9">Parent Industry</label>

             <select name="parent" id="parent" class="form-control">

             <option value="0">-Select Parent-</option>

             <?php foreach(getAllCategory() as $val){?>

            	<option value="<?php echo $val['category_Id'];?>"><?php echo $val['categoryName'];?></option>

            <?php }?>

            </select>

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

