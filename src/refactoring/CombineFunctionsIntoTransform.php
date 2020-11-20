<?php


namespace victor\refactoring;

class CombineFunctionsIntoTransform
{
    static function generateQRCode(string $code): string
    {
        return "QR" . $code;
    }

    static function getAddress(int $eventId): string
    {
        return "In vale";
    }

    // ----------- a line -------------

    public function generateTicket(Ticket $ticket)
    {
        $invoice = "Invoice for " . $ticket->getCustomerName() . "\n";

        $invoice .= "QR Code: " . self::generateQRCode($ticket->getCode()) . "\n";
        $invoice .= "Address: " . self::getAddress($ticket->getEventId()) . "\n";
        $invoice .= "Please arrive 20 minutes before the start of the event\n";
        $invoice .= "In case of emergency, call 0899898989\n";
        return $invoice;
    }
}







// ----- SUPPORTING, DUMMY CODE ------

class Ticket
{

    public function getCustomerName()
    {
        return "EU";
    }

    public function getCode()
    {
        return "12313213214";
    }

    public function getEventId()
    {
        return "1351";
    }
}


// nu vreau sa am in aceeasi clasa si campuri mutable si immutable.

// nu vreau sa am in aceeasi clasa si metode conrete si abstract
class X {

    // si cod concret
    static function  boot(Hooks $hooks) {
        $func1 = $hooks->beforeHook(1);
        //cod

        $func1 = $hooks->afterHook(1);
        //cod
        $func1 = $hooks->cleanupHook(1);

    }
}

interface Hooks {
    function beforeHook(int $s);
    function afterHook(int $s);
    function cleanupHook(int $s);
}

//X::boot([AfterHook1::class, 'metRef']); // nu e bun ca nu stii cand o chemi ce param primeste
X::boot(new AfterHook1()); // nu e bun ca nu stii cand o chemi ce param primeste

interface AfterHook {
    function __invoke(int $i): string;
}

class AfterHook1 implements AfterHook {

    function __invoke(int $i): string
    {
        // TODO: Implement __call() method.
        return "a";
    }

    static function  metRef(int $i): string
    {
        // TODO: Implement __call() method.
        return "a";
    }
}