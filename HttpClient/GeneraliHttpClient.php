<?php

declare(strict_types=1);

namespace MppGeneraliClientBundle\HttpClient;

use GuzzleHttp\Client;
use http\Exception;
use Symfony\Component\HttpFoundation\Response;

class GeneraliHttpClient
{

    /** @var Client */
    private $guzzleClient;
    private $parameters;
    private $endpoint;

    private $path = '/v2.0/transaction/';

    private const STEPS = [
        "INITIATE" => "initier",
        "CHECK" => "verifier",
        "CONFIRM" => "confirmer",
        "FINALIZE" => "finaliser"
    ];

    private const PRODUCTS = [
        "SOUSCRIPTION" => "souscription",
        "VERSEMENTLIBRE" => "versementLibre",
        "VERSEMENTLIBREPROGRAMMES" => "versementLibreProgrammes",
        "ARBITRAGE" => "arbitrage",
    ];

    /**
     * GeneraliHttpClient constructor.
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
        $this->endpoint = $this->parameters->get('generali_endpoint');
    }


    /**
     * @param string $step
     * @param string $product
     * @param array $parameters
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stepSouscription(string $step, string $product, array $parameters)
    {
        if (in_array($step, self::STEPS, true) && in_array($product, self::PRODUCTS, true)) {
            $url_point = $this->endpoint . $this->path . $product .$step;

            try{
                $response = $this
                    ->guzzleClient
                    ->request('POST', $url_point, $this->requestOptions($parameters));

                return $response->getBody();
            }catch (\Exception $exception){
                return $exception->getMessage();
            }
        }
        return false;
    }

    /**
     * @param array $body
     * @return array
     */
    private function requestOptions(array $body)
    {
        return [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'apiKey' => $this->parameters->get('generali_api_key')
            ],
            'body' => $body,
        ];
    }
}