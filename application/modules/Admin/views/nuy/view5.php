<?php
  $table = $table[0];

?>
<script type="text/javascript">
$= jQuery.noConflict();
  $(document).ready(function() {
    // Change checkbox
    $('.cbone').change(function(event) {
      
      $('.cball').prop('checked', false);
      if($(this).is(':checked')){
        var tr = $(this).parent().parent();
        tr.css({ 'background-color':'rgb(8, 111, 166)','color':'#fff'})
        tr.find('a').css({'color':'#fff'});
      }
      else{
        var tr = $(this).parent().parent();
        tr.css({ 'background-color':'','color':''})
        tr.find('a').css({'color':''});
      }

      getDataDeleteAll();
    });

    //Checkall
    $('.cball').change(function(event) {
      
      if($(this).is(':checked')){
        $('td input.cbone').prop('checked', true);
        var tr = $('td input.cbone').parent().parent();
        tr.css({ 'background-color':'rgb(8, 111, 166)','color':'#fff'})
        tr.find('a').css({'color':'#fff'});
      }
      else{
         $('td input.cbone').prop('checked', false);
         var tr = $('td input.cbone').parent().parent();
        tr.css({ 'background-color':'','color':''})
        tr.find('a').css({'color':''});
         
      }

      getDataDeleteAll();
    });
    function getDataDeleteAll(){
      var arr = $('td input.cbone:checked');
      var str = "";
      for (var i = 0; i < arr.length; i++) {
        var item = arr[i];
        str += $(item).attr('dt-value');
        if(i<arr.length-1){
          str+=",";
        }
      }
      $('.cball').attr('dt-delete', str);
    }

    // Update One Field
    function updateOneField(_this){
      var datapri = $(_this).attr('data-primary');
      var uName = $(_this).attr('name');
      var uValue = $(_this).val();
      if($(_this).attr('type')=='checkbox'){
        uValue = $(_this).is(':checked')?1:0;
      }
      checkReload=false;
      $.ajax({type:'POST', 
      url: "Admin/updateOneField/<?php echo $table['name'] ?>", data:{where:datapri,name:uName,newValue:uValue}, global:true,
      success: function(response) {
      }});
    }


      //Sửa trực tiếp
      var currentEditableInput = undefined;
      $('input[type=text].editable').dblclick(function(event) {
        $(this).prop('readonly',false);
        $(this).css('background','#fff');
        currentEditableInput = this;
      });  
      $(document).click(function(e){
         if( currentEditableInput !=undefined &&  !$(currentEditableInput).is( e.target ) ) {
            $(currentEditableInput).prop('readonly',true);
            $(this).css('background','');
            updateOneField(currentEditableInput);
            currentEditableInput = undefined;
         } 
      }); 
      $('input[type=checkbox].editable').click(function(event) {
          updateOneField(event.target);
      }); 
      // End = //Sửa trực tiếp



  });
    function deleteAll(){
       var datawhere = $('input.cball').attr('dt-delete');
       if(datawhere.length>0){
          bootbox.confirm("Bạn có thực sự muốn xóa các <?php echo $table['name'] ?> này không?", function(){
            checkReload=false;
            
              $.ajax({
                      url: 'Admin/deleteAll',
                      type: 'POST',
                      data: {ids:datawhere,table:"<?php echo $table['name']; ?>"},
                    })
                  .done(function(e) {
                    try{
                      var json = $.parseJSON(e);
                      if(json.code==SUCCESS){
                        window.location.href="Admin/view/<?php echo $table['name']; ?>";
                      }
                    }
                    catch(e){

                    }
                  })
                  .fail(function() {
                    console.log("error");
                  })
                  .always(function() {
                    console.log("complete");
                  });
          });
        }
        else{
          bootbox.alert("Bạn chưa chọn <?php echo $table['name'] ?> để xóa !");
        }
    }
    function deleteItem(_this){
      checkReload=false;
      var datawhere =$(_this).attr('dt-delete');
      $.ajax({type:'POST', 
        url: "Admin/delete/<?php echo $table['name'] ?>", data:{where:datawhere},
        success: function(response) {
            try{
              var jsdata = $.parseJSON(response);
              if(jsdata.code==SUCCESS){
                $(_this).parent().parent().hide();
              }
            }
            catch(e){
              console.log(e);
            }
        }});
    }
</script>
<div id="Breadcrumb" class="Block Breadcrumb ui-widget-content ui-corner-top ui-corner-bottom">
    <ul>
        <li class="home"><a href="<?php echo base_url(''); ?>Admin"><i class="icon-home" style="font-size:14px;"></i> Trang chủ</a></li>
        <li class="SecondLast"><a href="Admin/view/<?php echo $table['name'] ?>"><?php echo $table['note'] ?></a></li>
    </ul>
</div>
<div id="cph_Main_ContentPane">
   <div class="widget row margin0">
      <div class="widget-title">
       
         <h4>
            <i class="icon-qrcode"></i>&nbsp; <?php echo $table['note'] ?>
         </h4>
         <div class="ui-widget-content ui-corner-top ui-corner-bottom">

            <div id="toolbox">
               <div style="float:right;" class="toolbox-content">
                  <table class="toolbar">
                     <tbody>
                        <tr>
                          <?php if($table['help']==1){ ?>
                           <td align="center">
                              <a onclick="" id="" onclick="" title="Trợ giúp" class="toolbar btn btn-info" href=""><i class="icon-question-sign"></i>&nbsp;
                              Trợ giúp</a>
                           </td>
                           <?php } ?>
                           <?php if($table['insert']==1) { ?>
                           <td align="center">
                              <a id="" title="Thêm mới" class="toolbar btn btn-info" href="<?php echo base_url().'Admin/'.'insert/'.$table['name']?>"><i class="icon-plus"></i>&nbsp;
                              Thêm mới</a>
                           </td>
                           <?php } ?>
                           <?php if($table['delete']==1) { ?>
                           <td align="center">
                              <a onclick="deleteAll();return false;"  id="" href="javascript:deleteAll();" title="Xóa" class="deleteall toolbar btn btn-info"><i class="icon-trash"></i>&nbsp;
                              Xóa</a>
                           </td>
                          <?php } ?>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <div class="clr"></div>
            </div>
         </div>
         <div id="hiddenToolBarScroll" class="scrollBox" style="display:none">
            <h4>
               <i class="icon-qrcode"></i>&nbsp;<?php if(@$table) echo $table['note']; ?>
            </h4>
            <div class="FloatMenuBar">
               <div class="ui-widget-content ui-corner-top ui-corner-bottom">
                  <div id="toolbox">
                     <div style="float:right;" class="toolbox-content">
                        <table class="toolbar">
                           <tbody>
                              <tr>
                                <?php if($table['help']==1){ ?>
                                 <td align="center">
                                    <a onclick="" id="" title="Trợ giúp" class="toolbar btn btn-info" href=""><i class="icon-question-sign"></i>&nbsp;
                                    Trợ giúp</a>
                                 </td>
                                 <?php } ?>
                                 <?php if($table['insert']==1){ ?>
                                 <td align="center">
                                    <a id="" title="Thêm mới" class="toolbar btn btn-info" href="<?php echo base_url().'Admin/'.'insert/'.$table['name']?>"><i class="icon-plus"></i>&nbsp;
                                    Thêm mới</a>
                                 </td>
                                 <?php } ?>
                                 <?php if($table['delete']==1){ ?>
                                 <td align="center">
                                    <a onclick="deleteAll();return false;"  href="javascript:deleteAll();"  id="" title="Xóa" class="deleteall toolbar btn btn-info" href=""><i class="icon-trash"></i>&nbsp;
                                    Xóa</a>
                                 </td>
                                 <?php } ?>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div class="clr"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="widget-body">
        <?php if($table['search']==1){ ?>
         <div class="row-fluid">
            <div class="">
              

              <form action="Admin/search/<?php echo $table['name'] ?>" class="" method="post">
                <div class="row margin0">
                  <?php 
                    foreach ($lstSimpleSearchable as $value) {
                      $typeControlView = strtolower($value['type']);
                      echo "<input type='hidden' value ='".$typeControlView."' name = 'nuytype_".$value['name']."'/>";
                      if(!file_exists(realpath(dirname(__FILE__)).'/view_search/'.$typeControlView.'.php')){
                        $datasub['value']=$value;
                        $this->load->view('view_search/base',$datasub);
                      }
                      else{
                        $datasub['value']=$value;
                        $this->load->view('view_search/'.$typeControlView,$datasub);
                      }
                    }
                    
                    ?>
                  </div>
                
                              
                <div class="row margin0">
                  <label for="">Sắp xếp</label>
                  <select name="order_by" id="">
                    <?php 
                         foreach ($titles as $key => $item) {
                           echo "<option value='".$item['name']."'>".$item['note']."</option>";
                     }
                     ?>
                  </select>
                  <label for="">Thứ tự</label>
                  <select name="ord" id="">
                    <option value="ASC">A->Z</option>
                    <option value="DESC">Z->A</option>

                  </select>
                </div>
                <div class="controlsearch row margin0">

                 <button type="submit" name="submit" value="Lọc" id="" class="btn"><i class="icon-filter"></i> Lọc</button>
                 <button type="reset" name="submit" onclick="window.location.href='Admin/view/<?php echo $table['name'] ?>'" id="" class="btn"><i class="icon-refresh"></i>Làm mới</button>
                 <button type="button" name="submit" data-toggle="modal" data-target="#advanceSearch" id="" class="btn"><i class="icon-search"></i>Tìm kiếm nâng cao</button>
                </div> 
             </form>
              

            </div>
            
         </div>



        <div id="advanceSearch" class="modal fade " role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <form action="">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tìm kiếm nâng cao</h4>
              </div>
              <div class="modal-body">
                <div class="row margin0">
                   <?php 
                    foreach ($lstSearchable as $value) {
                      
                      $typeControlView = strtolower($value['type']);
                      $datasub['value']=$value;
                      $datasub['is_dialog']=1;
                      if(!file_exists(realpath(dirname(__FILE__)).'/view_search/'.$typeControlView.'.php')){
                        $this->load->view('view_search/base',$datasub);
                      }
                      else{

                        $this->load->view('view_search/'.$typeControlView,$datasub);
                      }
                    }
                    
                    ?>
                </div>
                <div class="row margin0">
                  <label for="">Sắp xếp</label>
                  <select name="order_by" id="">
                    <?php 
                         foreach ($titles as $key => $item) {
                           echo "<option value='".$item['name']."'>".$item['note']."</option>";
                     }
                     ?>
                  </select>
                  <label for="">Thứ tự</label>
                  <select name="ord" id="">
                    <option value="ASC">A->Z</option>
                    <option value="DESC">Z->A</option>

                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-default">Tìm kiếm</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
              </form>
            </div>

          </div>
        </div>
        <?php } ?>














         <div class="row margin0">

            <div class="col-md-3 col-xs-12 padding0">
               <div style="">
                  Tổng số : <span style="color: #A52A2A;"><?php echo $total_rows; ?> bản ghi</span>
               </div>
            </div>
            <div class="col-md-9 col-xs-12 padding0">
               <div class="pagination pagination-small pagination-right">
              <?php
                echo $this->pagination->create_links();
                ?>
               </div>
               <div class="clr"></div>
            </div>
         </div>
         <div class="row margin0">

       <div id="no-more-tables">
            <table class="col-md-12 table-bordered padding0 table-striped table-condensed cf">
            <thead class="cf">
              <tr>

                    <th scope="col">#</th>
                     <th align="left" scope="col">
                        <input id="" type="checkbox" name="cball" dt-delete="" class="cball" onclick="">
                     </th>
                     <?php 
                     foreach ($titles as $key => $item) {
                       if($item['type']!='PRIMARYKEY' && $item['view']==1){
                         echo "<th>".$item['note']."</th>";
                       }
                     }
                     ?>
                     <th style="min-width:70px" scope="col">
                        <label for="">Chức năng</label>
                     </th>
              </tr>
            </thead>
            <tbody>
                    <?php $i =0; foreach ($lstData as $key => $item) {
                      $primarykey = array();
                      $i++;
                      ?>
                      <tr> 
                      <td><?php echo $i; ?></td>   
                        <td><input id="" type="checkbox" class="cbone" dt-value="<?php echo $item['id'] ?>" name="cb<?php echo $item['id'] ?>" onclick=""></td>
                        <?php 
                        foreach ($titles as $val) {
                          
                          ?>
                          <?php
                          $datai['value'] = $item[$val['name']];
                          $typeControlView =strtolower($val['type']);
                          if($typeControlView=='primarykey'){
                            array_push($primarykey, array($val['name']=>$item[$val['name']]));
                          }
                          if(file_exists(realpath(dirname(__FILE__)).'/view/'.$typeControlView.'.php')){

                            $datasub['primarykey']= $primarykey;
                            $datasub['currentitem']= $item;
                            $datasub['currentvalue'] = $val;
                            $this->load->view('view/'.$typeControlView,$datasub);
                          }
                          else{
                            $this->load->view('view/base',$datai);
                          }
                        
?>
                        <?php }
                        ?>
                      
                         <td data-title="Chức năng" align="center" style="  text-align: center;vertical-align: middle;">
                            <?php if($table['insert']){ ?>
                            <a href="Admin/copy/<?php echo $table['name'] ?>/<?php echo $item['id'] ?>" class="edit fnc" ><i class="icon-copy"></i></a>
                            <?php } ?>
                            <?php if($table['edit']){ ?>
                            <a href="Admin/edit/<?php echo $table['name'] ?>/<?php echo $item['id'] ?>" class="edit fnc" ><i class="icon-edit"></i></a>
                            <?php } ?>
                            <?php if($table['delete']){ ?>
                            <a href="#" dt-delete='<?php echo json_encode($primarykey) ?>' onclick = "javascript:deleteItem(this);return false;" class="delete fnc"><i class="icon-trash"></i></a>
                            <?php } ?>
                         </td>
                      </tr>
                    <?php } ?>
                      
            </tbody>
          </table>
        </div>



          
         </div>
         <div class="pagination pagination-small pagination-right">
          
            <?php
                echo $this->pagination->create_links();
                ?>
            <div class="clr"></div>
         </div>
      </div>
   </div>
</div>


