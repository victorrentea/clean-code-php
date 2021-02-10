<?php


namespace victor\sample;



use function Cassandra\Type;


function pq(string $selector):array {

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

    private static function getPqValue(array $z, mixed $value): string
    {

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
        // prepare request
        $x = \phpQuery::newDocument($pageContent);
        $info_r = $this->product->info;
        $container_r = $this->product->container;

        $replace_r = $this->product->replace;

        $category = Sample1::determineCategory($this->product->replace, $this->product->category);

        $params = [];
        $data_r = $this->data_json;
        foreach ($data_r->request_vars as $var_name => $value) {
            $temp = null;
            if (is_object($value)) {
                $y = pq($value->selector);
                foreach ($y as $z) {
                    $z = pq($z);
                    $params[$var_name] = self::getPqValue($z, $value);
                    break;
                }
            } else {
                $params[$var_name] = $value;
            }
        }
        $x->unloadDocument();

        $done = false;
        $page = 1;
        $this->__spider->processing->products[$link] = [];
        while (!$done) {

            $params[$data_r->request_page] = $page;
            $this->_logger->log('output', "{$data_r->request_link} [$page]...");
            $this->_curl->__setPost($params);
            $this->_curl->makeRequest($data_r->request_link);

            $response = $this->_curl->getLastResponse();
            $content = json_decode($response['body']);
            if (is_object($content)) {
                $content = $content->$container_r;
            } else {
                $content = [];
            }
            if (count($content)) {
                foreach ($content as $product) {
                    $p = array('category' => $category, 'got_from' => $link);
                    foreach ($info_r as $key => $selector) {
                        if (!is_object($selector)) {
                            $p[$key] = $product->$selector;
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
                $page++;
            } else {
                $done = true;
            }
            $this->_curl->__unsetPost();
            $this->_logger->log('output', "done\n", false);

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

    private static function determineCategory(ReplaceR $replace_r, CategoryR $category_r): string
    {
        $category = '';
        if (is_object($category_r)) {
            $category_pq = pq($category_r->selector);
            foreach ($category_pq as $c) {
                $c = pq($c);
                $category = self::getPqValue($c, $category_r);
                break;
            }
            if (isset($replace_r->category)) {
                $r = $replace_r->category;
                foreach ($r as $pattern => $replacement) {
                    $category = preg_replace($pattern, $replacement, $category);
                }
                $category = trim(strip_tags($category));
            }
        }
        return $category;
    }

    private function insertProducts(UrlConfig $urlConfig)
    {

    }

}