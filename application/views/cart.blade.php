
@extends('index')
@section('content')
<form method="post" action="Vindex/updateCart">
	<div class="cart">
				<table width="100%">
					<thead>
						<tr>
							<th>Tên sản phẩm</th>
							<th>Giá sản phẩm</th>
							<th>Số lượng</th>
							<th>Tổng</th>
							<th></th>
						</tr>
					</thead>
					<tbody>


					<?php
					$total =0;

					 foreach ($content1 as $carts) {
						$price = !empty($carts['options']['price_sale'])?$carts['options']['price_sale']:$carts['price'];
					
						
					 ?>
					
						<tr>
							<td data-head="Tên sản phẩm"><a class="cart-pro-title" href="#" title=""><?php echom($carts,'name',1); ?></a></td>
							<td data-head="Giá sản phẩm"><?php echo !empty($carts['options']['price_sale'])?$carts['options']['price_sale']:$carts['price'] ?></td>
							<td data-head="Số lượng"><input name="<?php echo 'qty_'.$carts['rowid']; ?>" type="number" min="1" value="<?php echom($carts,'qty',1); ?>"></td>
							<td data-head="Tổng"><?php echo number_format($price*$carts['qty']); ?></td>
							<td data-head="Xóa khỏi giỏ"><a href="<?php echo base_url().'Vindex/delCart/'.$carts['rowid'];?>" title=""><i class="cart-del"></i></a></td>
						</tr>
						<?php
						$total+= $price*$carts['qty'];

						} 

						?>
						
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3">Tổng cộng</td>
							<td colspan="2"><?php echo number_format($total).' đ'; ?></td>
						</tr>
					</tfoot>
				</table>
				<div class="cart-bot">
					
					<div class="cart-btn1">
					
						<button type="submit" name="submit">Cap nhat</button>
						<a class="pay-cart" href="#" title="">Thanh toán</a>
					</div>
				</div>
			</div>
			</form>

<br><br><br><br><br>

			<div class="checkout">
				<div class="container">
					<div class="row">
						<div class="col-sm-6 col-xs-12">
							<h3 class="checkout-title">Chi tiết thanh toán</h3>
							<div class="checkout-detail">
								<form method="post" action="Vindex/order">
									<div class="checkout-line">
										<label>Họ và tên <span>*</span></label>
										<input type="text" name="ten" placeholder="Họ và tên" required>
									</div>
									<div class="checkout-line">
										<label>Số điện thoại <span>*</span></label>
										<input type="text" name="sdt" placeholder="Số điện thoại" required>
									</div>
									<div class="checkout-line">
										<label>Email <span>*</span></label>
										<input type="email" name="email" placeholder="Email" required>
									</div>
									<div class="checkout-line">
										<label>Địa chỉ nhận hàng <span>*</span></label>
										<textarea required rows="2" name="diachi" placeholder="Địa chỉ nhận hàng"></textarea>
									</div>
									<div class="checkout-line">
										<label>Thời gian nhận</label>
										<input type="text" name="thoigian" placeholder="Thời gian nhận">
									</div>
									<div class="checkout-line">
										<label>Ghi chú, yêu cầu</label>
										<textarea rows="3" name="noidung" placeholder="Ghi chú, yêu cầu"></textarea>
									</div>
									<div class="checkout-line">
										<button type="submit" name="submitt">Thanh toán</button>
									</div>
								</form>
							</div>
						</div>
						<div class="col-sm-6 col-xs-12">
							<h3 class="checkout-title">Thông tin giỏ hàng</h3>
							<div class="checkout-cart-info">
								<table width="100%">
									<thead>
										<tr>
											<th>Tên sản phẩm</th>
											<th>Giá sản phẩm</th>
											<th>Số lượng</th>

										</tr>
									</thead>
									<tbody>
									<?php 
									$cartt = $this->CI->cart->contents();
									$total=0;
									foreach ($cartt  as $cart2) {
										$price = !empty($cart2['options']['price_sale'])?$cart2['options']['price_sale']:$cart2['price'];
									

									 ?>
										
										<tr>
											<td data-head="Tên sản phẩm"><a class="cart-pro-title" href="<?php echom($cart2,'slug',1); ?>" title="<?php echom($cart2,'name',1); ?>"><?php echom($cart2,'name',1); ?></a></td>
											<td data-head="Giá sản phẩm"><?php echo !empty($cart2['options']['price_sale'])?$cart2['options']['price_sale']:$cart2['price'] ?></td>
											<td data-head="Số lượng"><?php echom($cart2,'qty',1); ?></td>
										</tr>
										<?php
										$total+= $price*$cart2['qty'];


										 } ?>
									
									</tbody>
								</table>
								<div class="checkout-total">
									<p><span>Tổng giá:</span> <?php echo number_format($total).' đ'; ?></p>
									<p><span>Phí vận chuyển:</span> miễn phí</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<br><br><br><br><br>
@stop