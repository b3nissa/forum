<?php // no direct access
defined('_JEXEC') or die('Restricted access');

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

<!-- Virtuemart 2 Ajax Card -->
<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?>" id="vmCartModule<?php echo $params->get('moduleid_sfx'); ?>">
<?php
if ($show_product_list) {

		$aantal_producten = explode(" ", $data->totalProductTxt);
		if($aantal_producten[0] > 0) {
			echo  '<div class="total_products">'.$aantal_producten[0]."</div>";
		} else {
			echo "";
		}
?>

	<div class="total" style="float: right;">
		<?php

		?>

		<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
			<span>
			<?php
				$prijs = explode(" ", $data->billTotal);

				echo $prijs[2];

			?>
		</span>
		<?php } ?>
	</div>

		<div class="vmcontainer_wrapper">
	<div class="hiddencontainer" style="display: none;">
		<div class="vmcontainer">
			<div class="product_row">
				<span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span>

			<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
				<div class="subtotal_with_tax" style="float: right;"></div>
			<?php } ?>
			<div class="customProductData"></div><br>
			</div>
		</div>
	</div>
	<div class="winkelwagen-wrapper">
		<div class="winkelwagen-titel">
	<div class="vm_cart_products">
		<div class="vmcontainer">
		<?php
			foreach ($data->products as $product){
		?><div class="product_row">
					<div class="quantity"><?php echo  $product['quantity'] ?></div>

					<div class="product_name">
						<div class="naam-centering">
							<div class="naam">
								<?php echo $product['product_name'] ?>
							</div>
						</div>
					</div>

				<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
				  <div class="subtotal_with_tax" style="float: right;"><?php echo $product['subtotal_with_tax'] ?></div>
				<?php } ?>
				<!-- <?php if ( !empty($product['customProductData']) ) { ?>
					<div class="customProductData"><php echo $product['customProductData'] ?></div><br>

				<?php } ?> -->

			</div>
		<?php }
		?>
		</div>
		<!--Ga naar winkelwagen-->
		<!--<div class="show_cart">-->
			<!--php if ($data->totalProduct) echo-->
			<?php if ($data->totalProduct) echo '<div class="show_cart">'. $data->cart_show ."</div>";?>
		<!--</div>-->
	</div>
</div>

		</div>
<?php } ?>

<div style="clear:both;"></div>
<?php
$view = vRequest::getCmd('view');
if($view!='cart' and $view!='user'){
	?><div class="payments-signin-button" ></div><?php
}
?>
<noscript>
<?php echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
</noscript>
</div>
