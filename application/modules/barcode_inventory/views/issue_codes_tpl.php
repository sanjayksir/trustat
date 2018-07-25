<div class="widget-box widget-color-blue">
    <div class="widget-header widget-header-flat">
        <h5 class="widget-title bigger lighter"><?php echo $title;?></h5>
        <div class="widget-toolbar">
            <a href="<?php echo base_url('barcode_inventory/addbarcode_transaction/Issued') ?>" class="btn btn-sm btn-success btnadd" title="Issue More Codes">Issue More Codes</a>
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
                        <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Product SKU & Product Code">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                            <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <table id="missing_people" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sno</th>
                    <th>Plant Code</th>
                    <th>Product SKU</th>
                    <th>Product Code</th>
                    <th>Order No.</th>                    
                    <th>Order Date</th>
                    <th>Print Date</th>
                    <th>Source From</th>
                    <th>Issue Date</th>
                    <th>Code Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>            
            <?php
            if(empty($items)):
                echo '<tr><td colspan="11"><h3 class="text-center">There is no record.</h3></td></tr>';
            endif;
            $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
            $sno =  $page + 1;            
            foreach ($items as $row):
            ?>
            <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo $row['plant_id'];?></td>
                <td><?php echo $row['product_sku'];?></td>
                <td><?php echo $row['barcode_qr_code_no'];?></td>
                <td><?php echo $row['order_no'];?></td>
                <td><?php echo date('d/M/Y',strtotime($row['created_date'])); ?></td>
                <td><?php echo date('d/M/Y',strtotime($row['modified_at'])); ?></td>
                <td><?php
                if($row['delivery_method'] == 1){
                    echo 'Super Admin';
                }elseif($row['delivery_method'] ==2){
                    echo 'Plant Controller';
                }elseif($row['delivery_method'] == 3){
                    echo 'CCC Admin';
                }
                
                ?></td>
                <td><?php echo date('d/M/Y',strtotime($row['receive_date'])); ?></td>
                <td><?php echo $row['stock_status'];?></td>
                <td>
                    <div class="form-group">
                        <?php $rowStatus = [1=>'Active',2=>'Inactive',3=>'Pending']; ?>
                        <select name="row-status" id="row-status">
                            <?php foreach($rowStatus as $k => $value): ?>
                            <option value="<?php echo $k; ?>" <?php echo ($k == $row['active_status'])?'selected="selected"':''; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </td>
            </tr>
            <?php $sno++; ?>
            <?php endforeach; ?>

            </tbody>
        </table>
        <div class="row paging-box">
        <?php echo $links ?>
        </div>
    </div>
</div>
<div id="modalbox" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Issue Code</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.btnadd').on('click',function(e){
            e.preventDefault();
            $('.modal-body').load($(this).attr('href'),function(result){
                $('#modalbox').modal('toggle');
            });
        });
    });
</script>