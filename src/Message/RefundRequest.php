<?php


namespace Omnipay\Raiffeisen\Message;


use Omnipay\Raiffeisen\Signature;

class RefundRequest extends FetchTransactionRequest
{
    public function getData()
    {
        $data = parent::getData();

        $this->validate('OrderID', 'TotalAmount', 'ApprovalCode', 'RRN');

        $data = array_merge($data, [
            'TotalAmount' => $this->getParameter('TotalAmount'),
            'RefundAmount' => $this->getParameter('RefundAmount') ?? $this->getParameter('TotalAmount'),
            'OrderID' => $this->getParameter('OrderID'),
            'ApprovalCode' => $this->getParameter('ApprovalCode'),
            'RRN' => $this->getParameter('RRN'),
        ]);

        $data['Signature'] = $this->sign($data);

        return $data;
    }

    protected function sign($data)
    {
        $message = Signature::getMacSourceValue($data, 'refund');

        return Signature::create($message, $this->getPrivateKey());
    }

    /**
     * @param mixed $data
     */
    public function sendData($data)
    {
        $response = $this->httpClient->request(
            'POST',
            $this->getEndpoint() . '/repayment',
            [
                'Content-type' => 'application/x-www-form-urlencoded',
            ],
            http_build_query($data)
        );

        $data = $response->getBody()->getContents();

        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}