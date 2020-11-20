<?php


namespace victor\refactoring;

// pp ca era managed by container
class CustomerRepo
{
    private CLicenseQuery $licenseQuery;
    private AltaDepInjectat $alta;

    public function __construct(CLicenseQuery $licenseQuery, AltaDepInjectat $alta)
    {
        $this->licenseQuery = $licenseQuery;
        $this->alta = $alta;
    }

    function search(array $criteria): array
    {
        $query = (new CustomerSearchQuery($criteria, $this->alta))->search();
    }
}


class CustomerSearchQuery {

    private $params = [];
    private $dql = "SELECT p.id FROM Parent p  WHERE 1=1   ";

    private array $criteria;
    private AltaDepInjectat $alta;


    public function __construct(array $criteria, AltaDepInjectat $alta)
    {
        $this->criteria = $criteria;
        $this->alta = $alta;
    }

    function search(): array
    {
        $this->addNameCriteria();
        $this->addCategoryCriteria();

        echo "Create query $this->dql\n";
        foreach ($this->params as $param) {
            echo "Set param '$param'=" . $this->params[$param];
        }
    }

    private function addNameCriteria(): void
    {
        if (isset($this->criteria['name'])) {
            $this->dql .= '    AND p.name = ?    ';
            $this->params[] = $this->criteria['name'];

            // Campurile modificabile e rele.
            echo "Fac altfel un pic aici treaba";
        }
    }

    private function addCategoryCriteria(): void
    {

        if (isset($this->criteria['category'])) {
            $this->dql .= ' AND p.category = ?  ';
            $this->params[] = $this->criteria['category'];
        }
    }
}