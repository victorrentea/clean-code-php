<?php


namespace victor\clean;


(new ManyParamsOOP(new Validator(new OtherDependency())))->bizLogic([
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

class ManyParamsOOP
{
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function bizLogic(array $x)
    {

        $errors = [];
        $sellerId = 1;
        // > de 4/5 din functii au acelasi param in semnatura -===> setXsellerId()
        $this->validator->setSellerId($sellerId);
        // 1 poti sa uiti s-o faci. starea lui validator poate sa fie incompleta. ==> bug runtime
        // 2 datorita DepInje-> 1 instanta de Validator / appp => sellerId ramane setat si poate sa 'curga': alte invocari ale validatorului in alte parti,
                // ar putea sa foloseasca acelasi sellerId din greseala
        $errors = array_merge($errors, $this->validator->m1($x['a'], $x['b']));
        $errors = array_merge($errors, $this->validator->m2($x['a'], $x['s'], $x['c']));
        $errors = array_merge($errors, $this->validator->m3($x['a'], $x['fileName'], $x['versionId'], $x['reference']));
        $errors = array_merge($errors, $this->validator->m4($x['a'], $x['listId'], $x['recordId'], $x['g']));
        $errors = array_merge($errors, $this->validator->m5($x['b']));
        if (!empty($errors)) {
            throw new \Exception($errors);
        }
    }
}

class Validator
{
    private $dep;
    private int $sellerId;

    public function __construct(OtherDependency $dep)
    {
        $this->dep = $dep;
    }

    public function setSellerId(int $sellerId): void
    {
        $this->sellerId = $sellerId;
    }

    public function m1(string $a, int $b): array
    {
        echo "Running for {$this->sellerId}";
        if ($a === '') {
            return ['a must not be null'];
        }
        // stuff
        return [];
    }

    public function m2(string $a, string $s, int $c): array
    {
        echo "Running for {$this->sellerId}";
        if ($c < 0) {
            return ["negative c"];
        }
        // stuff
        return [];

    }

    public function m3(string $a, string $fileName, int $versionId, string $reference): array
    {
        echo "Running for {$this->sellerId}";
        // stuff
        return [];

    }

    public function m4(string $a, int $listId, int $recordId, string $g): array
    {
        echo "Running for {$this->sellerId}";
        // stuff
        return [];

    }

    public function m5(int $b): array
    {
        echo "Running for {$this->sellerId}";
        // stuff
        return [];
    }
}

class OtherDependency
{

}
