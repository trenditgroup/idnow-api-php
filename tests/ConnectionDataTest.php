<?php

use PHPUnit\Framework\TestCase;

final class ConnectionDataTest extends TestCase
{
    public function testUrls()
    {
        $companyId = 'test-company';
        $apiKey = 'qwert234';
        $userId = '8765432';
        $testClient = new \IdNow\Client($companyId, $apiKey, \IdNow\Client::DEFAULT_API_VERSION, true);

        $this->assertEquals('go.test.idnow.de', $testClient->getGoDomain());
        $this->assertEquals('gateway.test.idnow.de', $testClient->getGatewayDomain());
        $this->assertEquals('api.test.idnow.de', $testClient->getApiDomain());

        $liveClient = new \IdNow\Client($companyId, $apiKey, \IdNow\Client::DEFAULT_API_VERSION);

        $this->assertEquals('go.idnow.de', $liveClient->getGoDomain());
        $this->assertEquals('gateway.idnow.de', $liveClient->getGatewayDomain());
        $this->assertEquals('api.idnow.de', $liveClient->getApiDomain());

    }

    public function testLogin()
    {
        $companyId = 'ihrebank';
        $apiKey = 'BXCexampleexampleexampleexampleRP';
        $testClient = new \IdNow\Client($companyId, $apiKey, \IdNow\Client::DEFAULT_API_VERSION, true);
        $result = $testClient->login();

        $t = empty($result);
        $this->assertEquals(false, $t);
    }
}