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

    public function __construct(UrlConfigService $urlConfigService)
    {
        $this->urlConfigService = $urlConfigService;
    }


    function careDeterminaPageNotFound()
    {
        $this->page_not_found = ceva gasit sau null
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

        $parse = new ParseXml($pageContent, $this->product, $this->data_json->request_vars);
        $parse->execute();
        $category = $parse->getCategory();
        $params = $parse->getParams();

        $done = false;
        $page = 1;
        $this->__spider->processing->products[$link] = [];
        while (!$done) {
            $data_r = $this->data_json;
            $params[$data_r->request_page] = $page;
            $this->_logger->log('output', "{$data_r->request_link} [$page]...");

            $contentBody = $this->fetchPageBody($params, $data_r->request_link);

            $content = [];
            if (is_object($contentBody)) {
                $container_r = $this->product->container;
                $content = $contentBody->$container_r;
                foreach ($content as $product) {
                    $p = array('category' => $category, 'got_from' => $link);
                    $info_r = $this->product->info;
                    foreach ($info_r as $key => $selector) {
                        if (!is_object($selector)) {
                            $p[$key] = $product->$selector;
                            $replace_r = $this->product->replace;
                            if (isset($replace_r->$key)) {
                                $r = $replace_r->$key;
                                foreach ($r as $pattern => $replacement) {
                                    $p[$key] = preg_replace($pattern, $replacement, $p[$key]);
                                }
                                $p[$key] = htmlspecialchars_decode(trim(strip_tags($p[$key])));
                            }
                            $p[$key] = htmlspecialchars_decode($p[$key]);
                        } else {
                            $p[$key] = null;
                        }
                    }
                    $this->__spider->processing->products[$link][] = $p;
                }
                if (count($content)) {
                    $page++;
                }
            }
            $this->_logger->log('output', "done\n", false);

            if (!count($content)) {
                break;
            }
        }
        if (count($this->__spider->processing->products[$link]) == 0) {
            unset($this->__spider->processing->products[$link]);
        } else {
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

    private function fetchPageBody(array $params, string $requestLink)
    {
        $this->_curl->__setPost($params);
        $this->_curl->makeRequest($requestLink);
        $response = $this->_curl->getLastResponse();
        $this->_curl->__unsetPost();
        $contentBody = json_decode($response['body']);
        return $contentBody;
    }

    private function insertProducts(UrlConfig $urlConfig)
    {

    }

    private function extractCategoryAndParams(string $pageContent): ParseXml
    {
        $x = \phpQuery::newDocument($pageContent); // asta &*#!&$*^%&@! ei pune pe campuri statice invizibile mie niste stare. care permite fct pq sa functioenze
        $category = Sample1::determineCategory($this->product->replace, $this->product->category);
        $params = Sample1::determineParams($this->data_json->request_vars);
        $x->unloadDocument();
        return new ParseXml($category, $params);
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