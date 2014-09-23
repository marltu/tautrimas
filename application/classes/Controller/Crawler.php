<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\DomCrawler\Crawler;

class Controller_Crawler extends Controller
{
    public function action_index()
    {
        $pages = ORM::factory('Page')->order_by('id', 'desc')->find_all();

        $template = View::factory('common/template');
        $template->body = View::factory('crawler/list')->set('pages', $pages);
        $this->response->body($template);
    }

    public function action_recent()
    {
        $pages = ORM::factory('Page')->order_by('id', 'desc')->limit(3)->find_all();

        $template = View::factory('common/template');
        $template->body = View::factory('crawler/list')->set('pages', $pages);
        $this->response->body($template);
    }

    public function action_crawl()
    {
        if ($this->request->post()) {
            $url = $this->request->post('url');
            $client = new Client();
            try {
                $response = $client->get($url);
                $body = (string)$response->getBody();
                $parser = new Crawler($body);
                $nodes = $parser->filter('h1,h2,h3,h4,h5,h6,p');
                $texts = $nodes->each(
                    function (Crawler $node) {
                        return $node->text();
                    }
                );
                $text = implode("\n", $texts);

                $language = $this->detectLanguage($text);

                /** @var Model_Page $page */
                $page = ORM::factory('Page');
                $page->url = $url;
                $page->body = $text;
                $page->lang = $language;
                $page->create();
            } catch (RequestException $e) {
            }
        }

        $template = View::factory('common/template');
        $template->body = View::factory('crawler/crawl');
        $this->response->body($template);
    }

    /**
     * @param $text
     * @return mixed
     */
    protected function detectLanguage($text)
    {
        $languagesStatistics = array(
            'en' => array(
                'e' => 12.02,
                't' => 9.1,
                'a' => 8.12,
                'o' => 7.68,
                'i' => 7.31,
            ),
            'lt' => array(
                'i' => 15.25,
                'a' => 10.43,
                's' => 9.34,
                't' => 6.74,
                'e' => 5.55,
            ),
        );

        $charStatsRaw = count_chars($text, 1);
        $charStats = array();
        foreach ($charStatsRaw as $code => $count) {
            $charStats[chr($code)] = $count;
        }

        $languageScores = array();

        foreach ($languagesStatistics as $language => $languageStatistics) {
            $intersection = array_intersect_key($charStats, $languageStatistics);
            ksort($intersection);
            ksort($languageStatistics);
            $dotProduct = array_sum(
                array_map(
                    function ($a, $b) {
                        return $a * $b;
                    },
                    $intersection,
                    $languageStatistics
                )
            );

            $sqr = function ($a) {
                return $a * $a;
            };

            $lengthSubject = sqrt(array_sum(array_map($sqr, $intersection)));
            $lengthTarget = sqrt(array_sum(array_map($sqr, $languageStatistics)));
            $languageScores[$language] = $dotProduct / ($lengthSubject * $lengthTarget);
        }

        arsort($languageScores);
        $matchedLanguage = array_keys($languageScores)[0];

        return $matchedLanguage;
    }
}
