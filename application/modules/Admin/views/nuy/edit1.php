<?php $table = sizeof($table)>0?$table[0]:NULL;
 ?>
<script type="text/javascript">
FORM_GLOBAL = '#mainform';
//Callback Responsive manager
  function changeListImage(_that,inputarget){
    var arr = $(_that).find('img');
    var str =new Array();
    for (var i = 0; i < arr.length; i++) {
      var item = arr[i];
      str.push($(item).attr('src'));
    };
    str = JSON.stringify(str);
    $('input[name='+inputarget+']').val(str);
  }
  function close_window() {
      parent.$.fancybox.close();
  } 
  function enuyFileManagerCallback(arrItem,field_id){
    if(arrItem.length==0) return;
    jQuery('#'+field_id).val(arrItem[0]);
    var nxt = $('#'+field_id).next();
    if($(nxt).prop('tagName').toLowerCase()=='img'){
      $(nxt).attr('src', arrItem[0]);
    }
    else{
      if($(nxt).attr('data-type')=='libimg'){
        $name = $('#'+field_id).attr('data-name');
        for(var i=0;i<arrItem.length;i++){
        var url = arrItem[i];
        $(nxt).append('<div class="boximg">'+
          '<i onclick="var ax=$(this).parent().parent();$(this).parent().remove();changeListImage(ax,$name);" class="icon-remove-circle"></i><img style="height:85px" src="'+url+'"/>'+
          '<i onclick="$(this).parent().moveDown();changeListImage($(this).parent().parent(),$name);" class="icon-arrow-right" style="position:absolute;right:-15px;top:50%;    color: #810D0D;font-size: 30px;transform: translateY(-50%);"></i>'+
          '<i onclick="$(this).parent().moveUp();changeListImage($(this).parent().parent(),$name);" class="icon-arrow-left" style="position:absolute;left:-15px;top:50%;    color: #810D0D;font-size: 30px;transform: translateY(-50%);"></i></div>');
        }
        changeListImage(nxt,$name);
      }
    }
  }

  $(function() {
    $('.boximg').on('click', 'i', function(event) {
      var _that = $(this).parent().parent();
      var name = $(_that).parent().find('input[data-name]').attr('data-name');
      changeListImage(_that,name);

    });
      $('.iframe-btn').fancybox({ 
        'width'   : 900,
        'height'  : 600,
        'type'    : 'iframe',
              'autoScale'     : false
      });
      $('.ui-tabs-nav li').click(function(event) {
          var div = $('#'+$(this).attr('aria-controls')+'');
          $('.ui-tabs-nav li[role=tab]').removeClass('ui-state-active');
          $(this).addClass('ui-state-active');
          $('div[role=tabdiv]').css({'display':'none'});
          $(div).css({
              display: 'block'
          });

      });
  });
</script>
<div id="main-content">
   <div class="container-fluid">
    <div id="Breadcrumb" class="Block Breadcrumb ui-widget-content ui-corner-top ui-corner-bottom">
        <ul>
            <li class="home"><a href="Admin"><i class="icon-home" style="font-size:14px;"></i> Trang chủ</a></li>
            <li class="SecondLast"><a href="<?php echo base_url(''); ?>Admin/view/<?php echo $table['name'] ?>"><?php echo $table['note'] ?></a></li>
            <li class="Last"><span><?php echo (@$type_title?$type_title:$type)." ".$table['note'] ?></span></li>
        </ul>
    </div>
      <div style="clear: both;"></div>
      <div id="cph_Main_ContentPane">
         <div class="widget">
            <div class="widget-title">
               <h4><i class="icon-list-alt"></i>&nbsp;<?php echo (@$type_title?$type_title:$type) ?><?php if(@$table) echo @$table['note']?$table['note']:$table['name'] ?></h4>
               <div class="ui-widget-content ui-corner-top ui-corner-bottom">
                  <div id="toolbox">
                     <div style="float:right;" class="toolbox-content">
                        <table class="toolbar">
                           <tbody>
                              <tr>
                                 <td align="center">
                                    <a id="cph_Main_ctl00_toolbox_rptAction_lbtAction_0" title="Trợ giúp" class="toolbar btn btn-info" href="" onclick=""><i class="icon-question-sign"></i>&nbsp;
                                    Trợ giúp</a>
                                 </td>
                                 <td align="center">
                                    <a id="" onclick="submitForm('#mainform');return false;" title="Lưu và Thêm mới" class="toolbar btn btn-info" ><i class="icon-ok"></i>&nbsp;
                                    Lưu lại</a>
                                 </td>
                                 <td align="center">
                                    <a id="" title="Quay lại" class="toolbar btn btn-info" href="<?php echo base_url(''); ?>Admin/view/<?php echo $table['name'] ?>"><i class="icon-chevron-left"></i>&nbsp;
                                    Quay lại</a>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div class="clr"></div>
                  </div>
               </div>
               <div id="hiddenToolBarScroll" class="scrollBox" style="display:none;">
                  <h4>
                     <i class="icon-list-alt"></i>&nbsp;<?php echo (@$type_title?$type_title:$type) ?> <?php if(@$table) echo @$table['note']?$table['note']:$table['name'] ?>
                  </h4>
                  <div class="FloatMenuBar">
                     <div class="ui-widget-content ui-corner-top ui-corner-bottom">
                        <div id="toolbox">
                           <div style="float:right;" class="toolbox-content">
                              <table class="toolbar">
                                 <tbody>
                                    <tr>
                                       <td align="center">
                                          <a onclick="" id="" title="Trợ giúp" class="toolbar btn btn-info" href=""><i class="icon-question-sign"></i>&nbsp;
                                          Trợ giúp</a>
                                       </td>
                                       <td align="center">
                                          <a id="" onclick="submitForm('#mainform');return false;" title="Lưu và Thêm mới" class="toolbar btn btn-info" ><i class="icon-ok"></i>&nbsp;
                                          Lưu lại</a>
                                       </td>
                                       <td align="center">
                                          <a id="cph_Main_ctl00_toolbox2_rptAction_lbtAction_4" title="Quay lại" class="toolbar btn btn-info" href="<?php echo base_url(''); ?>Admin/view/<?php echo $table['name'] ?>"><i class="icon-chevron-left"></i>&nbsp;
                                          Quay lại</a>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="widget-body">

              <?php 
              //Check có dữ liệu
              if(($type=='edit' && count($data)>0 ) || $type!='edit') { ?>
               <form  name="addform" id="mainform"  action="Admin/<?php echo $type=="edit"?"do_edit":"do_insert"; ?>/<?php echo $table['name'] ?>/<?php echo @$this->uri->segment(4)?$this->uri->segment(4):"" ?>" method="post">
                  <input type="hidden" name="enuy_controller" value="<?php echo $table['controller'] ?>">
                  <input type="hidden" name="enuy_type" value="<?php echo $table['type'] ?>">
                  <div id="tabs" style="" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                     <ul class="nav nav-tabs ui-tabs-nav " role="tablist">
                        <?php 
                            for ($i=0;$i<sizeof($regions);$i++) {
                            $region = $regions[$i];
                                ?>
                            <li class="<?php if($i==0) echo 'ui-state-active'; ?>" role="tab" aria-controls="tabs-<?php echo $region['id']; ?>" >
                                <span class="ui-tabs-anchor" onclick="return false;" ><?php echo $region['name']; ?></span>
                            </li>
                        <?php    }
                        ?>
                     </ul>
                    <?php 
                        for ($i=0;$i<sizeof($regions);$i++) {
                            $region = $regions[$i];
                            ?>
  
                        <div id="tabs-<?php echo $region['id'] ?>" role="tabdiv" style="display: <?php echo  $i==0? 'block':'none' ?>;" >

                            <div class="container-fluid padding0 tableedit">
                                  <?php 
                                    foreach ($lstFields as $field) {
                                      if($field['region']!=$region['id']) continue;
                                      if($field['act']==0) continue;
                                      $typeControlView = strtolower($field['type']);
                                      $datasub['field'] = $field;
                                      if($type=='edit'||$type=='copy'){
                                        $datasub['dataitem'] = $data[0];  
                                      }
                                      if(file_exists(realpath(dirname(__FILE__)).'/view_edit/'.$typeControlView.'.php')){
                                        $this->load->view('view_edit/'.$typeControlView,$datasub);
                                      }
                                      else{
                                         $this->load->view('view_edit/base',$datasub);
                                      }
                                    }
                                  ?>
                            </div>
                        </div>
                    <?php    }
                    ?>
                  </div>
               </form>
              <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>
</div>