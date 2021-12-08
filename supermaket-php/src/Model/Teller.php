<?php

declare(strict_types=1);

namespace Supermarket\Model;

use Ds\Map;
use Supermarket\Model\offer\PercentDiscountOffer;
use Supermarket\Model\offer\QuantityDiscountOffer;
use Supermarket\Model\offer\ThreeForTwoOffer;

class Teller
{
    private SupermarketCatalog $catalog;

    /**
     * @var Map [Product => Offer]
     */
    private $offers;

    public function __construct(SupermarketCatalog $catalog)
    {
        $this->catalog = $catalog;
        $this->offers = new Map();
    }

    // public function addSpecialOffer___(ProductOffer $offer): void
    // {
    //     $this->offers[]=$offer;
    // }
    public function addSpecialOffer(SpecialOfferType $offerType, Product $product, float $argument): void
    {
        $this->offers[$product] = match ($offerType) {
            SpecialOfferType::TEN_PERCENT_DISCOUNT => new PercentDiscountOffer($product, $argument),
            SpecialOfferType::TWO_FOR_AMOUNT => new QuantityDiscountOffer($product, 2, $argument),
            SpecialOfferType::FIVE_FOR_AMOUNT => new QuantityDiscountOffer($product, 5, $argument),
            SpecialOfferType::THREE_FOR_TWO => new ThreeForTwoOffer($product)
        };

    }

    public function checkoutArticlesFrom(ShoppingCart $cart): Receipt
    {
        $receipt = new Receipt();
        foreach ($cart->getItems() as $productQuantity) {
            $unitPrice = $this->catalog->getUnitPrice($productQuantity->getProduct());
            $totalPrice = $productQuantity->getQuantity() * $unitPrice;
            $receipt->addProduct($productQuantity->getProduct(), $productQuantity->getQuantity(), $unitPrice, $totalPrice);
        }

        $cart->handleProductOffers($receipt, $this->offers, $this->catalog);

        return $receipt;
    }
}
