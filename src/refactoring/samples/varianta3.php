<?php


class ExplodeCompositeOrder
{	private function calculate_voucher_all_products(
        VoucherHelper $voucherHelper
        , $cart_products
        , VoucherValue $voucherValue
        , $without_discount = false
    )
    {
		$voucher_value = 0;

        $selectedCategories = $voucherHelper->getSelectedCategories();
        $selectedCategoriesAre = $voucherHelper->getSelectedCategoriesAre();

        $selectedManufacturers = $voucherHelper->getSelectedManufacturers();
        $selectedManufacturersAre = $voucherHelper->getSelectedManufacturersAre();

        $voucherValueIsPercentage = $voucherValue->isPercentage();

		foreach ($cart_products as $cp)
        {
            if($selectedCategories)
            {
                if(
                    ($selectedCategoriesAre == 'excluded')
                    && $this->isProductInCategories($cp['product_id'], $selectedCategories)
                ){
                    continue;
                }

                if(
                    ($selectedCategoriesAre == 'included')
                    && ( ! $this->isProductInCategories($cp['product_id'], $selectedCategories))
                ){
                    continue;
                }
            }

            if($selectedManufacturers)
            {
                $productManufacturerID = $this->getProductManufacturerID($cp['product_id']);

                if($selectedManufacturersAre == 'excluded')
                {
                    if(in_array($productManufacturerID, $selectedManufacturers)){
                        continue;
                    }
                }

                if($selectedManufacturersAre == 'included')
                {
                    if( ! in_array($productManufacturerID, $selectedManufacturers)){
                        continue;
                    }
                }
            }

            if( ! $voucherValueIsPercentage){
                return $voucherValue->getValue();
            }

			if ($this->CartModel instanceof InvoiceCart){
				$product_price = (float)$cp->get('product_price_old') ? $cp->get('product_price_old') : $cp->getPrice();
			}else{
				if($without_discount && (float)$cp->get('product_price_old')){
					$product_price = 0;
				}else{
					$product_price = (float)$cp->getPrice();
				}
			}

			$voucher_value += (($product_price * $voucherValue->getValue()) / 100) * $cp->getQuantity();
		}

		return $voucher_value;
	}

