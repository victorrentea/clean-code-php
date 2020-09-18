<?php


namespace victor\clean;


class ManyParamsVO
{
    public function placeOrder(FullName $fullName, Address $address)
    {

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
        if ($firstName === '' || $lastName === '') {
            throw new \Exception();
        }
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function asEnterpriseName(): string
    {
        return $this->firstName . ' ' . strtoupper($this->lastName);
    }

    public function withLastName(string $newLastName) : FullName
    {
        return new FullName(
            $this->firstName,
            $newLastName);
    }
}

class Address
{
    private string $city;
    private string $streetName;
    private int $streetNumber;
}

(new ManyParamsVO())->placeOrder(new FullName('John', 'Doe'), new Address('St. Albergue', 'Paris', 99));

class AnotherClass
{
    public function otherMethod(string $firstName, string $lastName, int $x)
    {

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
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    //CHALLENGE
    public function changeLastName(string $newLastName): void
    {
        $this->fullName = $this->fullName->withLastName($newLastName);
    }

}

$rita = new Person("Rita", "Turcan");
$victor = new Person("Victor", "Rentea");

$rita->changeLastName($victor->getFullName());

echo $rita->getFullName()->asEnterpriseName();

class PersonService
{
    public function f(Person $person)
    {
        echo $person->getFullName()->asEnterpriseName();
    }

    public function p(string $city, string $streetName, int $streetNumber)
    {
        echo "Living in " . $city . " on St. " . $streetName . " " . $streetNumber;
    }
}