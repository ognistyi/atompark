<?php

namespace Ognistyi\AtomPark;


use Ognistyi\AtomPark\Dictionary\SendErrorCode;
use Ognistyi\AtomPark\Exception\AtomParkBadResponseException;
use Ognistyi\AtomPark\Exception\AtomParkException;

class AtomParkApi
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $lastRequest;

    /**
     * @var string
     */
    protected $lastResponse;

    /**
     * @return string Last Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @return string Last Request
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    public function __construct($login, $password, $endpoint)
    {
        $this->login = $login;
        $this->password = $password;
        $this->endpoint = $endpoint;
    }

    /**
     * Send SMS
     *
     * @see https://atomic.center/sms/api/
     *
     * @param $phone
     * @param $message
     * @param null|string $messageId
     * @return
     * @throws AtomParkBadResponseException
     * @throws AtomParkException
     */
    public function send($phone, $message, $messageId = null)
    {
        $xmlRequest = /** @lang XML */
            '<?xml version="1.0" encoding="UTF-8"?>
<SMS>
    <operations>
    <operation>SEND</operation>
    </operations>
    <authentification>
    <username>{login}</username>
    <password>{password}</password>
    </authentification>
    <message>
    <sender>SMS</sender>
    <text>{message}</text>
    </message>
    <numbers>
    <number messageID="{messageId}">{phone}</number>
    </numbers>
</SMS>';

        $xmlRequest = strtr($xmlRequest, [
            "{login}" => $this->login,
            "{password}" => $this->password,
            "{message}" => $message,
            "{phone}" => $phone,
            "{messageId}" => $messageId,
        ]);

        $curl = curl_init();
        $curl_options = array(
            CURLOPT_URL => $this->endpoint,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_POST => true,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 12,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => ['XML' => $xmlRequest],
        );

        curl_setopt_array($curl, $curl_options);

        if (false === ($curl_result = curl_exec($curl))) {

            $curl_errno = curl_errno($curl);
            $curl_err_msg = curl_error($curl);

            throw new AtomParkException(sprintf('Cannot send SMS code. Curl error: #[%s] %s', $curl_errno, $curl_err_msg));
        }

        curl_close($curl);

        $this->lastRequest = $xmlRequest;
        $this->lastResponse = $curl_result;

        return $this->check_response($this->lastResponse);
    }

    /**
     * @param string $response
     * @throws AtomParkBadResponseException
     */
    protected function check_response($response)
    {
        $xmlResult = simplexml_load_string($response);

        $responseStatus = (int) $xmlResult->status;

        $errorCode = SendErrorCode::make($responseStatus);

        if ($errorCode->getErrorCode() < 0) {

            throw new AtomParkBadResponseException($errorCode->getErrorText(), $errorCode->getErrorCode());
        }

        // when code > 0 this is count SMS was sent
        return $errorCode->getErrorCode();
    }
}