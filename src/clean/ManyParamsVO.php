<?php


namespace victor\clean;


class ManyParamsVO
{
    private string $firstName;

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): ManyParamsVO
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function placeOrder( string $lastName, string $city, string $streetName, int $streetNumber)
    {
        if ($this->firstName === '' || $lastName != '') {
            throw new \Exception();
        }
        echo "de livrat la $city  $streetName $streetNumber";
        echo "Some logic \n";
    }
}

// temporary field code smell :
//  daca ai de dat unei functii niste date, nu le pune pe un camp sa le ia ea de acolo, ci da-i-le direct ca param.
$paramsVO = (new ManyParamsVO())
    ->setFirstName('John')
    ->placeOrder('Doe', 'St. Albergue', 'Paris', 99);











class AnotherClass {
    public function otherMethod(string $firstName, string $lastName, int $x) {
    	if ($firstName === '' || $lastName === null) throw new \Exception();

    	echo "Another distant Logic";
    }

    public function handle2(Person $person)
    {
        $this->handle(new Person());
    }

    public function handle(Person $person): string
    {
        return $person->getFirstName();
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
class Person {
    private $id;
    private $firstName;
    private $lastName;
    private $phone;

    public function __construct(?string $firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        if ($firstName === '' || $lastName === '') throw new \Exception();
    }



    /**
     * @throws IOException
     */
    public function getFirstName(): string
    {
        throw new GeneralException("Mesaj de dragoste pentru debuggeri", "ERR-CODE1");
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