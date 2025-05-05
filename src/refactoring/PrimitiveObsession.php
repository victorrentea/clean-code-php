<?php

enum PaymentMethod: string
{
    case CARD = "CARD";
    case CASH = "CASH";

    public static function isValid(string $paymentMethod): bool
    {
        return in_array($paymentMethod, array_column(self::cases(), 'value'));
    }
}

class PrimitiveObsession
{
    public const string PAYMENT_METHOD_CARD = "CARD";
    public const string PAYMENT_METHOD_CASH = "CASH";

    public function main()
    {
        $this->primitiveObsession(PaymentMethod::CARD);
//        $this->primitiveObsession("1");
    }

    // Simulating fetchData()
    public function fetchData(PaymentMethod $paymentMethod): array
    {
        $customerId = 1;
        $product1Count = 2;
        $product2Count = 4;
        return [
            $customerId => [
                "Table" => $product1Count,
                "Chair" => $product2Count
            ]
        ];
    }

    public function primitiveObsession(PaymentMethod $paymentMethod)
    {
//        if ($paymentMethod !== "CARD" && $paymentMethod !== "CASH") {
        if (!in_array($paymentMethod, [PaymentMethod::CARD, PaymentMethod::CASH])) {
            throw new InvalidArgumentException("Only CARD payment method is supported");
        }

        $map = $this->fetchData($paymentMethod);

        foreach ($map as $customerId => $products) {
            $pl = implode(", ", array_map(function ($product, $count) {
                return "$count pcs. of $product";
            }, array_keys($products), $products));

            echo "cid=$customerId got $pl\n";
        }
    }
}

$app = new PrimitiveObsession();
$app->main();