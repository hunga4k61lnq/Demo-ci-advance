<div class="boder_menu">
            <div id="menu" class="col-md-12 hidden-sm hidden-xs">
               <ul class="margin0">
                  <?php 
                     $icon = ["icon-shopping-cart","icon-tags","icon-th-large","icon-user","icon-globe","icon-picture","icon-cogs"];
                    
                  ?>
       
                  <?php 
                  
                  $arrMenu = $this->session->userdata('userdata')['menu'];
                     foreach ($arrMenu as $key => $value) {
                        echo "<li>";
                        echo '      <a class="TopMenuItem">';
                        echo '      <span class="MenuText"><i class="'.$value->icon.'"></i>'.$value->name.'</span>';
                        echo '      </a>';
                        echo '<ul>';
                        foreach ($value->childs as $child) {
                           
                           echo '   <li class="SubFirst">';
                           echo '         <a href="Admin/'.$child['link'].'">'.$child['note'];
                           echo '         </a>';
                           echo '      </li>';
                           
                        }
                        echo '</ul>';
                        echo '   </li>';
                     }
                  ?>
               </ul>
               <div class="clr"></div>
            </div>
            <div class="mainmenu">
			    <nav class="">
			        <ul>
				            <?php 
	                     $icon = ["icon-shopping-cart","icon-tags","icon-th-large","icon-user","icon-globe","icon-picture","icon-cogs"];
	                    
	                  ?>
	       
	                  <?php 
	                  
	                  $arrMenu = $this->session->userdata('userdata')['menu'];
	                     foreach ($arrMenu as $key => $value) {
	                        echo "<li>";
	                        echo '      <a class="TopMenuItem">';
	                        echo '      <span class="MenuText"><i class="'.$value->icon.'"></i>'.$value->name.'</span>';
	                        echo '      </a>';
	                        echo '<ul>';
	                        foreach ($value->childs as $child) {
	                           
	                           echo '   <li class="SubFirst">';
	                           echo '         <a href="Admin/'.$child['link'].'">'.$child['note'];
	                           echo '         </a>';
	                           echo '      </li>';
	                           
	                        }
	                        echo '</ul>';
	                        echo '   </li>';
	                     }
	                  ?>
			        </ul>
			    </nav>
			</div>
         </div>