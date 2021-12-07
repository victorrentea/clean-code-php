<?php


namespace victor\clean;


class TypeHintsAreMandatory
{

    private array $listDeString;

    /**
     * @param string[] $listDeString
     */
    public function __construct($listDeString)
    {
        $this->listDeString = $listDeString;
    }

    function m(bool $bou  = true)
    {

        foreach ($this->listDeString as $string) {

        }
    }
}

function undeva(TypeHintsAreMandatory $inst): string
{
    $nicioadata = "m";

    $inst->$nicioadata();

    $inst->m(vitel:false);
    throw new \Exception("Abstraction Leak");

}

/**
 * @param TypeHintsAreMandatory $inst
 */
function undeva2($inst)
{
    $inst->m(true);

}
undeva3(new TypeHintsAreMandatory());
function undeva3(TypeHintsAreMandatory $inst)
{
    $inst->m(true); // nu are typrhint

}

$inst = new TypeHintsAreMandatory();
undeva($inst);
