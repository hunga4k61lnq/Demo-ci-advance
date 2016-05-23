<div class="PageHeader row margin0">
         <div class="LogoHeader col-md-10 col-xs-12 padding0">
            <div class="logoimage hidden-sm hidden-xs">
               <a class="SiteName" href="<?php echo base_url().'Admin' ?>">
               <img border="0" class="imglogo" src="http://solutionsales.vn/upload/logo.png" alt="logo" title="logo">
               </a>
            </div>
            <div class="linkroot">
               <a class="SiteName" href="<?php echo base_url() ?>" target="_blank">
               <?php echo base_url() ?>
               </a>
            </div>
            <div class="menutop">
               <ul class="aclr">
                  <li class="fl"><i class="icon-trash"></i><a onclick="clearCache();return false;" href="Admin/deleteCache">Xóa cache</a></li>
                  <li class="fl"><i class="icon-cogs"></i><a  href="Admin/historyAccess">Lịch sử truy cập</a></li>
                  <li class="fl"><i class="icon-cogs"></i><a  href="Admin/editRobot">Robot</a></li>
                  <li class="fl"><i class="icon-list-alt"></i><a href="Admin/viewSitemap">Sitemap</a></li>
               </ul>
               <script type="text/javascript">
               function clearCache(){
                  $.ajax({
                     url: 'Admin/deleteCache',
                     type: 'POST',
                     data: {param1: 'value1'},
                  })
                  .done(function() {
                     console.log("success");
                  })
                  .fail(function() {
                     console.log("error");
                  })
                  .always(function() {
                     console.log("complete");
                  });
                  
               }
               </script>
            </div>
         </div>
         <div class="SystemMenu col-md-2 col-xs-12">
            <div style="display: block;">
               <ul class="sysMenu">
                  <li class="last">
                     <div class="btn-group">
                        <a href="" class="btn account-info btn-info">
                        <i class="icon-user"></i>
                        <?php echo $this->session->userdata()['userdata']['user']['username']; ?>
                        </a><a href="" data-toggle="dropdown" class="btn btn-info dropdown-toggle dropdown-toggle-acount"><span class="icon-caret-down"></span></a>
                        <ul class="dropdown-menu custome">
                           <li><a href="" onclick="changePass();return false;"><i class="icon-key"></i>Đổi mật khẩu</a>
                           </li>

                           <li>
                              <a id="siteUser_Lbtn_Logout" class="NormalGray" href="Admin/logout"><i class="icon-signout"></i> Thoát</a>
                           </li>
                        </ul>
                        <script type="text/javascript">
                         $(document).ready(function() {
                              $('#modal-login .close').click(function(event) {
                                 $('#modal-login').hide(500);
                              });
                           });
                        function changePass(){
                              $('#modal-login').show(500);
                           }
                        </script>
                     </div>
                  </li>
               </ul>
               <div style="clear: both"></div>
            </div>
         </div>
      </div>