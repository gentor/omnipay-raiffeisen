<?php


namespace Omnipay\Raiffeisen\Message;


use Omnipay\Common\Message\NotificationInterface;

class NotifyResponse extends CompletePurchaseResponse implements NotificationInterface
{
    public function getTransactionStatus()
    {
        if ($this->isSuccessful()) {
            return self::STATUS_COMPLETED;
        }

        return self::STATUS_FAILED;
    }

    public function getBody()
    {
        $body = '';
        foreach ($this->data as $key => $val) {
            $body .= $key . '="' . $val . '"' . "\n";
        }

        return $body;
    }
}