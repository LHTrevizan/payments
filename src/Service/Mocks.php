<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Response\CurlResponse;

class Mocks
{
  /**
   * @var httpClient
   */
  private $httpClient;

  public function __construct()
  {
    $this->httpClient = HttpClient::create();
  }

  public function validationPayment()
  {
    try {
        $response = $this->httpClient->request('GET', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');

        return json_decode($response->getContent(), true);
    } catch (\Exception $e) {
        return ['message' => 'Não Autorizado'];
    }
  }

  public function notifyUser($userId)
  {
    try {
        $response = $this->httpClient->request('GET','http://o4d9z.mocklab.io/notify');
        $message = json_decode($response->getContent(), true)['message'];

        if ($message !== 'Success') {
          throw new \Exception("Error Processing Request", 500);
        }
        return 'enviado';
    } catch (\Exception $exception) {
        return ['message' => $exception->getMessage()];
    }
  }
}
