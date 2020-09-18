<?php


namespace victor\clean;


class ManyParamsVO
{
    public function placeOrder(FullName $fullName, Address $address)
    {
        if ($fullName->getFirstName() === '' || $fullName->getLastName() === '') {
            throw new \Exception();
        }
        echo "Some logic \n";
    }
}

//class Customer  { // too generic
//class Order  {  // too generic
//class OrderAddress  {  // too explicit
//class PlaceOrderRequest  {  // too explicit. can never be reused in other flows. Overengineering?
//class OrderDetails  // too vague
//class OrderData  // too vague
//class Client { // too vague
//class CustmerApelative { // ~~ kinda good
//class CustomerData { // bad suffix
//class CustomerName { // not reusable enough
class FullName { // too restrictive
    private string $firstName;
    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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

// HOLY ENTITY.hundrends of classes use this Person
class Person
{
    private $id;
    private $phone;
    private FullName $fullName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->fullName = new FullName($firstName, $lastName);
        if ($firstName === '' || $lastName === '') throw new \Exception();
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    //CHALLENGE
//    public function setLastName(string $lastName): void
//    {
//        $this->lastName = $lastName;
//    }

}

class PersonService
{
    public function f(Person $person)
    {
        $fullName = $person->getFullName()->getFirstName() . ' ' . strtoupper($person->getFullName()->getLastName());
        echo $fullName;
    }

    public function p(string $city, string $streetName, int $streetNumber)
    {
        echo "Living in " . $city . " on St. " . $streetName . " " . $streetNumber;
    }
}