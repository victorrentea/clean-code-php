<?php


namespace victor\sample;


use function Cassandra\Type;


function pq(string $selector): array
{

}

class Sample1
{


    private Product $product;
    private DataJson $data_json;
    private CURL $_curl;


    private UrlConfigService $urlConfigService;
    private MonitoringService $monitoringService;
    private Logger $_logger;
    private ?string $page_not_found;
    private $__spider;
    private $parse;

    public function __construct(UrlConfigService $urlConfigService)
    {
        $this->urlConfigService = $urlConfigService;
    }


    function careDeterminaPageNotFound()
    {
        // $this->page_not_found = ceva gasit sau null
    }

    /**
     * @throws \Exception
     */
    private function processJson(UrlConfig $urlConfig)
    {
        $link = $urlConfig->getUrl();  // TODO responsabilitatea lui URLConfig sa curete URLul

        $job = $this->monitoringService->initChildJob($link, JobType::CATEGORY);
        $this->monitoringService->publishJob($job);

        try {
            $this->tryProcessJson($link, $urlConfig);
        } catch (\Exception $ex) {
            // persist trebi in DB
            throw $ex;
        } finally {
            $this->monitoringService->terminateJob();
        }
    }

    private function tryProcessJson($link, $urlConfig): void
    {
        $pageContent = $this->getPageContent($link);
        if ($this->isNotFound($pageContent)) {
            $this->reportNotFound($link);
            return;
        }

        $this->parse = new ParseXml($pageContent, $this->product, $this->data_json->request_vars);
        $this->parse->execute();

        for ($page = 1; ; $page++) {
            $this->_logger->log('output', "{$this->data_json->request_link} [$page]...");
            $wasEmptyPage = $this->processPage($page, $link);
            $this->_logger->log('output', "done\n", false);

            if ($wasEmptyPage) {
                break;
            }
        }
        if ($this->someDataFound($link)) {
            $urlConfig = $this->urlConfigService->configureCategoryPage(array(
                    'url' => $link,
                    'linkType' => $urlConfig->getLinkType(),
                    'emagCategory' => $urlConfig->getEmagCategory(),
                )
            );
            $this->insertProducts($urlConfig);
        }
    }

    private function getPageContent($link): string
    {
        $this->_logger->log('output', "$link...");
        /// Cod era aici
        $s = "a";
        $this->_logger->log('output', "done\n", false);
        return $s;
    }

    private function isNotFound(string $pageContent): bool
    {
        if (!$pageContent) {
            return false;
        }
        return $this->page_not_found !== null && str_contains($pageContent, $this->page_not_found);
    }

    /**
     * @param $link
     */
    private function reportNotFound($link): void
    {
        if (!isset($this->__spider->processing->content[$link])) {
            $this->__spider->processing->failed[] = $link;
        }
    }

    /**
     * @param int $page
     * @param $link
     * @return true if empty page
     * @throws \Exception
     */
    private function processPage(int $page, $link): bool
    {
        $params = $this->parse->getParams();
        $params[$this->data_json->request_page] = $page;

        $dom = $this->fetchJsonContainer($params, $this->data_json->request_link);

        if (!count($dom)) {
            return true;
        }
        foreach ($dom as $productDom) {
            $p = $this->scrapProduct($productDom);
            $p['category'] = $this->parse->getCategory();
            $p['got_from'] = $link;

            if (!isset($this->__spider->processing->products[$link])) {
                $this->__spider->processing->products[$link] = [];
            }
            $this->__spider->processing->products[$link][] = $p;
        }
        return false;
    }

    /**
     * @param array $params
     * @param $requestLink
     * @throws \Exception
     */
    private function fetchJsonContainer(array $params, $requestLink)
    {
        $this->_curl->__setPost($params);
        $this->_curl->makeRequest($requestLink);
        $response = $this->_curl->getLastResponse();
        $this->_curl->__unsetPost();

        $contentBody = json_decode($response['body']);

        if (!is_object($contentBody)) {
            return [];
        }
        $container_r = $this->product->container;
        return $contentBody->$container_r;
    }

    private function scrapProduct($productDom): array
    {
        $extractedData = [];
        foreach ($this->product->info as $key => $selector) {
            $extractedData[$key] = $this->extractKeyText($key, $selector, $productDom);
        }
        return $extractedData;
    }

    private function extractKeyText(string $key, mixed $selector, $productDom): ?string
    {
        if (is_object($selector)) {
            return null;
        }
        $text = $productDom->$selector;
        $replace = $this->product->replace;
        if (isset($replace->$key)) {
            $replacements = $replace->$key;
            foreach ($replacements as $pattern => $replacement) {
                $text = preg_replace($pattern, $replacement, $text);
            }
            $text = htmlspecialchars_decode(trim(strip_tags($text)));
        }
        return htmlspecialchars_decode($text);
    }

    private function insertProducts(UrlConfig $urlConfig)
    {

    }

    private function fetchPageBody(array $params, string $requestLink)
    {
        $this->_curl->__setPost($params);
        $this->_curl->makeRequest($requestLink);
        $response = $this->_curl->getLastResponse();
        $this->_curl->__unsetPost();
        return json_decode($response['body']);
    }

    private function extractCategoryAndParams(string $pageContent): ParseXml
    {
        $x = \phpQuery::newDocument($pageContent); // asta &*#!&$*^%&@! ei pune pe campuri statice invizibile mie niste stare. care permite fct pq sa functioenze
        $category = Sample1::determineCategory($this->product->replace, $this->product->category);
        $params = Sample1::determineParams($this->data_json->request_vars);
        $x->unloadDocument();
        return new ParseXml($category, $params);
    }

    /**
     * @param $link
     * @return bool
     */
    private function someDataFound($link): bool
    {
        return isset($this->__spider->processing->products[$link]);
    }
}

class ParseXml
{
    private string $pageContent;
    private Product $product;
    private array $request_vars;

    private string $category; // out
    private array $params; // out

    public function __construct(string $pageContent, Product $product, array $request_vars)
    {
        $this->pageContent = $pageContent;
        $this->product = $product;
        $this->request_vars = $request_vars;
    }

    public function execute(): void
    {
        $x = \phpQuery::newDocument($this->pageContent); // asta &*#!&$*^%&@! ei pune pe campuri statice invizibile mie niste stare. care permite fct pq sa functioenze
        $this->category = self::determineCategory($this->product->replace, $this->product->category);
        $this->params = self::determineParams($this->request_vars);
        $x->unloadDocument();
    }

    private static function determineCategory(ReplaceR $replace_r, PQR $category_r): string
    {
        if (!is_object($category_r)) {
            return '';
        }
        $category = self::computeFirstPQValue($category_r);
        if (isset($replace_r->category)) {
            $r = $replace_r->category;
            foreach ($r as $pattern => $replacement) {
                $category = preg_replace($pattern, $replacement, $category);
            }
            $category = trim(strip_tags($category));
        }
        return $category;
    }

    private static function computeFirstPQValue(PQR $value): string
    {
        $y = pq($value->selector);
        if (empty($y)) {
            return '';
        }
        $y0 = reset($y);
        return self::getPqValue(pq($y0), $value);
    }

    private static function getPqValue(array $z, PQR $value): string
    {

    }

    private static function determineParams($request_vars): array
    {
        $params = [];
        foreach ($request_vars as $var_name => $value) {
            $temp = self::determineParamValue($value);
            if ($temp != '') {
                $params[$var_name] = $temp;
            }
        }
        return $params;
    }

    private static function determineParamValue(PQR $value)
    {
        if (!is_object($value)) {
            return $value;
        }
        return self::computeFirstPQValue($value);
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
// class XmlParseResult {
//     private string $category;
//     private array $params;
//
//     public function __construct(string $category, array $params)
//     {
//         $this->category = $category;
//         $this->params = $params;
//     }
//
//     public function getCategory(): string
//     {
//         return $this->category;
//     }
//
//     public function getParams(): array
//     {
//         return $this->params;
//     }
// }