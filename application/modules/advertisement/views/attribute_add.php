<?php $this->load->view('../includes/admin_header');?>

<?php $this->load->view('../includes/admin_top_navigation');?>
<?php  //$getLevel = getAttrDepth($this->uri->segment(3),1); 
$arr = array();
$uri = $uri=$this->uri->segment(3);
$currentData = json_decode(getLevelByID($uri),true);
$lavel = $currentData['lavel'];
$pid = $currentData['parent'];
$arr[0][$lavel] = $pid.'-'.$uri;
 if($lavel>1){
 	$currentData = json_decode(getLevelByID($pid),true);
	$lavel2 = $currentData['lavel'];
	$pid2 = $currentData['parent'];
	$arr[1][$lavel2] = $pid2.'-'.$pid;
 }
 if($lavel>2){
 
 	$currentData = json_decode(getLevelByID($pid2),true);
	$lavel3 = $currentData['lavel'];
	$pid3 = $currentData['parent'];
	$arr[2][$lavel3] = $pid3.'-'.$pid2;;
	 
 }
  if($lavel>3){
 
 	$currentData = json_decode(getLevelByID($pid3),true);
	$lavel4 = $currentData['lavel'];
	$pid4 = $currentData['parent'];
	$arr[3][$lavel4] = $pid4.'-'.$pid3;
	 
 }
//$getArr = checkLavels($pid);
 
$getArray = array_reverse($arr);
//echo '***'.count($getArray);
 //echo '<pre>';print_r($getArray);exit;
 
?>
  <div class="main-container ace-save-state" id="main-container">

			<script type="text/javascript">

				try{ace.settings.loadState('main-container')}catch(e){}

			</script>
			
<style>.entry:not(:first-of-type)
{
    margin-top: 10px;
}
 .glyphicon
{
    font-size: 12px;
}</style>


			<?php $this->load->view('../includes/admin_sidebar');?>



			<div class="main-content">

				<div class="main-content-inner">

					<div class="breadcrumbs ace-save-state" id="breadcrumbs">

						<ul class="breadcrumb">

							<li>

								<i class="ace-icon fa fa-home home-icon"></i>

								<a href="#">Home</a>

							</li>



							<li>

								<a href="#">Attribute</a>

							</li>

							<li class="active">Edit Attribute</li>

						</ul><!-- /.breadcrumb -->
 
					</div>
   					<div class="page-content">
 
						<div class="page-header">

							<h1>Edit Attribute</h1>

						</div><!-- /.page-header -->

 						<div class="row">

							<div class="col-xs-12">

								<!-- PAGE CONTENT BEGINS -->



								<?php if($this->session->flashdata('success')): ?>

									<div class="alert alert-block alert-success">

										<button type="button" class="close" data-dismiss="alert">

											<i class="ace-icon fa fa-times"></i>

										</button>



										<i class="ace-icon fa fa-check green"></i>



										<?php echo $this->session->flashdata('success'); ?>

									</div>

		                        <?php endif; ?>
								
								
								<?php if(count($listData)>0){ ?>

									<div class="alert alert-block alert-success">
										Product Attribute-<?php echo '<b>'.getProduct_name($listData[0]['product_id']).'</b>'; ?>

									</div>

		                        <?php } ?>
					<div class="controls"> 
                	<?php echo form_open( 'product/update_attributes', array('class' => 'form-horizontal', 'id' => 'addprduct', 'role' => 'form' ) ); ?>
					<input type="text" name="hid_id" value="<?php echo $this->uri->segment(3);?>" 
					<input name="id"  value="<?php echo $this->uri->segment(3);?>" type="hidden">
					<div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
             			<input class="btn btn-info" name="submit" value="Save Property" id="property" type="submit">
					</div>
					
					
		  <div class="form-group row">
			<div class="col-sm-3">
			<label for="form-field-8">Parent Attribute</label>
			<?php $getId = explode('-',$getArray[0][1]);
			if(count($getArray)>1){
			?>
			<select class="form-control">
           <?php foreach(getAllattributes() as $val){
		   				if($val['product_id']==$getId[1]){?>
            	<option value="<?php echo $val['product_id'];?>"><?php echo $val['name'];?></option>
            <?php }}?>
            </select>
			<?php }else{?>
			
			 <?php 
					foreach(getAllattributes() as $val){
						if($val['product_id']==$getId[1]){
					?><input type="text" name="product_attr" id="product_attr" class="form-control" value="<?php echo $val['name'];?>" />
					 
					<?php }}?>
			
			<?php }?>
			</div>
            <?php $getId2 = explode('-',$getArray[1][2]);
			if(count($getArray)>2){
 			//$p_id = getAttrIDFromParentID($uri);?>
            <div class="col-sm-3">
				<label for="form-field-8">Child Attribute (Level2)</label>
				<select class="form-control">
				 
				<?php foreach(getAllattributes($getId[1]) as $val){
						if($val['product_id']==$getId2[1]){
					?>
					<option value="<?php echo $val['product_id'];?>"><?php echo $val['name'];?></option>
				 <?php 	}
				 }?>
				 </select>
			</div>
			<?php }else{?>
			
				 <?php 
					foreach(getAllattributes($getId[1]) as $val){
						if($val['product_id']==$getId2[1]){
					?><div class="col-sm-3">
				<label for="form-field-8">Child Attribute (Level2)</label><input type="text" name="product_attr" id="product_attr" class="form-control" value="<?php echo $val['name'];?>" /></div>
					 
					<?php }}?>
				
			<?php }?>
			<?php 
			$getId3 = explode('-',$getArray[2][3]);
			if(count($getArray)>3){
			?>
			<div class="col-sm-3">
			  <label for="form-field-8">Child Attribute (Level3)</label>
             	<select class="form-control" >
            		 
					<?php foreach(getAllattributes($getId2[1]) as $val){
				if($val['product_id']==$getId3[1]){
			?>
             	<option value="<?php echo $val['product_id'];?>"><?php echo $val['name'];?></option>
             <?php }}?>
             	</select>
			</div>
			<?php }else{?>
			
			  <?php 
			  foreach(getAllattributes($getId2[1]) as $val){
				if($val['product_id']==$getId3[1]){
				?><div class="col-sm-3">
			  <label for="form-field-8">Child Attribute (Level3)</label>
				<input type="text" name="product_attr" id="product_attr" class="form-control" value="<?php echo $val['name'];?>" /></div>
			<?php }}?>
			
			<?php }?>
			<?php if(count($getArray)==4){
			$getId4 = explode('-',$getArray[3][4]);
			?>
			<div class="col-sm-3">
			  <label for="form-field-8">Child Attribute (Level4)</label>
			<?php foreach(getAllattributes($getId3[1]) as $val){
				if($val['product_id']==$getId4[1]){
			?>
				<input type="text" name="product_attr" id="product_attr" class="form-control" value="<?php echo $val['name'];?>" />
              <?php }}?>
             
			</div>
			<?php }?>
 		</div>
		
		
					 
					
                </form>
           
					</div><!-- /.page-content -->

				</div>
</div>
			</div><!-- /.main-content -->


<script> 
 


</script>
			<?php $this->load->view('../includes/admin_footer');?>

		</div><!-- /.main-container -->
 