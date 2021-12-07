<?php


namespace victor\clean;


class Address{
    private string $city;
    private string $streetName;
    private int $streetNumber;

    public function __construct(string $city, string $streetName, int $streetNumber)
    {
        $this->city = $city;
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreetName(): string

    {
        return $this->streetName;
    }

    public function getStreetNumber(): int
    {
        return $this->streetNumber;
    }
}
class FullName {
    private string $firstName;
    private string $lastName;

    public function __construct(string $fname, string $lname)
    {
        $this->firstName = $fname;
        $this->lastName = $lname;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}

class ManyParamsVO
{

    public function placeOrder(FullName $fullName, Address $address)
    {
        if ($fullName->getFirstName() === '' || $fullName->getLastName() === '') {
            throw new \Exception();
        }

        echo "Locuiesti pe {$address->getStreetName()} {$address->getStreetNumber()} in {$address->getCity()}";
        echo "Some logic \n";
    }

}

$v = 'John';
(new ManyParamsVO())->placeOrder( new FullName($v, 'Doe'), new Address('St. Albergue', 'Paris', 100));
(new ManyParamsVO())->placeOrder( new FullName('John', 'Doe'), new Address('St. Albergue', 'Paris', 99));
(new ManyParamsVO())->placeOrder( new FullName('John', 'Doe'), new Address('St. Albergue', 'Paris', 141));


class AnotherClass {
    public function otherMethod(string $firstName, string $lastName, int $x) {
    	if ($firstName === '' || $lastName === null) throw new \Exception();

    	echo "Another distant Logic";
    }
}

class Person {
    private $id;
    private $firstName;
    private $lastName;
    private $phone;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        if ($firstName === '' || $lastName === '') throw new \Exception();
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

}

class PersonService {
    public function f(Person $person) {
        $fullName = $person->getFirstName() . ' ' . strtoupper($person->getLastName());
        echo $fullName;
    }
    public function p(string $city, string $streetName, int $streetNumber) {
        echo "Living in " . $city . " on St. " . $streetName . " " . $streetNumber;
    }
}