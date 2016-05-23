



<div class="container">
    <div class="col-md-6">
        <div align="center"><h4 style="padding: 20px 0;">Thông tin đặt hàng</h4></div>
        <div class="alert alert-success alert-dismissible hidden-xs">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

        </div>
        <div class="alert alert-success alert-dismissible visible-xs">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <b>Ngại đặt hàng?</b> Gọi ngay:<br>
            <b><span class="glyphicon glyphicon-earphone"></span> 0914778689</b>
        </div>

        <div class="gap-top-bottom"></div>
        <ul class="nav nav-tabs nav-tabs1" role="tablist">
            <li class="active"><a class="hand_cursor"><b>Đặt hàng</b></a></li>
            <li><a data-toggle="modal" href="#customer_login_div"><b>Hoặc Đăng nhập</b></a></li>
        </ul>
        <div class="alert alert-info alert-dismissible" role="alert" style="margin-top:20px">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <strong>Mẹo!</strong> Nếu bạn có tài khoản tại <?php echo @$site[0]['name_cty'];  ?>, bạn nên <a data-toggle="modal" onclick="openModal2(this)" href="#customer_login_div"><b>ĐĂNG NHẬP</b></a> để xem thông tin đơn hàng của bạn!
        </div>



        <div class="gap-top-bottom"></div>
        <form action="dathang/luudl"  method="post" role="form" id="new_customer_order_form">

            <div class="form-group ">
                <label>Họ và tên*</label>
                <input type="text" class="form-control" name="ten" id="new_customer_name" required="" placeholder="Họ và tên" value="">
            </div>
            <div class="form-group ">
                <label>Số điện thoại*<span class="hidden"  id="old_customer_loading"> <img src="#"></span></label>
                <input type="text" class="form-control" name="sdt" id="new_customer_phone" placeholder="Số điện thoại" required="" value="">
                <div id="old_customer_noti"></div>
            </div>
            <div class="form-group ">
                <label>Email*</label>
                <input type="email" class="form-control" name="email" id="new_customer_email" placeholder="Email" required="" value="">
            </div>
            <div class="form-group ">
                <label>Địa chỉ nhận hàng*</label>
                <textarea rows="3" class="form-control" name="diachi" id="new_customer_address" required="" placeholder="Địa chỉ nhận hàng"></textarea>
            </div>
            <div class="form-group">
                <label>Thời gian nhận hàng</label>
                <input type="text" class="form-control" name="thoigian" id="new_customer_order_ship_time" placeholder="Chọn ngày và giờ bạn tiện nhận hàng">
            </div>
            <div class="form-group">
                <label>Ghi chú, yêu cầu đặc biệt</label>
                <textarea rows="2" class="form-control" name="noidung" id="new_customer_order_note" placeholder="Sơ chế, làm sạch, yêu cầu giao hàng..."></textarea>
            </div>
            <div align="center">
                <button
                    <?php
                    $count=0;
                    foreach($this->cart->contents() as $vl)
                        $count= $vl['qty']+$count;
                    if($count==0) echo "disabled";
                    ?>
                    type="submit" class="btn btn-lg btn-warning" id="new_customer_order_button">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Đặt hàng ngay!
                </button>
            </div>
        </form>
    </div>
    <div class="gap-top-bottom visible-xs visible-sm"></div>
    <div class="col-md-6" id="checkout_cart_container">
        <div align="center"><h4>Hóa đơn của bạn</h4></div>
        <div class="modal-body" style="font-size: 12px">
            <table class="table table-hover cart-table">
                <thead>
                <tr>
                    <th>
                        Sản phẩm
                    </th>
                    <th>
                        SL
                    </th>
                    <th>
                        Đơn giá
                    </th>
                    <th class="text-right">
                        Thành tiền
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr id="cart_product_33_row">

                    <?php $i = 1; ?>

                    <?php foreach ($this->cart->contents() as $items): ?>

                    <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>









                <tr id="cart_product_30_row" class="xoaluachon">
                    <td style="max-width: 150px;">
                        <a href="" target="_blank"><b><?php echo $items['name']; ?></b></a>
                    </td>
                    <td>
                        <span class="visible-xs">Số lượng:</span>
                        <?php echo $items['qty']; ?>
                    </td>
                    <td>
                        <span ><?php echo number_format($items['price']) ." ". $items['options']['dv']; ?></span>
                    </td>
                    <td align="right">
                        <span class="visible-xs">Thành tiền:</span>
                        <?php echo number_format($items['subtotal'])." ".$items['options']['dv']; ?>                           </td>

                </tr>


                <?php $i++; ?>

                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <!--<tr>
                    <th>
                        <i>Phí vận chuyển</i>
                    </th>
                    <th class="hidden-xs">

                    </th>
                    <th class="hidden-xs">

                    </th>
                    <th class="text-right">
                        15,000                        </th>
                </tr>-->
                <tr>
                    <th>
                        TỔNG SỐ TIỀN
                    </th>
                    <th class="hidden-xs">

                    </th>
                    <th class="hidden-xs">

                    </th>
                    <th class="text-right">
                        <?php  echo number_format($this->cart->total()) . ' vnđ'; ?>                        </th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="modal-footer">
            <button  onclick="openModal(this)"  class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Thay đổi Sản phẩm!</button>     </div>

    </div>
</div>