<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OpenAIChatService
{
    protected string $apiKey = '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';
    protected Client $client;
    
    public function __construct()
    {
//        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }
    
    public function askQuestion(string $question): string
    {
        try {
            $response = $this->client->post('completions', [
                'json' => [
                    'model' => 'davinci',
                    'prompt' => $question,
                    'max_tokens' => 150,
                    'temperature' => 0.7,
                    'top_p' => 1,
                    'n' => 1,
                    'stop' => ['\n'],
                ],
            ]);
        } catch (GuzzleException $e) {
            dd("yesser");
        }
        
        $data = json_decode($response->getBody()->getContents(), true);
        if (isset($data['choices'][0]['text'])) {
            return $data['choices'][0]['text'];
        }
        return 'une erreur est survenue';
    }
}
