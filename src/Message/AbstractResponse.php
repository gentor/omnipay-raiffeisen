<?php


namespace Omnipay\Raiffeisen\Message;


abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    /**
     * Get the response data.
     *
     * @return mixed
     */
    public function getData()
    {
        unset($this->data['version']);
        unset($this->data['locale']);
        unset($this->data['privateKey']);
        unset($this->data['gatewayCertificate']);
        unset($this->data['testMode']);

        return $this->data;
    }

}