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
    private OtherDependency $other;

    public function __construct(OtherDependency $other)
    {
        $this->other = $other;
    }


    public function bizLogic(array $x)
    {
        $validator = new Validator($this->other);
        $validator->m1($x['a'], $x['b']);
        $validator->m2($x['a'], $x['s'], $x['c']);
        $validator->m3($x['a'], $x['fileName'], $x['versionId'], $x['reference']);
        $validator->m4($x['a'], $x['listId'], $x['recordId'], $x['g']);
        $validator->m5($x['b']);

        $errors = $validator->getErrors();
        if (!empty($errors)) {
            throw new \Exception($errors);
        }
    }
}
class Validator
{
    private $dep;

    /** @var string[] */
    private $errors;

    public function __construct(OtherDependency $dep)
    {
        $this->dep = $dep;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function m1(string $a, int $b)
    {
        if ($a === '') {
            $this->errors[]='a must not be null';
        }
        if ($b < 0)
            $this->errors[]='inca ceva';
        // stuff
        // return [];
    }

    public function m2(string $a, string $s, int $c)
    {
        if ($c < 0) {
            $this->errors[]="negative c";
        }

    }

    public function m3(string $a, string $fileName, int $versionId, string $reference)
    {
        // stuff

    }

    public function m4(string $a, int $listId, int $recordId, string $g)
    {
        // stuff

    }

    public function m5(int $b)
    {
        // stuff
    }
}

class OtherDependency
{

}
