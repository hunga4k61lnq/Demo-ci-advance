<script type="text/javascript">
    function xoadl(rowid){
        $.ajax({
            type:"get",
            url:"<?php echo base_url('')?>vindex/removeCart/"+rowid,
            data:{},
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
                    alert('Có lỗi xảy ra !');
                    return false;

                }



            },
            failure: function(msg){
                alert('Có lỗi xảy ra !');
                return false;

            }



        })
    }


    function validateNumber(inputtxt){
        var phoneno = /^\d+$/;
        return phoneno.test(inputtxt);
    }



    function qtychange(rowid,quancu){





        var quant=$('#'+rowid).val();



        if(!validateNumber(quant)){
            alert("Nhập không phải là số dữ liệu không được cập nhật");
            $("#"+rowid).focus();
            $("#"+rowid).val(quancu);
            return false;
        }


        var  b="<?php echo base_url('').'vindex/updateCartOne/' ?>"+quant+"/"+rowid;
        console.log(b);



        $.ajax({
            type:"get",
            url:b,

            success:function(response){
                var loginBox = '#them-di';


                $('#them-di').load('vindex/viewCart');

                $(loginBox).fadeIn(500);

                $('body').append('<div id="over">');
                $('#over').attr('dt-value',loginBox);
                $('#over').fadeIn(300);


            },
            failure:function(msg){
                alert('Lỗi cmn rồi');

            }


        });





    }


    function dong(){
        parent.$.fancybox.close();
    }
    function closeDialogBuy(){
        var loginBox = '#them-di';


        $(loginBox).fadeOut(500);
        $('#over').attr('dt-value',loginBox);
        $('#over').remove();

    }
</script>

Giỏ hàng của bạn
<script>
    function xoasp(_this){
        var tr = $(_this).parent().parent();
        $(tr).remove();
    }
</script>
<a class="close" href="javascript:closeDialogBuy()"><span class="glyphicon glyphicon-remove move"></span></a>
<div class="table-responsive viewcart">

    <table class="table table-bordered ">
        <thead>
        <tr>
            <th class="active">Ảnh</th>
            <th class="active">Sản Phẩm</th>
            <th class="active">Giá</th>
            <th class="active">Số Lượng</th>
            <th class="active">Tổng Cộng</th>
            <th class="active">Xóa</th>
        </tr>
        </thead>
        <tbody>


        <?php $i = 1; ?>

        <?php foreach ($this->cart->contents() as $items): ?>

            <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>

            <tr class="xoa-bo">
                <td class="active">
                    <img src=" <?php echo $items['options']['img']; ?>" height="100" width="100" style=" margin-right: 10px">
                </td>
                <td class="active">

                    <a href="<?php echom ($items,'slug',0)?>" class="tieude"><?php echo $items['name']; ?></a><br>
                    <span></span>

                </td>
                <td class="active"><span class="sale"><?php echo number_format($items['price']) ." vnđ"; ?></span></td>
                <td class="active">
                    <input onchange="qtychange('<?php echo $items['rowid']; ?>',<?php echo $items['qty']; ?>)" type="text" id="<?php echo $items['rowid']; ?>" name="<?php echo $i; ?>" value="<?php echo $items['qty']; ?>" style="width: 20px;border:1px solid silver;padding:2px;text-align: center;">
                </td>
                <td class="active"><span class="sale"><?php echo number_format($items['subtotal'])." vnđ"; ?></span></td>
                <td class="active"><button onclick="xoadl('<?php echo $items['rowid']; ?>')" class="xoa-bo"><span class="glyphicon glyphicon-remove"></span></button></td>
            </tr>

            <?php $i++; ?>

        <?php endforeach; ?>




        <tr>
            <td colspan="2">
                <b>Thành tiền</b>
            </td>
            <td colspan="4">
                <span class="sale"><?php  echo number_format($this->cart->total()) . ' vnđ'; ?> </span>
            </td>
        </tr>
        </tbody>

    </table>

    <div class="modal-footer">
        <a href="dat-hang" class="btn btn-warning"><span class="glyphicon glyphicon-shopping-cart"></span> Đặt hàng!</a>
        <a href="javascript:closeDialogBuy()" class="btn btn-success " data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Đóng & Chọn thêm Sản Phẩm</a>
    </div>

</div>