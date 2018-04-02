<div class="col-xs-12">
  <div class="widget-box">
    <div class="widget-header">
      <h4 class="widget-title">Add Menu</h4>
      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
    </div>
    <div class="widget-body">
      
      <form name="frm" id="frm" action="#" method="POST">
        <div class="widget-main">
          <div>
            <label for="form-field-8">Menu Title</label>
            <input name="title" id="title" type="text" class="form-control" placeholder="Default Text" onblur="return Url(this.value);">
          </div>
          <hr>
          <div>
            <label for="form-field-9">Menu Url</label>
            <input name="url" id="url" type="text" class="form-control"  placeholder="Default Text">
          </div>
          <hr>
          <div>
            <label for="form-field-11">Menu Order in list </label>
            <input name="order" id="order" type="text" class="form-control" placeholder="Default Text">
          </div>
          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
            <input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
