<?php


namespace Omnipay\Raiffeisen\Message;


use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Raiffeisen\Signature;

class PayByTokenRequest extends AbstractRequest
{
    public function getData()
    {
        $data = parent::getData();

        $this->validate('OrderID', 'TotalAmount', 'UPCToken');

        $data = array_merge($data, [
            'OrderID' => $this->getParameter('OrderID'),
            'TotalAmount' => $this->getParameter('TotalAmount'),
            'UPCToken' => $this->getParameter('UPCToken'),
            'PurchaseDesc' => $this->getParameter('PurchaseDesc'),
        ]);

        if ($this->getParameter('Recurrent')) {
            $data['Recurrent'] = $this->getParameter('Recurrent');
        }

        if ($this->getParameter('CVNum')) {
            $data['CVNum'] = $this->getParameter('CVNum');
        }

        return $data;
    }

    public function getSignedData()
    {
        return Signature::createJWS($this->getData(), $this->getPrivateKey());
    }

    /**
     * Send the request
     *
     * @return PayByTokenResponse
     */
    public function send()
    {
        return parent::send();
    }

    /**
     * @param mixed $data
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        $response = $this->httpClient->request(
            'POST',
            $this->getEndpoint() . '/payByToken',
            [
                'Content-type' => 'application/json',
            ],
            json_encode($this->getSignedData())
        );

        $data = json_decode($response->getBody()->getContents(), true);

//        $valid = Signature::verifyJWS($data, $this->getParameter('gatewayCertificate'));
//        if ($valid < 1) {
//            throw new InvalidRequestException("Invalid gateway signature: " . $data['signature']);
//        }

        return $this->response = new PayByTokenResponse($this, $data);
    }
}