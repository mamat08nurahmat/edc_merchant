
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
//This page is a result of an autogenerated content made by running test.html with firefox.
function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+e', function assets() {
      $('#btn_edit').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#btn_back').trigger('click');
       return false;
   });
    
}


jQuery(document).ready(domo);
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Detail Upload Incoming      <small><?= cclang('detail', 'Detail Upload Incoming'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/form_detail_upload_incoming'); ?>">Detail Upload Incoming</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
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
                    
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">Detail Upload Incoming</h3>
                     <h5 class="widget-user-desc">Detail Detail Upload Incoming</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal" name="form_form_detail_upload_incoming" id="form_form_detail_upload_incoming" >
                   
                    <div class="form-group option">               
                  <label for="content" class="col-sm-2 control-label">Tanggal Submit </label>

                        <div class="col-sm-8">
                           <?= _ent($form_detail_upload_incoming->tanggal_submit); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group option">               
                  <label for="content" class="col-sm-2 control-label">Data Entry </label>

                        <div class="col-sm-8">
                           <?= _ent($form_detail_upload_incoming->data_entry); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group option">               
                  <label for="content" class="col-sm-2 control-label">Area </label>

                        <div class="col-sm-8">
                           <?= _ent($form_detail_upload_incoming->area); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group option">               
                  <label for="content" class="col-sm-2 control-label">Agency </label>

                        <div class="col-sm-8">
                           <?= _ent($form_detail_upload_incoming->agency); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group option">               
                  <label for="content" class="col-sm-2 control-label">Sales Center </label>

                        <div class="col-sm-8">
                           <?= _ent($form_detail_upload_incoming->sales_center); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group option">               
                  <label for="content" class="col-sm-2 control-label">Keterangan </label>

                        <div class="col-sm-8">
                           <?= _ent($form_detail_upload_incoming->keterangan); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group option">               
                  <label for="content" class="col-sm-2 control-label">Jumlah Data </label>

                        <div class="col-sm-8">
                           <?= _ent($form_detail_upload_incoming->jumlah_data); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group option">               
                  <label for="content" class="col-sm-2 control-label">Approve </label>

                        <div class="col-sm-8">
                           <?= _ent($form_detail_upload_incoming->approve); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group option">               
                  <label for="content" class="col-sm-2 control-label">Reject </label>

                        <div class="col-sm-8">
                           <?= _ent($form_detail_upload_incoming->reject); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group option">               
                  <label for="content" class="col-sm-2 control-label">Update At </label>

                        <div class="col-sm-8">
                           <?= _ent($form_detail_upload_incoming->update_at); ?>
                        </div>
                    </div>
                                        
                    <br>
                    <br>

                    <div class="view-nav">
                        <?php is_allowed('form_detail_upload_incoming_update', function() use ($form_detail_upload_incoming){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="<?= cclang('update', 'form_detail_upload_incoming'); ?> (Ctrl+e)" href="<?= site_url('administrator/form_detail_upload_incoming/edit/'.$form_detail_upload_incoming->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', 'Form Detail Upload Incoming'); ?></a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/form_detail_upload_incoming/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list', 'Form Detail Upload Incoming'); ?></a>
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
