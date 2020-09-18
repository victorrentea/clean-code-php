<?php


namespace victor\clean;


class ManyParamsVO
{
    public function placeOrder(Customer $customer)
    {
        if ($fname === '' || $lname === '') {
            throw new \Exception();
        }
        echo "Some logic \n";
    }
}

class Customer  {
    private string $fname;
    private string $lname;
    // Mihai had to put something related to Customer somewere, so he added it here.
    // +5 fields.

    // +4 fields. billing info

    private Address $address;
}

class Address
{
    private string $city;
    private string $streetName;
    private int $streetNumber;
}

(new ManyParamsVO())->placeOrder('John', 'Doe', 'St. Albergue', 'Paris', 99);

class AnotherClass
{
    public function otherMethod(string $firstName, string $lastName, int $x)
    {
        if ($firstName === '' || $lastName === null) throw new \Exception();

        echo "Another distant Logic";
    }
}

class Person
{
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

class PersonService
{
    public function f(Person $person)
    {
        $fullName = $person->getFirstName() . ' ' . strtoupper($person->getLastName());
        echo $fullName;
    }

    public function p(string $city, string $streetName, int $streetNumber)
    {
        echo "Living in " . $city . " on St. " . $streetName . " " . $streetNumber;
    }
}