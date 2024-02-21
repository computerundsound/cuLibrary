<?php

namespace computerundsound\culibrary\requestData;

use DateTime;

class RequestData
{

    private ?string $ip;
    private string $host;
    private string $client;
    private string $referer;
    private string $server;
    private string $site;
    private string $query;
    private DateTime $dateTime;


    public function getHost()
    {
        $this->buildRequestData();
        return $this->host;
    }

    public function getIp(): ?string
    {
        $this->buildRequestData();
        return $this->ip;
    }

    public function getClient(): string
    {
        $this->buildRequestData();
        return $this->client;
    }

    public function getReferer(): string
    {
        $this->buildRequestData();
        return $this->referer;
    }

    public function getServer(): string
    {
        $this->buildRequestData();
        return $this->server;
    }

    public function getSite(): string
    {
        $this->buildRequestData();
        return $this->site;
    }

    public function getQuery(): string
    {
        $this->buildRequestData();
        return $this->query;
    }

    public function getDateTime(): DateTime
    {
        $this->buildRequestData();
        return $this->dateTime;

    }


    private function buildRequestData()
    {

        if ($this->ip === null) {

            $this->ip = $_SERVER['REMOTE_ADDR'] ?? '';
            $this->host = gethostbyaddr($this->ip) ?: '';
            $this->dateTime = new DateTime();

            $userDataKeyValueArray = [
                'HTTP_USER_AGENT' => 'client',
                'HTTP_REFERER' => 'referer',
                'SERVER_NAME' => 'server',
                'PHP_SELF' => 'site',
                'QUERY_STRING' => 'query',
            ];

            foreach ($userDataKeyValueArray as $key => $val) {
                $this->$val = $_SERVER[$key] ?? '';
            }
        }
    }

}