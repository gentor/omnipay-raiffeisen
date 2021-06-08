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
     * @param mixed $data
     * @return CompletePurchaseResponse
     * @throws InvalidRequestException
     */
    public function sendData($data)
    {
        $this->validateGatewaySignature($data);

        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}