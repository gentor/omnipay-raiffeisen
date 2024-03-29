<?php


namespace Omnipay\Raiffeisen\Message;


use Omnipay\Common\Exception\InvalidRequestException;

class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        parse_str($this->httpRequest->getContent(), $data);
//        $data = $this->getParameters();

        return $data;
    }

    /**
     * Send the request
     *
     * @return CompletePurchaseResponse
     */
    public function send()
    {
        return parent::send();
    }

    /**
     * @param mixed $data
     * @return CompletePurchaseResponse
     * @throws InvalidRequestException
     */
    public function sendData($data)
    {
        $data['Delay'] = 0;
        
        try {
            $this->validateGatewaySignature($data);
        } catch (InvalidRequestException $e) {
            $data['Delay'] = 1;
            $this->validateGatewaySignature($data);
        }

        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}