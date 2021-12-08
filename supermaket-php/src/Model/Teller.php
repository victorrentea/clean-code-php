<?php

declare(strict_types=1);

namespace Supermarket\Model;

use Ds\Map;

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

    public function addSpecialOffer(SpecialOfferType $offerType, Product $product, float $argument): void
    {
        $this->offers[$product] = new Offer($offerType, $product, $argument);
    }

    public function checkoutArticlesFrom(ShoppingCart $cart): Receipt
    {
        $receipt = new Receipt();
        foreach ($cart->getItems() as $productQuantity) {
            $unitPrice = $this->catalog->getUnitPrice($productQuantity->getProduct());
            $totalPrice = $productQuantity->getQuantity() * $unitPrice;
            $receipt->addProduct($productQuantity->getProduct(), $productQuantity->getQuantity(), $unitPrice, $totalPrice);
        }

        $cart->handleOffers($receipt, $this->offers, $this->catalog);

        return $receipt;
    }
}
