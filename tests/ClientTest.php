<?php


use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testSetClientParams()
    {
        $companyId = 'test_company';
        $apiKey = 'qwertyumnbvcx';
        $client = new \IdNow\Client($companyId, $apiKey, \IdNow\Client::DEFAULT_API_VERSION, true);
        $this->assertEquals($companyId, $client->getCompanyId());
        $this->assertEquals($apiKey, $client->getApiKey());
        $this->assertEquals('v1', $client->getApiVersion());
    }
}