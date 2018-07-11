<div class="widget-box widget-color-blue">
    <div class="widget-header widget-header-flat">
        <h5 class="widget-title bigger lighter">List <?php echo $label;?></h5>
        <div class="widget-toolbar">
            <a href="<?php echo base_url('plant_master/assign_plants') ?>" class="btn btn-xs btn-warning" title="Add PLant">Assign Products</a>
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
                    <th>Question Type</th>
                    <th>Question Text</th>
                    <th>Created</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
            $sno =  $page + 1;
            foreach ($items as $row):
            ?>
            <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo $row['question_type'];?></td>
                <td><?php echo $row['question_text'];?></td>
                <td><?php echo date('d/M/Y',strtotime($row['created'])); ?></td>
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