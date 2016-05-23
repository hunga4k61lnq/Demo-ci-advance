<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head >
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <base href="<?php echo base_url() ?>"/>
      <title>Hệ thống quản trị website</title>
      <meta name="robots" content="noindex, nofollow">
      <link rel="icon" href="http://enuy.com.vn/images/favicon.png" type="image/x-icon" />
      <link rel="apple-touch-icon" href="http://enuy.com.vn/images/favicon.png">
      <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>theme/admin/static/bootstrap.css">
      <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>theme/admin/static/font-awesome.css">
      <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>theme/admin/static/menumobile/css/headroom.css">
      <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>theme/admin/static/menumobile/css/meanmenu.css">
      <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>theme/admin/static/fancybox/source/jquery.fancybox.css">
      <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>theme/admin/static/combined.css">
      <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>theme/admin/static/datetimepicker/jquery.datetimepicker.css">
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/menumobile/js/headroom.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/menumobile/js/jQuery.headroom.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/menumobile/js/jquery.meanmenu.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/menumobile/js/menu.js"></script>
      <script type="text/javascript">        var $ = jQuery.noConflict();</script>
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/jquery.hotkeys.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/fancybox/source/jquery.fancybox.pack.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/datetimepicker/jquery.datetimepicker.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/jquery.form.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>theme/admin/static/bootbox.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url() ?>theme/admin/static/select2.min.js"></script>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>theme/admin/static/select2/select2-bootstrap.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>theme/admin/static/select2/select2.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>theme/admin/static/toast/toastr.css">
      <script type="text/javascript" src="<?php echo base_url() ?>theme/admin/static/toast/toastr.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url() ?>public/tinymce/tinymce.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url() ?>theme/admin/static/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>theme/admin/static/scrollbar/jquery.mCustomScrollbar.css">
      <script>
      tinymce.init({
          selector: "textarea.editor",
          theme: "modern",
          width: '100%',
          height: 300,
          plugins: [
               "advlist autosave autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
               "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
               "save table contextmenu directionality emoticons template paste textcolor enuyfilemanager"
         ],
         toolbar: "image",
         toolbar1:"newdocument code print preview | undo redo | bold italic underline hr strikethrough | alignleft aligncenter alignright alignjustify | cut copy paste | bullist numlist outdent indent blockquote | removeformat subscript superscript",
         toolbar2:"styleselect formatselect fontselect fontsizeselect | link unlink anchor table | forecolor backcolor | nonbreaking charmap pastetext pagebreak | spellchecker visualblocks visualchars insertdatetime | fullscreen",
         toolbar3:"enuyfilemanager | image media",
         image_advtab: true ,


         style_formats: [
              {title: 'Bold text', inline: 'b'},
              {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
              {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
              {title: 'Example 1', inline: 'span', classes: 'example1'},
              {title: 'Example 2', inline: 'span', classes: 'example2'},
              {title: 'Table styles'},
              {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
          ],
                   document_base_url:'<?php echo base_url() ?>',
          relative_urls : true,
          remove_script_host : true,
          convert_urls : true,
         external_filemanager_path:'<?php echo base_url(); ?>Admin/mediaManager',
         filemanager_title:"Enuy File Manager" ,
         external_plugins: { "filemanager" : "<?php echo base_url(); ?>theme/admin/static/plugin.min.js"}
         
       }); 
      </script>
  <script type="text/javascript">
  $(function() {
    $('.fancybox').fancybox();
    $('.datepicker').datetimepicker({
          lang:'vi',
          timepicker:true,
          formatTime: 'H:i',
          format:'d-m-Y H:i:s',
          onClose: function(e,e1){
            try{
              var val = $(e1).val();
              var s= val.split(' ');
              var s1 = s[0].split('-');
              var s2 = s[1].split(':');
              var d = new Date(s1[2],s1[1]-1,s1[0],s2[0],s2[1],s2[2]);
              
              $(e1).next().val(d.getTime()/1000);
            }
            catch(ex){}
          }
      });

  });
  $(document).ready(function() {
      $('*').bind('keydown', 'meta+s', function(e){

        e.preventDefault();
        if(FORM_GLOBAL!=undefined) submitForm(FORM_GLOBAL);
      });
      $('*').bind('keydown', 'ctrl+s', function(e){
        e.preventDefault();
        if(FORM_GLOBAL!=undefined) submitForm(FORM_GLOBAL);
      });
      $.mCustomScrollbar.defaults.scrollButtons.enable=true;
      $(".scrollbar").mCustomScrollbar({'theme':'rounded-dark'});
      $.fn.moveUp = function() {
        $.each(this, function() {
             $(this).after($(this).prev());   
        });
      };
      $.fn.moveDown = function() {
          $.each(this, function() {
               $(this).before($(this).next());   
          });
      };
    });
  var MISSING_PARAM=<?php echo MISSING_PARAM ?>;
  var SUCCESS=<?php echo SUCCESS ?>;
  var ERROR=<?php echo ERROR ?>;
  var checkReload= true;
  var FORM_GLOBAL = undefined;
  var DIALOG_TIMEOUT = <?php echo $this->Admindao->getConfigSite('DIALOG_TIMEOUT',2000); ?>;
  //Ajax Config
  $(document).ajaxStart(function() {
    $('#notiajax').css({
          display: 'block'
        });
    });
    
    $(document).ajaxStop(function(){
      $('#notiajax').css({
          display: 'none'
        });
    });

    
    $(document).ajaxSuccess(function(event, xhr, settings) {

        $('#notiajax').css({
          display: 'none'
        });
        try{
          var json = $.parseJSON(xhr.responseText);
          toastr.options = {
            "closeButton": true,"debug": false,"newestOnTop": false,"progressBar": true,"positionClass": "toast-center-center","preventDuplicates": true,
            "onclick": null,
            "showDuration": "300","hideDuration": "1000","timeOut": DIALOG_TIMEOUT,"extendedTimeOut": "1000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"
          };
          if(checkReload){
              toastr.options.onHidden = function() { 
               <?php if(@$table){ ?>
                  window.location.href="<?php echo base_url().'Admin/view/'.$table[0]['name'] ?>";
                <?php } ?>
              }
            }
          if(json.code == SUCCESS){
            toastr["success"](json.message);
          }
          else{
            toastr["error"](json.message);
          }
          if(checkReload==false){
            checkReload = true;  
          }
          
        }
        catch( e){

        }


    });
  $(window).scroll(function(){
      if($(this).scrollTop()>130){

          $("#hiddenToolBarScroll").show();
      }else{
          $("#hiddenToolBarScroll").hide();
      }}
  );
var csfrData = {};
     csfrData['<?php echo $this->security->get_csrf_token_name(); ?>']
     = '<?php echo $this->security->get_csrf_hash(); ?>';
 $.ajaxSetup({
       data: csfrData
    });
  //Ajax Config
  function submitForm(frm){
    try{
      tinyMCE.triggerSave();
    }
    catch(ex){
      
    }
      
      toastr.options = {
      "closeButton": true,"debug": false,"newestOnTop": false,"progressBar": true,"positionClass": "toast-center-center","preventDuplicates": true,
      "onclick": null,
      "showDuration": "300","hideDuration": "1000","timeOut": DIALOG_TIMEOUT,"extendedTimeOut": "1000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"
      };
     var options = { 
        type:      'POST',
        beforeSend: function() {
        },
        uploadProgress: function(event, position, total, percentComplete) {
        },
        success: function(e) {
        },
        complete: function(xhr) {

        }
      }; 
      $(frm).ajaxForm(options); 
      $(frm).submit();
  }
  function locDau(str) 
      { 
          str = str.toLowerCase();
          str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
          str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
          str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
          str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
          str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
          str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
          str = str.replace(/đ/g, "d");
          str = str.replace(/^\-+|\-+$/g, "");
          var re = new RegExp("\\W", 'g');
          str = str.replace(re, '-');
          return str;
      }
  </script>
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?3MGwhFNzjtwEIm2MJNu4c4Jg0hkGrGtI";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->
   </head>
   <body class="fixed-top">
      <div id="notiajax" style=" display:none; position: fixed;left: 50%;  transform: translate(-50%);background-color: #fff;z-index: 99999;padding: 0px 20px;border: 1px solid #00923F;border-top: none;border-radius: 0px 0px 20px 20px;">
        <img style="width:25px;" src="<?php echo base_url() ?>/theme/admin/images/loading.gif"/>
        <span>Đang tải dữ liệu</span>
      </div>
      <div class="bb-alert alert alert-info" style="position:fixed;top:25%;right:50%; transform:translate(50%,50%);z-index:9999;background:transparent;border:none;text-align:center;display:none">
          <span style="display:block;  display: inline-block;background: #0BAE00;color: #fff;padding: 5px 30px;border-radius: 6px;">Hi</span>
      </div>
      <div class="container-fluid padding0">
      <?php $this->load->view('header'); ?>
      <div id="container" class="row-fluid">
         <div class="clear" style="height: 10px"></div>
         <?php $this->load->view('menu'); ?>
         <div id="main-content">
            <div class="container-fluid">
               <?php $this->load->view($content); ?>
            </div>
             <?php $this->load->view('footer'); ?>
         </div>
      </div>
    </div>
        <div class="modal" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-register-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h3 class="modal-title clmain" id="modal-register-label">Đổi mật khẩu</h3>
                        
                    </div>
                    
                    <div class="modal-body">
                        
                        <form onsubmit="sumitFormLogin(this);return false;" role="form" action="Admin/doChangePass" method="post" class="registration-form">
                            <div class="form-group">
                                <label class="" for="form-first-name">Mật khẩu cũ</label>
                                <input type="password" name="oldpass" placeholder="Mật khẩu cũ" class="form-first-name form-control" id="form-first-name">
                            </div>
                            <div class="form-group">
                                <label class="" for="form-last-name">Mật khẩu mới</label>
                                <input type="password" name="password" placeholder="Mật khẩu mới" class="form-last-name form-control" id="form-last-name">
                            </div>
                            
                            <button class=" btn clfff maincolor" type="submit" >Đổi mật khẩu</button>
                        </form>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <script type="text/javascript">
        function sumitFormLogin(frm){
          $.ajax({
            url: $(frm).attr('action'),
            type: 'POST',
            data: $(frm).serialize(),
          })
          .done(function(e) {
            try{
              var json= $.parseJSON(e);
              if(json.errorCode==200){
                window.location.href="<?php echo base_url() ?>Admin/logout";
              }
              else{
                window.location.href="<?php echo base_url() ?>Admin"; 
              }
            }
            catch(ex){
              
            }
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
          
        }
        </script>
   </body>
</html>