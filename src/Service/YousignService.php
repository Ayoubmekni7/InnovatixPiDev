<?php

namespace App\Service;

/*use Symfony\Component\Mime\Part\DataPart;*/

use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class YousignService
{
    private const PATHFILE = __DIR__ .'/../../public/';
    public function __construct(
        private HttpClientInterface $yousignClient,) { }
    public function signatureRequest(): array
    {
        $response= $this->yousignClient->request(
            'POST',
            'signature_requests' ,
            [
                'body' => <<<JSON
                    {
                    "name": "Demande de Chéque" ,
                    "delivery_mode" : "email",
                    "timezone": "Afrique/Tunisie"

                    }
                    JSON,
                'headers'=>[
                    'Content-Type'=>'application/json',
                ],

            ]
        );
        $statusCode =$response->getStatusCode();

        if($statusCode != 201){
            throw new \Exception('Error whole creating signature request');

        }
        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    public function uploadDocument(string $signatureRequestId , string $filename): array
    {
        $formFields = [
            'nature'=>'signable_document',
            'file'=>DataPart::formPath(self::PATHFILE . $filename ,$filename, 'pdfCheque')

        ];
        $formData=new FormDataPart($formFields);
        $headers= $formData->getPreparedHeaders()->toArray();

        $response =$this ->yousignClient->request(
            'POST',
            sprintf('signature_requests/%s/documents' , $signatureRequestId),
            [
                'headers' =>$headers,
                'body'=>$formData->bodyToIterable(),
            ]
        );
        $statusCode = $response ->getStatusCode();
        if($statusCode != 201){
            throw new \Exception('Error while uploading document');
        }
        return $response->toArray();

    }
    public function addSigner(
        string $signatureRequestedId ,
        string $documentId,
        string $email ,
        string $NomPrenom,
    ) : array{
        $response = $this ->yousignClient->request(
            'POST',
            sprintf('signature_request/%S/signer' , $signatureRequestedId),
            [
                'body'=> <<<JSON
                      {
                      "info": {
                      "first_name": "shayma",
                      "last_name" : "Ouerhani",
                      "email": "yesser.khaloui@etudiant-fst.utm.tn",
                      "locale": "fr"
                      },
                      "fields" : [
                      {
                      "type": "signature",
                      "document_id": "$documentId",
                      "page" : 1,
                      "x": 77,
                      "y": 581
                      }
                      ],
                      "signature_level" : "electronic_signature",
                      "signature_authentification_mode": "no_otp"
                      }
                     JSON,
                'headers'=> [
                    'content-Type'=>'application/json' ,

                ],

            ]);
        $statusCode =$response -> getStatusCode();

        if($statusCode != 201){
            throw new \Exception('Error while adding signer');
        }
        return $response->toArray();

    }

    public function activateSignatureRequest(string $signatureRequestsId) : array
    {
        $response = $this->yousignClient->request(
            'POST',
            sprintf('signature_requests/%s/activate', $signatureRequestsId)

        );
        $statusCode = $response->getStatusCode();
        if($statusCode != 201){
        throw new \Exception('Error while activating signature request') ;

    }
        return $response -> toArray();


    }
}