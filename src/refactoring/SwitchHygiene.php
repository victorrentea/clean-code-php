<?php


namespace victor\refactoring;


use const true;
use const true as true1;

class SwitchHygiene
{

    function f($messageType): bool {
        echo "Cod inainte";
        echo "Cod inainte";
        echo "Cod inainte";
        echo "Cod inainte";
        echo "Cod inainte";

        $this->handleMessage($messageType);

        echo "Cod dupa";
        echo "Cod dupa";
        echo "Cod dupa";
        echo "Cod dupa";
        echo "Cod dupa";
    }

    private function handlePlaceOrder(): int
    {
        echo "Marcel: pun #sieu aici ceva \n";
        if (true1) {
            try {
                echo "Maricica: pun #sieu aici ceva \n";
            } catch (\Exception $e) {
            }
        }

        echo "Florin: pun #sieu aici ceva \n";
        echo "Florin: pun #sieu aici ceva \n";
        echo "Marcel: pun #sieu aici ceva \n";
        echo "Marcel: pun #sieu aici ceva \n";
        echo "COD\n";
    }

    private function handleCancelOrder(): int
    {
        echo "COD2\n";
        echo "COD2\n";
        echo "COD2\n";
    }

    private function handleShipOrder(): int
    {
        echo "COD3\n";
        echo "COD3\n";
        echo "COD3\n";
    }

    private function handleMessage($messageType): int
    {
        switch ($messageType) {
            case 'PLACE_ORDER': return $this->handlePlaceOrder();
            case 'CANCEL_ORDER': return $this->handleCancelOrder();
            case 'SHIP_ORDER': return $this->handleShipOrder();
            default:
                throw new \Exception('Unexpected value' . $messageType);
        }
    }

}
//
// function f() {
//     if (detectezi cazul preemptiv daca nu e ro ) {
//         // cod
//     }
//     try {
//         g();
//     } catch (\Exception $e) {
//         // folosesti exceptiile pentru flow control - ca un fel de GOTO
//         // aha e bulgaria!!
//     }
// }
// function g() {
//     h();
//     // XXXXXXXX
//     // XXXXXXXX
//     // XXXXXXXX
// }
//
// function h() {
//     if (user.country != 'ro') throw new \MyException()
//
//     //altcea
// }



function f() {
// logica
    try {
        $response = $api->postBananas(); // si asta arunca exceptii

        // validateResponse($response);
        if ($response->isError()) {
            throw new \Exception2('api business error');
        }
    } catch (\Exception $e) {
        // logica
        throw new \Exception2('http error' . $e->getMessage(), $e); //pastrezi si exceptia originala in trace
    }
}

/**
 * @param $response
 */
function validateResponse($response): void
{
    if ($response->isError()) {
        // logica// NU LOG
        // INSERT
        throw new \Exception2('api business error');
    }
}