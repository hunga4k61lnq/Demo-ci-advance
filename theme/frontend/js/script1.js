
    function loadDanmLink(link,id){
        $.ajax({
            url: link,
            type: 'POST',
            data: {csrf_enuy_name: $('meta[name=csrf-token]').attr('content')},
        })
        .done(function(data) {
        	 $('.tab-content #cat'+id).html(data);
           
        })
        .fail(function() {
        })
        .always(function() {
        });
    }
    function loadDanm(id,pag){
        loadDanmLink('Vindex/pagiStupidView/'+id+'/'+pag,id);
        
    }
    function clickTab(_this){    	
        var h = $($(_this).attr('href')+' .item-cato');   
        if(h!=undefined && h.length>0){

        }
        else{
            loadDanm($(_this).attr('dt-id'),0);
        }
    }

    





jQuery(document).ready(function($) {
$('.footer .col-sm-8 .col-md-4:last-child>div').removeClass('branch');
});
   



  function sendContact(_this){  

       $.ajax({          type: "POST",          url: "Vindex/sendContact",       
   data:$(_this).serialize(),          success: function(json) {         },      
   error: function(XMLHttpRequest, textStatus, errorThrown) {          },     
   complete: function(data){ 

    try{
      var json = $.parseJSON(data.responseText);
      if((json.code)==200){
        alert(json.message);   
        window.location.href=window.location.href;

      }
      else{
         alert(json.message); 
      }
       
      


    }catch(e){

    }

  }     });   }    

 


  jQuery(document).ready(function($) {
  	$('.product-tab>ul>li:first-child').click();
   	
   });
 