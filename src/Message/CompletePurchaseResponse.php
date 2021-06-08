<?php


namespace Omnipay\Raiffeisen\Message;


class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->getCode() === '000';
    }

    public function getCode()
    {
        return $this->data['TranCode'] ?? null;
    }

    public function getTransactionId()
    {
        return $this->data['OrderID'] ?? null;
    }

    public function getTransactionReference()
    {
        return $this->data['ApprovalCode'] ?? null;
    }

    public function getMessage()
    {
        return $this->data['ERROR'] ?? null;
    }

}