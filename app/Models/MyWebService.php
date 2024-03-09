<?php

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;

class MyWebService {
	private $client;
	private $fullURL;
	private $endpoint;
	private $baseURL;
  private $accessToken;

	public function __construct(string $uri) {
    $session = \Config\Services::session();
    $this->accessToken = $session->has('token') ? $session->get('token') : '';
		$this->endpoint = $uri;
    $this->baseURL = getenv('API_BASE_URL');
		$this->fullURL = $this->baseURL . $this->endpoint;
		$this->client = new Client();
	}

	public function post($payload, $query = null) {
    $url = $this->fullURL . ($query ? $query : '');

		try {
			$response = $this->client->post(
        $url,
        [
          RequestOptions::HEADERS => $this->setHeaders($this->accessToken),
          RequestOptions::JSON => $payload,
			  ]
      );

			return $response;
		} catch (RequestException $e) {
			return $e->getResponse();
		}
	}

	public function put($payload = null, $query = null) {
		$url = $this->fullURL . ($query ? $query : '');

		try {
			$response = $this->client->put(
				$url,
				[
					RequestOptions::HEADERS => $this->setHeaders($this->accessToken),
					RequestOptions::JSON => $payload,
				]
			);

			return $response;
		} catch (RequestException $e) {
			return $e->getResponse();
		}
	}

	public function get($payload = null, string $query = null) {
		$url = $this->fullURL . ($query ? $query : '');
    
    if ($this->endpoint === 'authentications') {
      if ($query === '/check') {
          $accessToken = $payload['token'];
      }

      if (explode('?', $query)[0] === '/check/site') {
          $accessToken = $this->accessToken;
      }

    } else {
        $accessToken = $this->accessToken;
    }

		try {
			$response = $this->client->get(
				$url,
				[
					RequestOptions::HEADERS => $this->setHeaders($accessToken),
          RequestOptions::JSON => $payload,
				]
			);

			return $response;
		} catch (RequestException $e) {
			return $e->getResponse();
		}
	}

	public function delete($payload = null, $query = null) {
    $url = $this->fullURL . ($query ? $query : '');

		try {
			$response = $this->client->delete(
        $url,
        [
          RequestOptions::HEADERS => $this->setHeaders($this->accessToken),
          RequestOptions::JSON => $payload,
			  ]
      );

			return $response;
		} catch (RequestException $e) {
			return $e->getResponse();
		}
	}

  public function postFile($filePath, string $query = null) {
    $fullURL = $this->fullURL . ($query ? $query : '');

    try {
        $response = $this->client->post($fullURL, [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
            RequestOptions::MULTIPART => [
                [
                    'name' => 'file',
                    'contents' => fopen($filePath, 'r'),
                    'filename' => basename($filePath),
                ],
            ],
        ]);

        return $response;
    } catch (RequestException $e) {
        return $e->getResponse();
    }
  }

	private function setHeaders($accessToken) {
    return [
      'Content-Type' => 'application/json',
      'Authorization' => 'Bearer ' . $accessToken
    ];
	}
}