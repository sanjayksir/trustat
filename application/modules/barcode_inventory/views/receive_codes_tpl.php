<div class="widget-box widget-color-blue">
    <div class="widget-header widget-header-flat">
        <h5 class="widget-title bigger lighter"><?php echo $title;?></h5>
        <div class="widget-toolbar">
            <a href="<?php echo base_url('barcode_inventory/addbarcode_transaction') ?>" class="btn btn-sm btn-success btnadd" title="Receive More Codes">Receive More Codes</a>
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
                    <th>Recieve Date</th>
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
                <td><?php echo $row['product_code'];?></td>
                <td><?php echo $row['order_number'];?></td>
                <td><?php echo date('d/M/Y',strtotime($row['order_date'])); ?></td>
                <td><?php echo date('d/M/Y',strtotime($row['print_date'])); ?></td>
                <td><?php echo $row['source_received_from'];?></td>
                <td><?php echo date('d/M/Y',strtotime($row['receive_date'])); ?></td>
                <td><?php echo $row['stock_status'];?></td>
                <td>
                    <div class="hidden-sm hidden-xs action-buttons">
                        <a href="<?php  echo site_url('question/view_question/'.$row['id']);?>" class="blue" target="_blank" title="View"><i class="fa fa-eye"></i></a>
                        <a href="<?php  echo site_url('question/edit_question/'.$row['id']);?>" class="blue" target="_blank" title="View"><i class="ace-icon fa fa-pencil bigger-130"></i></a>
                        <a href="<?php  echo site_url('question/change_status/'.$row['id']);?>" class="blue" target="_blank" title="View"><i class="ace-icon fa fa-pencil bigger-130"></i></a>
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
                <h4 class="modal-title">Recieve Code</h4>
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
                $('#modalbox').modal({show:true});
            });
        });
    });
</script>