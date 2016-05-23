
<script type="text/javascript">


    function buypro(id){
        var quantity=$('.quan'+id).val();

        console.log("vindex/addCart/"+id+"/"+quantity);
        $.ajax({
            type:"GET",
            url: "vindex/addCart/"+id+"/"+quantity,
            data: {},
            success: function(result){

                if(result==1){


                    var loginBox = '#them-di';


                    $('#them-di').load('vindex/viewCart');

                   
                    $(loginBox).fadeIn(500);

                   
                    $('body').append('<div id="over">');
                    $('#over').attr('dt-value',loginBox);
                    $('#over').fadeIn(300);

                    return true;
                }
                else{

                    alert('Lỗi trong quá trình đặt hàng');
                    return false;
                }


            },
            failure: function(msg){

                alert('Lỗi trong quá trình đặt hàng');
                return false;
            }



        });




    }

    function buypro_noquan(id){        

        console.log("vindex/addCart/"+id+"/1");
        $.ajax({
            type:"GET",
            url: "vindex/addCart/"+id+"/1",
            data: {},
            success: function(result){
			
                if(result==1){

                    var loginBox = '#them-di';


                    $('#them-di').load('vindex/viewCart');

                  
                    $(loginBox).fadeIn(500);

                    
                    $('body').append('<div id="over">');
                    $('#over').attr('dt-value',loginBox);
                    $('#over').fadeIn(300);

                    return true;
                }
                else{

                    alert('Lỗi trong quá trình đặt hàng oke');
                    return false;
                }


            },
            failure: function(msg){

                alert('Lỗi trong quá trình đặt hàng ');
                return false;
            }



        });




    }

</script>
<script type="text/javascript">

    function openform(){

        var loginBox = '#them-di';


        $('#them-di').load('vindex/viewCart');

        $(loginBox).fadeIn(500);


        $('body').append('<div id="over">');
        $('#over').attr('dt-value',loginBox);
        $('#over').fadeIn(300);

        return false;
    }

</script>

<div class="gio-cua-ban " id="them-di">


</div>



