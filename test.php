Super admin
1.Existing Customer http://innovigents.com/user_master/list_user/ = Page not exist
2.Existing Plant Controller http://localhost/trackingprortal20/user_master/list_plant_controllers = Done
3.Existing Plants http://localhost/trackingprortal20/plant_master/list_plants  = Done
4.Assign Plant to Plant Controller http://localhost/trackingprortal20/plant_master/list_assigned_plants_user = done

5.Existing Products http://localhost/trackingprortal20/product/list_product = DOne
6.Existing Orders http://localhost/trackingprortal20/order_master/list_orders
7.List Consumer http://localhost/trackingprortal20/consumer/consumer_list
8.Barcode Scanned http://localhost/trackingprortal20/consumer/barcode_scanned
9.Assign Products to Plant http://innovigents.com/plant_master/list_assigned_plants_sku
10.Barcode Status Reports http://localhost/trackingprortal20/reports/barcode_printed_reports
11.Barcode Scanned Reports http://localhost/trackingprortal20/reports/barcode_scanned_reports

 

CCC admin

1.Existing Plants http://innovigents.com/plant_master/list_plants
2.Existing Plant Controllers http://innovigents.com/user_master/list_user/
3.Assign Plant to Plant Controller http://innovigents.com/plant_master/list_assigned_plants_user
4.Existing Products http://innovigents.com/product/list_product
5.Assign Products to Plant http://innovigents.com/plant_master/list_assigned_plants_sku
6.Existing Orders http://innovigents.com/order_master/list_orders
7.Bar/QR Code Status http://innovigents.com/reports/barcode_printed_reports
8.Products Scanned http://innovigents.com/reports/barcode_scanned_reports
9.Products Purchased http://innovigents.com/reports/list_purchased_products
10.Complaint Log http://innovigents.com/reports/list_complaint_log
11.Warranty Claims http://innovigents.com/reports/list_warranty_claims



<div class="row">
<div class="col-xs-12">
    <div class="widget-box widget-color-blue">
        <div class="widget-header widget-header-flat">
            <h5 class="widget-title bigger lighter">Manage Plant Controller</h5>
            <div class="widget-toolbar">
                <a href="<?php echo base_url('plant_master/assign_plant_to_users') ?>" class="btn btn-xs btn-warning" title="Add PLant Controller">Add <?php echo $label; ?> </a>
            </div>
        </div>
    <div class="widget-body">
        <div class="row filter-box">
            <form id="form-filter" action="" method="get" class="form-horizontal" >
                <div class="col-sm-6">
                    <label>Display
                        <select name="page_limit" id="page_limit" class="form-control" onchange="this.form.submit()">
                        <?php echo Utils::selectOptions('pagelimit',['options'=>$this->config->item('pageOption'),'value'=>$this->config->item('pageLimit')]) ?>
                        </select>
                    Records
                    </label>
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Type your query">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                            <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        
        
        
<!--        after table-->
<div class="row paging-box">
<?php echo $links ?>
</div>
    </div>