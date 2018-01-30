<?php



use PHPUnit\Framework\TestCase;

final class LoggerTest extends TestCase
{
    public function testCanBeInstantiatedWithValidData()
    {

        $file = dirname(__DIR__).'/test.log';

        $disabledLogger1 = new IdNow\Log\Logger(false, $file, \IdNow\Log\LogLevels::DEBUG);

        $this->assertEquals($disabledLogger1->isEnabled(), false);

        $logger1 = new IdNow\Log\Logger(true, $file, \IdNow\Log\LogLevels::DEBUG);

        $this->assertEquals($logger1->isEnabled(), true);
        $this->assertEquals($logger1->getLevel(), \IdNow\Log\LogLevels::DEBUG);
        $this->assertEquals($logger1->getFile(), $file);

        $logger2 = new IdNow\Log\Logger(true, $file, \IdNow\Log\LogLevels::WARNING);

        $this->assertEquals($logger2->getLevel(), \IdNow\Log\LogLevels::WARNING);

    }

    public function testNotWorkingWithEmptyFile()
    {
        $this->expectException(Exception::class);
        $faultyLogger = new \IdNow\Log\Logger(true, '', \IdNow\Log\LogLevels::DEBUG);
    }

    public function testNotWorkingWithFaultyLevel()
    {
        $this->expectException(Exception::class);
        $faultyLogger = new \IdNow\Log\Logger(true, 'file.log', '12345678iuhgfd');
    }

    public function testWriteToFile()
    {
        $file = dirname(__DIR__).'/test.log';
        $message = 'Test Message';
        if(file_exists($file)) {
            unlink($file);
        }
        $logger1 = new IdNow\Log\Logger(true, $file, \IdNow\Log\LogLevels::DEBUG);
        $logger1->write($message);

        $contents = file_get_contents($file);

        $this->assertEquals($contents, $message);

    }

    public function testLevels()
    {
        $file = dirname(__DIR__).'/test.log';
        $message = 'Test Message';
        if(file_exists($file)) {
            unlink($file);
        }
        $logger1 = new IdNow\Log\Logger(true, $file, \IdNow\Log\LogLevels::WARNING);
        $logger1->info($message);
        $logger1->warning($message);
        $logger1->error($message);

        $contents = explode("\n", file_get_contents($file));

        $count = count($contents) - 1;

        $this->assertEquals(2, $count);


        if(file_exists($file)) {
            unlink($file);
        }
        $logger2 = new IdNow\Log\Logger(true, $file, \IdNow\Log\LogLevels::ERROR);
        $logger2->info($message);
        $logger2->warning($message);
        $logger2->error($message);

        $contents = explode("\n", file_get_contents($file));

        $count = count($contents) - 1;

        $this->assertEquals(1, $count);

    }


}