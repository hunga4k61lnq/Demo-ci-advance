<?php $table = sizeof($table)>0?$table[0]:NULL;
if(!@$table)return;
$lstFields = array();
$type="edit";
$data = array();
$regions = $this->Admindao->getRegionField2($table['name']);



// "id": "297",
//         "name": "id",
//         "required": "1",
//         "note": "Id",
//         "length": "11",
//         "type": "PRIMARYKEY",
//         "create_time": "1",
//         "update_time": "1",
//         "link": "test",
//         "view": "0",
//         "editable": "1",
//         "simple_searchable": "1",
//         "searchable": "1",
//         "is_upload": "0",
//         "parent": "1",
//         "default_data": null,
//         "region": "1",
//         "help": "Mã",
//         "ord": "1",
//         "act": "1",
//         "referer": null

$i=0;
$arrdata  = array();
$arrLanguages = explode(',',$table['ext']);
foreach ($lstData as $items) {
  $arr = array();

  $arrExistKeyValue = array();
  foreach ($items as $key => $value) {
    $arr[$key]= $value;
    if(strpos($key, 'value') == strlen($key)-5){
      $lang = substr($key, 0,strlen($key)-6 );

      if(!in_array($lang, $arrLanguages))continue;
      array_push($arrExistKeyValue, $lang);
    }
  }
  foreach ($arrExistKeyValue as $keyvalue) {
    $arr['region']=array_key_exists('region', $items)?$items['region']:"1";;
    $arr['note']=array_key_exists('note', $items)?$items['note']."(".strtoupper($keyvalue).")":$items['id']."(".strtoupper($keyvalue).")";
    $arr['name']=array_key_exists('keyword', $items)?strtoupper($keyvalue)."_".$items['keyword']:"";


    $arr['act']=array_key_exists('act', $items)?$items['act']:"1";
    $arr['referer']=array_key_exists('referer', $items)?$items['referer']:"";
    $arr['type']=array_key_exists('type', $items)?$items['type']:"";
    $arr['default_data']=array_key_exists('default_data', $items)?$items['default_data']:"";


    // $arrdata[$arr['name']] = $items['vi_value'];
    $arrdata[$arr['name']] = $items[$keyvalue."_value"];

    $lstFields[$i] = $arr;
    $i++;
  }
  
}

array_push($data,$arrdata);
 ?>
<script type="text/javascript">
//Callback Responsive manager
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
          '<i onclick="$(this).parent().remove();" class="icon-remove-circle"></i><img style="height:85px" src="'+url+'"/>'+
          '<i onclick="$(this).parent().moveDown();changeListImage($(this).parent().parent(),$name);" class="icon-arrow-right" style="position:absolute;right:-15px;top:50%;    color: #810D0D;font-size: 30px;transform: translateY(-50%);"></i>'+
          '<i onclick="$(this).parent().moveUp();changeListImage($(this).parent().parent(),$name);" class="icon-arrow-left" style="position:absolute;left:-15px;top:50%;    color: #810D0D;font-size: 30px;transform: translateY(-50%);"></i></div>');
        }
        changeListImage(nxt,$name);
      }
    }
  }
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

  $(function() {
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
               <h4><i class="icon-list-alt"></i>&nbsp;<?php echo (@$type_title?$type_title:$type) ?>&nbsp;<?php if(@$table) echo @$table['note']?$table['note']:$table['name'] ?></h4>
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
              if(($type=='edit' && count($data)>=0 ) || $type!='edit') { ?>
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
                                      $datasub['type'] = $type;
                                      if($type=='edit'){
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