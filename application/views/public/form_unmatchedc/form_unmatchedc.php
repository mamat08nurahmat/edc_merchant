
<script src="<?= BASE_ASSET; ?>js/custom.js"></script>

<!-- Fine Uploader Gallery CSS file
    ====================================================================== -->
<link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<!-- Fine Uploader jQuery JS file
    ====================================================================== -->
<script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>

<?php $this->load->view('core_template/fine_upload'); ?>

<?= form_open('', [
    'name'    => 'form_form_unmatchedc', 
    'class'   => 'form-horizontal form_form_unmatchedc', 
    'id'      => 'form_form_unmatchedc',
    'enctype' => 'multipart/form-data', 
    'method'  => 'POST'
]); ?>
 
<div class="form-group ">
    <label for="file" class="col-sm-2 control-label">File 
    <i class="required">*</i>
    </label>
    <div class="col-sm-8">
        <div id="form_unmatchedc_file_galery" ></div>
        <input class="data_file" name="form_unmatchedc_file_uuid" id="form_unmatchedc_file_uuid" type="hidden" >
        <input class="data_file" name="form_unmatchedc_file_name" id="form_unmatchedc_file_name" type="hidden" >
        <small class="info help-block">
        </small>
    </div>
</div>


<div class="row col-sm-12 message">
</div>
<div class="col-sm-2">
</div>
<div class="col-sm-8 padding-left-0">
    <button class="btn btn-flat btn-primary btn_save" id="btn_save" data-stype='stay'>
    Submit
    </button>
    <span class="loading loading-hide">
    <img src="http://35.221.121.28:80/mattools/asset//img/loading-spin-primary.svg"> 
    <i>Loading, Submitting data</i>
    </span>
</div>
</form></div>


<!-- Page script -->
<script>
    $(document).ready(function(){
          $('.form-preview').submit(function(){
        return false;
     });

     $('input[type="checkbox"].flat-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
     });


    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_form_unmatchedc = $('#form_form_unmatchedc');
        var data_post = form_form_unmatchedc.serializeArray();
        var save_type = $(this).attr('data-stype');
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + 'form/form_unmatchedc/submit',
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id_file = $('#form_unmatchedc_file_galery').find('li').attr('qq-file-id');
            
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            resetForm();
            if (typeof id_file !== 'undefined') {
                    $('#form_unmatchedc_file_galery').fineUploader('deleteFile', id_file);
                }
            $('.chosen option').prop('selected', false).trigger('chosen:updated');
            window.location.href = res.redirect; 
            // dev 08072019                
          } else {
            $('.message').printMessage({message : res.message, type : 'warning'});
          }
    
        })
        .fail(function() {
          $('.message').printMessage({message : 'Error save data', type : 'warning'});
        })
        .always(function() {
          $('.loading').hide();
          $('html, body').animate({ scrollTop: $(document).height() }, 1000);
        });
    
        return false;
      }); /*end btn save*/


      
             
       var params = {};
       params[csrf] = token;

       $('#form_unmatchedc_file_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + 'form/form_unmatchedc/upload_file_file',
              params : params
          },
          deleteFile: {
              enabled: true, 
              endpoint: BASE_URL + 'form/form_unmatchedc/delete_file_file',
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
          multiple : false,
          validation: {
              allowedExtensions: ["*"],
              sizeLimit : 0,
                        },
          showMessage: function(msg) {
              toastr['error'](msg);
          },
          callbacks: {
              onComplete : function(id, name, xhr) {
                if (xhr.success) {
                   var uuid = $('#form_unmatchedc_file_galery').fineUploader('getUuid', id);
                   $('#form_unmatchedc_file_uuid').val(uuid);
                   $('#form_unmatchedc_file_name').val(xhr.uploadName);
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onSubmit : function(id, name) {
                  var uuid = $('#form_unmatchedc_file_uuid').val();
                  $.get(BASE_URL + 'form/form_unmatchedc/delete_file_file/' + uuid);
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#form_unmatchedc_file_uuid').val('');
                  $('#form_unmatchedc_file_name').val('');
                }
              }
          }
      }); /*end file galey*/
           
    }); /*end doc ready*/
</script>