Super admin
1.Existing Customer http://innovigents.com/user_master/list_user/ = Page not exist
2.Existing Plant Controller http://localhost/trackingprortal20/user_master/list_plant_controllers = Done
3.Existing Plants http://localhost/trackingprortal20/plant_master/list_plants  = Done
4.Assign Plant to Plant Controller http://localhost/trackingprortal20/plant_master/list_assigned_plants_user = done

5.Existing Products http://localhost/trackingprortal20/product/list_product = DOne
6.Existing Orders http://localhost/trackingprortal20/order_master/list_orders = done
7.List Consumer http://localhost/trackingprortal20/consumer/consumer_list = Page not exist
8.Barcode Scanned http://localhost/trackingprortal20/consumer/barcode_scanned = page not exist
9.Assign Products to Plant http://innovigents.com/plant_master/list_assigned_plants_sku = DONE
10.Barcode Status Reports http://localhost/trackingprortal20/reports/barcode_printed_reports = Done
11.Barcode Scanned Reports http://localhost/trackingprortal20/reports/barcode_scanned_reports = Done

 

CCC admin

1.Existing Plants http://innovigents.com/plant_master/list_plants = Done
2.Existing Plant Controllers http://innovigents.com/user_master/list_user/
3.Assign Plant to Plant Controller http://innovigents.com/plant_master/list_assigned_plants_user = Done
4.Existing Products http://innovigents.com/product/list_product = Done
5.Assign Products to Plant http://innovigents.com/plant_master/list_assigned_plants_sku = Done
6.Existing Orders http://innovigents.com/order_master/list_orders = Done
7.Bar/QR Code Status http://innovigents.com/reports/barcode_printed_reports  = Done
8.Products Scanned http://innovigents.com/reports/barcode_scanned_reports = Done
9.Products Purchased http://innovigents.com/reports/list_purchased_products = Done
10.Complaint Log http://innovigents.com/reports/list_complaint_log = Done
11.Warranty Claims http://innovigents.com/reports/list_warranty_claims = Done



if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $srch_string = $this->input->get('search');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->order_master_model->get_total_order_list_all($srch_string);

        $params["orderListing"] = $this->order_master_model->get_order_list_all($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/list_orders', $total_records);
        
        $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
        $sno =  $page + 1;
        
        
        
        

<div class="row">
<div class="col-xs-12">
    <div class="widget-box widget-color-blue">
        <div class="widget-header widget-header-flat">
            <h5 class="widget-title bigger lighter">List <?php echo $label;?></h5>
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
        
       