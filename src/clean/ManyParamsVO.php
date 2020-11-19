<?php


namespace victor\clean;



(new ManyParamsVO())->placeOrder(new PersonFullName('John', 'Doe'), 'St. Albergue', 'Paris', 99);

class ManyParamsVO
{

    public function placeOrder(PersonFullName  $fullName, string $city, string $streetName, int $streetNumber)
    {
        if ($fullName->getFirstName() === '' || $fullName->getLastName() != '') {
            throw new \Exception();
        }
        echo "de livrat la $city  $streetName $streetNumber";
        echo "Some logic \n";
    }
}

//class User { // prea generica
//    string $firstName;
//    string $lastName;
//    //cat ai fost tu la baie, colegu a "lasat si el aici" 10 campuri
//    string email; id; twitter handle;
//}
//class SalesPerson { tot 200 camuri}
class Address {
    private string $city;
    private string $streetName;
    private int $streetNumber;

    public function __construct(string $city, string $streetName, int $streetNumber)
    {
        $this->city = $city;
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
    }

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function getStreetNumber(): int
    {
        return $this->streetNumber;
    }

    public function getCity(): string
    {
        return $this->city;
    }
}

class PersonFullName {
    private string $firstName;
    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function asString(): string
    {
        return $this->firstName . ' ' . strtoupper($this->lastName);
    }
}




// TODO
class BillingAddressWeird extends Address {
    // ce in plus ?
//    fiscalCode
//logica diferita
}
// preferam compozitia
class BillingAddress {
    private Address $address;
}


//class Shopper [50 campuri]

//class Billing - nu fa si d-asta, ca te-ntrebi cu ce diferta
//class BillingInformation // daca asa-i in api, d-apai asa sa fie
//class BillingDetails -// aici sunt mai multe campuri
//class BillingData //wtf!!?
//class Billing //wtf!!?
//class BillingPerson {fn,ln,address} //wtf!!?
//
//class DeliveryInformation
//class Information
//class PersonalData
//class Customer
//class CustomerInfo
//class Info












class AnotherClass {
    public function otherMethod(PersonFullName $fullName, int $x) {
    	if ($fullName->getFirstName() === '' || $fullName->getLastName() === null) throw new \Exception();

    	echo "Another distant Logic";
    }

    public function handle2(Person $person)
    {
        $this->handle(new Person());
    }

    public function handle(Person $person): string
    {
        return $person->getFullName()->getFirstName();
    }
}

class GeneralException extends \Exception {
    private string $codeStr;
    public function __construct($message = "", $codeStr, Throwable $previous = null)
    {
        parent::__construct($message, null, $previous);
        $this->codeStr = $codeStr;
    }


}

// Entity - din alea sfinte. D-alea de le persisti. Sacred Entities. Holy Grounds
class Person {
    private $id;
    private PersonFullName $fullName;
    private $phone;

    public function __construct(?string $firstName, $lastName) // TODO sa primim direct FullName
    {
        if ($firstName === '' || $lastName === '') {
            throw new \Exception();
        }

        $this->fullName = new PersonFullName($firstName, $lastName);
    }

    public function getFullName(): PersonFullName
    {
        return $this->fullName;
    }

//    public function setLastName(string $lastName): void
//    {
//        $this->lastName = $lastName;
//    }

}

class PersonService {
    public function f(Person $person) {
        echo $person->getFullName()->asString();
    }
    public function p(string $city, string $streetName, int $streetNumber) {
        echo "Living in " . $city . " on St. " . $streetName . " " . $streetNumber;
    }

}