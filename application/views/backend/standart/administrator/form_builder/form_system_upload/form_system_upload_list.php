
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
//This page is a result of an autogenerated content made by running test.html with firefox.
function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/Form_system_upload/add';
       return false;
   });

   $('*').bind('keydown', 'Ctrl+f', function assets() {
       $('#sbtn').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
       $('#reset').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+b', function assets() {

       $('#reset').trigger('click');
       return false;
   });
}

jQuery(document).ready(domo);
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      System Upload<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">System Upload</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row" >
      
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <!-- Widget: user widget style 1 -->
               <div class="box box-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header ">
                     <div class="row pull-right">
                        <?php is_allowed('form_system_upload_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export', 'Form System Upload'); ?>" href="<?= site_url('administrator/form_system_upload/export'); ?>"><i class="fa fa-file-excel-o" ></i> <?= cclang('export'); ?></a>
                        <?php }) ?>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">System Upload</h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', 'System Upload'); ?>  <i class="label bg-yellow"><?= $form_system_upload_counts; ?>  <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_form_system_upload" id="form_form_system_upload" action="<?= base_url('administrator/form_system_upload/index'); ?>">
                  
                  <div class="table-responsive">
                  <table class="table table-bordered table-striped dataTable">
                     <thead>
                        <tr class="">
                           <th>
                            <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                           </th>
                           <th>File Name</th>
                           <th>Application Source</th>
                           <th>Batch Id</th>
                           <th>Process Month</th>
                           <th>Process Year</th>
                           <th>Uploader</th>
                           <th>Upload At</th>
                           <th>Update At</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody id="tbody_form_system_upload">
                     <?php foreach($form_system_uploads as $form_system_upload): ?>
                        <tr>
                           <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="<?= $form_system_upload->id; ?>">
                           </td>
                           <td>
                              <?php if (!empty($form_system_upload->file_name)): ?>
                                <?php if (is_image($form_system_upload->file_name)): ?>
                                <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/form_system_upload/' . $form_system_upload->file_name; ?>">
                                  <img src="<?= BASE_URL . 'uploads/form_system_upload/' . $form_system_upload->file_name; ?>" class="image-responsive" alt="image form_system_upload" title="file_name form_system_upload" width="40px">
                                </a>
                                <?php else: ?>
                                  <a href="<?= BASE_URL . 'administrator/file/download/form_system_upload/' . $form_system_upload->file_name; ?>">
                                   <img src="<?= get_icon_file($form_system_upload->file_name); ?>" class="image-responsive image-icon" alt="image form_system_upload" title="file_name <?= $form_system_upload->file_name; ?>" width="40px"> 
                                 </a>
                                <?php endif; ?>
                              <?php endif; ?>
                           </td>
                            
                           <td><?= _ent($form_system_upload->application_source); ?></td> 
                           <td><?= _ent($form_system_upload->batch_id); ?></td> 
                           <td><?= _ent($form_system_upload->process_month); ?></td> 
                           <td><?= _ent($form_system_upload->process_year); ?></td> 
                           <td><?= _ent($form_system_upload->uploader); ?></td> 
                           <td><?= _ent($form_system_upload->upload_at); ?></td> 
                           <td><?= _ent($form_system_upload->update_at); ?></td> 
                           <td width="200">
                              <?php is_allowed('form_system_upload_view', function() use ($form_system_upload){?>
                              <a href="<?= site_url('administrator/form_system_upload/view/' . $form_system_upload->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>
                              <?php }) ?>
                              <?php is_allowed('form_system_upload_update', function() use ($form_system_upload){?>
                              <a href="<?= site_url('administrator/form_system_upload/edit/' . $form_system_upload->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                              <?php }) ?>
                              <?php is_allowed('form_system_upload_delete', function() use ($form_system_upload){?>
                              <a href="javascript:void(0);" data-href="<?= site_url('administrator/form_system_upload/delete/' . $form_system_upload->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                               <?php }) ?>
                           </td>
                        </tr>
                      <?php endforeach; ?>
                      <?php if ($form_system_upload_counts == 0) :?>
                         <tr>
                           <td colspan="100">
                            <?= cclang('data_is_not_avaiable', 'Form System Upload'); ?>
                           </td>
                         </tr>
                      <?php endif; ?>
                     </tbody>
                  </table>
                  </div>
               </div>
               <hr>
               <!-- /.widget-user -->
               <div class="row">
                  <div class="col-md-8">
                     <div class="col-sm-2 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Site Email" >
                           <option value="">Bulk</option>
                           <option value="delete"><?= cclang('delete'); ?></option>
                        </select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="apply bulk actions"><?= cclang('apply_button'); ?></button>
                     </div>
                     <div class="col-sm-3 padd-left-0  " >
                        <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>" value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field" >
                           <option value=""><?= cclang('all'); ?></option>
                            <option <?= $this->input->get('f') == 'file_name' ? 'selected' :''; ?> value="file_name">File Name</option>
                           <option <?= $this->input->get('f') == 'application_source' ? 'selected' :''; ?> value="application_source">Application Source</option>
                           <option <?= $this->input->get('f') == 'batch_id' ? 'selected' :''; ?> value="batch_id">Batch Id</option>
                           <option <?= $this->input->get('f') == 'process_month' ? 'selected' :''; ?> value="process_month">Process Month</option>
                           <option <?= $this->input->get('f') == 'process_year' ? 'selected' :''; ?> value="process_year">Process Year</option>
                           <option <?= $this->input->get('f') == 'uploader' ? 'selected' :''; ?> value="uploader">Uploader</option>
                           <option <?= $this->input->get('f') == 'upload_at' ? 'selected' :''; ?> value="upload_at">Upload At</option>
                           <option <?= $this->input->get('f') == 'update_at' ? 'selected' :''; ?> value="update_at">Update At</option>
                          </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                        Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/form_system_upload');?>" title="<?= cclang('reset_filter'); ?>">
                        <i class="fa fa-undo"></i>
                        </a>
                     </div>
                  </div>
                  </form>                  <div class="col-md-4">
                     <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate" >
                        <?= $pagination; ?>
                     </div>
                  </div>
               </div>
            </div>
            <!--/box body -->
         </div>
         <!--/box -->
      </div>
   </div>
</section>
<!-- /.content -->

<!-- Page script -->
<script>
  $(document).ready(function(){
   
    $('.remove-data').click(function(){

      var url = $(this).attr('data-href');

      swal({
          title: "<?= cclang('are_you_sure'); ?>",
          text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
          cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            document.location.href = url;            
          }
        });

      return false;
    });


    $('#apply').click(function(){

      var bulk = $('#bulk');
      var serialize_bulk = $('#form_form_system_upload').serialize();

      if (bulk.val() == 'delete') {
         swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
            cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
               document.location.href = BASE_URL + '/administrator/form_system_upload/delete?' + serialize_bulk;      
            }
          });

        return false;

      } else if(bulk.val() == '')  {
          swal({
            title: "Upss",
            text: "<?= cclang('please_choose_bulk_action_first'); ?>",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Okay!",
            closeOnConfirm: true,
            closeOnCancel: true
          });

        return false;
      }

      return false;

    });/*end appliy click*/


    //check all
    var checkAll = $('#check_all');
    var checkboxes = $('input.check');

    checkAll.on('ifChecked ifUnchecked', function(event) {   
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });

  }); /*end doc ready*/
</script>