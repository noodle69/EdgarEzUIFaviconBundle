<?php

namespace Edgar\EzUIFavicon\Generator;

use Edgar\EzUIFaviconBundle\Exception\FaviconException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class Generator
{
    const STATUS_200 = 200;
    const STATUSSUCCESS = 'success';
    const FAVICONS_DIR = '_favicons';

    /**
     * @var string RealFaviconGenerator api key
     */
    private $apiKey;

    /**
     * @var array favicon design
     */
    private $faviconDesign;

    /**
     * @var bool if versioning
     */
    private $versioning;

    /**
     * @var string baseurl
     */
    private $baseurl;

    /**
     * @var string uri
     */
    private $uri;

    /**
     * Generator constructor.
     * @param string $apiKey
     * @param array $faviconDesign
     * @param bool $versioning
     * @param string $baseurl
     * @param string $uri
     */
    public function __construct(
        string $apiKey,
        array $faviconDesign,
        bool $versioning,
        string $baseurl,
        string $uri
    ) {
        $this->apiKey = $apiKey;
        $this->faviconDesign = $faviconDesign;
        $this->versioning = $versioning;
        $this->baseurl = $baseurl;
        $this->uri = $uri;
    }

    /**
     * @param $picturePath
     * @param $imagePath
     * @return Response
     * @throws FaviconException
     */
    public function callAPI($picturePath, $imagePath): Response
    {
        $parameters = [
            'master_picture_path' => $picturePath,
            'image_path' => $imagePath,
            'favicon_design' => $this->faviconDesign,
            'versioning' => $this->versioning,
        ];
        $queryData = new QueryData($this->apiKey, $parameters);

        try {
            return $this->getResponse($queryData);
        } catch (FaviconException $e) {
            throw $e;
        }
    }

    /**
     * @param QueryData $queryData
     * @return Response
     * @throws FaviconException
     */
    protected function getResponse(QueryData $queryData): Response
    {
        $request = new Request('POST', $this->baseurl . $this->uri, [], $queryData->__toString());
        $client = new Client();
        try {
            $response = $client->send($request);
        } catch (GuzzleException $e) {
            throw new FaviconException($e->getMessage());
        }

        if ($response->getStatusCode() !== self::STATUS_200) {
            throw new FaviconException('API call return status : ' . $response->getStatusCode());
        }

        return $response;
    }

    /**
     * @param Response $response
     * @param string $fileLocation
     * @param string $varDir
     * @throws FaviconException
     */
    public function decodeResponse(Response $response, string $fileLocation, string $varDir)
    {
        $body = json_decode($response->getBody());

        if (isset($body->favicon_generation_result->result->status)
            && (int)$body->favicon_generation_result->result->status == self::STATUSSUCCESS
        ) {
            $packageUrl = $body->favicon_generation_result->favicon->package_url;
            $content = file_get_contents($packageUrl);

            $packageInfo = pathinfo(parse_url($packageUrl, PHP_URL_PATH));
            $packageName = $packageInfo['filename'];

            $packageFile = $fileLocation . '/' . $packageName . '.' . $packageInfo['extension'];

            $fp = fopen($packageFile, 'w');
            if ($fp) {
                fwrite($fp, $content);
                $this->unpackIcons($packageFile, $fileLocation);
                $this->createView($body, $fileLocation, $varDir);
            }
        } else {
            throw new FaviconException('Bad API Response');
        }
    }

    /**
     * @param string $packageFile
     * @param string $fileLocation
     */
    protected function unpackIcons(string $packageFile, string $fileLocation)
    {
        $zip = new \ZipArchive();
        if ($zip->open($packageFile) === true) {
            $zip->extractTo($fileLocation);
            $zip->close();
        }
    }

    /**
     * @param $content
     * @param string $fileLocation
     * @param string $varDir
     */
    protected function createView($content, string $fileLocation, string $varDir)
    {
        $htmlContent = $content->favicon_generation_result->favicon->html_code;
        $htmlContent = explode("\n", $htmlContent);
        $pattern1 = '/href="([^"]*)"/';
        $pattern2 = '/content="([^"]*)"/';
        $replacement1 = 'href="{{ asset(\'%s\') }}"';
        $replacement2 = 'content="{{ asset(\'%s\') }}"';
        $htmlResult = array();
        foreach ($htmlContent as $line) {
            $replacement = false;
            $pattern = false;
            preg_match($pattern1, $line, $matches);
            if (isset($matches[1])) {
                $replacement = $replacement1;
                $pattern = $pattern1;
            } else {
                preg_match($pattern2, $line, $matches);
                if (isset($matches[1])) {
                    $replacement = $replacement2;
                    $pattern = $pattern2;
                } else {
                    $htmlResult[] = $line;
                }
            }
            if ($replacement) {
                $imageInfo = pathinfo($matches[1]);
                if (isset($imageInfo['extension'])) {
                    $argReplacement = $varDir . $matches[1];
                    $htmlResult[] = preg_replace($pattern, sprintf($replacement, $argReplacement, $line), $line);
                } else {
                    $htmlResult[] = $line;
                }
            }
        }

        $fp = fopen($fileLocation . '/favicons.html.twig', 'w');
        fwrite($fp, implode("\n", $htmlResult));
        fclose($fp);
    }
}
