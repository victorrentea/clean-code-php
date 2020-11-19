<?php


namespace victor\clean;


(new ManyParamsOOP())->bizLogic([
    'a'=>'a',
    'b'=>1,
    's'=>'s',
    'c'=>4,
    'fileName'=>'file.txt',
    'versionId'=>1,
    'reference'=>'ref',
    'listId'=>5,
    'recordId'=>4,
    'g'=>'g'

]);
class ValidatorFactory {
    private OtherDependency $dep;

    public function createValidator(int $sellerId):Validator
    {
        return new Validator($this->dep, $sellerId);
    }

}

class ManyParamsOOP
{

    private ValidatorFactory $factory;

    public function __construct(ValidatorFactory $factory)
    {
        $this->factory = $factory;
    }

    public function bizLogic(array $x)
    {

        $sellerId = 1;
        // > de 4/5 din functii au acelasi param in semnatura -===> setXsellerId()

        $validator = $this->factory->createValidator($sellerId);

//        $this->validator->setSellerId($sellerId);

        // 1 poti sa uiti s-o faci. starea lui validator poate sa fie incompleta. ==> bug runtime
        // 2 datorita DepInje-> 1 instanta de Validator / appp => sellerId ramane setat si poate sa 'curga': alte invocari ale validatorului in alte parti,
        // ar putea sa foloseasca acelasi sellerId din greseala
        $validator->m1($x['a'], $x['b']);
        $validator->m2($x['a'], $x['s'], $x['c']);
        $validator->m3($x['a'], $x['fileName'], $x['versionId'], $x['reference']);
        $validator->m4($x['a'], $x['listId'], $x['recordId'], $x['g']);
        $validator->m5($x['b']);
        $errors = $validator->getErrors();
        if (!empty($errors)) {
            throw new \Exception($errors);
        }
        // RIP $validator
    }
}

class Validator
{
    private OtherDependency $dep;
    private int $sellerId;
    private array $errors = [];

    public function __construct(OtherDependency $dep, int $sellerId)
    {
        $this->dep = $dep;
        $this->sellerId = $sellerId;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

//    public function setSellerId(int $sellerId): void
//    {
//        $this->sellerId = $sellerId;
//    }

    public function m1(string $a, int $b)
    {
        echo "Running for {$this->sellerId}";
        if ($a === '') {
            $this->errors[]= 'a must not be null';
        }
    }

    public function m2(string $a, string $s, int $c)
    {
        echo "Running for {$this->sellerId}";
        if ($c < 0) {
            $this->errors[]="negative c";
        }
        // stuff

    }

    public function m3(string $a, string $fileName, int $versionId, string $reference)
    {
        echo "Running for {$this->sellerId}";
        // stuff

    }

    public function m4(string $a, int $listId, int $recordId, string $g)
    {
        echo "Running for {$this->sellerId}";
        // stuff

    }

    public function m5(int $b)
    {
        echo "Running for {$this->sellerId}";
        // stuff
    }
}

class OtherDependency
{

}
