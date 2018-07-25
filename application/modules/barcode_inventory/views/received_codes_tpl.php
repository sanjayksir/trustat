<div class="widget-box widget-color-blue">
    <div class="widget-header widget-header-flat">
        <h5 class="widget-title bigger lighter"><?php echo $title;?></h5>
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
                    <th>Trax Number</th>
                    <th>Plant Code</th>
                    <th>Product SKU</th>
                    <th>Product Code</th>
                    <th>Quantity</th>
                    <th>Order No.</th>                    
                    <th>Order Date</th>
                    <th>Print Date</th>
                    <th>Source From</th>
                    <th>Recieve Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>            
            <?php
            if(empty($items)):
                echo '<tr><td colspan="12"><h3 class="text-center">There is no record.</h3></td></tr>';
            endif;
            $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
            $sno =  $page + 1;            
            foreach ($items as $row):
            ?>
            <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo $row['trax_number'];?></td>
                <td><?php echo $row['plant_id'];?></td>
                <td><?php echo $row['product_sku'];?></td>
                <td><?php echo $row['product_code'];?></td>
                <td><?php echo $row['quantity'];?></td>
                <td><?php echo $row['order_number'];?></td>
                <td><?php echo date('d/M/Y',strtotime($row['order_date'])); ?></td>
                <td><?php echo date('d/M/Y',strtotime($row['print_date'])); ?></td>
                <td><?php
                if($row['source_received_from'] == 1){
                    echo 'Super Admin';
                }elseif($row['source_received_from'] ==2){
                    echo 'Plant Controller';
                }elseif($row['source_received_from'] == 3){
                    echo 'CCC Admin';
                }
                
                ?></td>
                <td><?php echo date('d/M/Y',strtotime($row['receive_date'])); ?></td>
<!--                <td><?php echo $row['stock_status'];?></td>-->
                <td>                    
                    <?php
                    $sString = 'Inactive';
                    $sClass = 'danger';
                    if($row['status'] == 1){
                        $sString = 'Active';
                        $sClass = 'success';
                    }
                    ?>
                    <a href="<?php echo site_url('barcode_inventory/barcode_order_status/'.$row['id'].'/transactions'); ?>" class="label label-<?php echo $sClass; ?> bostatus"><?php echo $sString ?></a>
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
<script type="text/javascript">
    $(document).ready(function(){
        $(".bostatus").on('click',function(e){
            e.preventDefault();
            var currentElem = $(this);
            var url = $(this).attr('href');
            bootbox.confirm("Are you sure want to change the status?", function(result){
                if(!result){
                    return;
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    success: function(data){
                        if(data.status){
                            if(currentElem.hasClass('label-danger')){
                                currentElem.removeClass('label-danger').addClass('label-success').text('Active');
                            }else{
                                currentElem.removeClass('label-success').addClass('label-danger').text('Inactive');
                            }                            
                            $('.alert-msg').removeClass('alert-danger').addClass('alert-success');
                        }else{
                            $('.alert-msg').addClass('alert-danger').removeClass('alert-success');
                        }
                        $('.alert-msg').html(data.message).fadeIn('slow');
                        setTimeout(function(){
                            $(".alert").fadeOut('slow');
                        },2000);
                    }
                });
            });
            //return false;
        });
    });
</script>