<?php



use PHPUnit\Framework\TestCase;

final class CreateIdentificationTest extends TestCase
{
    public function testIdentificationWebformLink()
    {
        $companyId = 'test-company';
        $apiKey = 'qwert234';
        $userId = '8765432';
        $client = new \IdNow\Client($companyId, $apiKey);

        $link = $client->getIdentificationWebformLink();

        $this->assertEquals('https://go.idnow.de/'.$companyId.'/userdata', $link);

        $userLink = $client->getIdentificationWebformLink($userId);

        $this->assertEquals('https://go.idnow.de/'.$companyId.'/userdata/'.$userId, $userLink);

    }
}