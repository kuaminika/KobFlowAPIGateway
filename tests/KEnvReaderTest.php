<?php
// tests/KEnvReaderTest.php

require_once __DIR__ . '/../K_Utilities/KEnvReader.php';

use K_Utilities\KEnvReader;
use PHPUnit\Framework\TestCase;

class KEnvReaderTest extends TestCase
{
    private $testEnvPath;
    private $tempDir;

    protected function setUp(): void
    {
        $this->tempDir = __DIR__ . '/temp';
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0777, true);
        }
        $this->testEnvPath = $this->tempDir . '/.env.test';
    }

    protected function tearDown(): void
    {
        // Clean up test files
        if (file_exists($this->testEnvPath)) {
            unlink($this->testEnvPath);
        }
        if (is_dir($this->tempDir)) {
            rmdir($this->tempDir);
        }
    }

    private function createTestEnvFile($content)
    {
        file_put_contents($this->testEnvPath, $content);
    }

    public function testCanBeInstantiatedWithCustomPath()
    {
        $this->createTestEnvFile("TEST_KEY=test_value");
        
        $reader = new KEnvReader($this->testEnvPath);
        $this->assertInstanceOf(KEnvReader::class, $reader);
    }

    public function testThrowsExceptionWhenFileNotFound()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Environment file not found");
        
        new KEnvReader('/nonexistent/path/.env');
    }

    public function testReadsBasicKeyValuePairs()
    {
        $this->createTestEnvFile("
GOOGLE_CLIENT_ID=12345abc
USER_SERVICE_PORT=3000
DEBUG=true
");

        $reader = new KEnvReader($this->testEnvPath);
        
        $this->assertEquals('12345abc', $reader->get('GOOGLE_CLIENT_ID'));
        $this->assertEquals('3000', $reader->get('USER_SERVICE_PORT'));
        $this->assertEquals('true', $reader->get('DEBUG'));
    }

    public function testHandlesQuotedValues()
    {
        $this->createTestEnvFile('
DB_PASSWORD="my@secure#password"
API_KEY=\'abc123\'
SIMPLE_VALUE=no_quotes
');

        $reader = new KEnvReader($this->testEnvPath);
        
        $this->assertEquals('my@secure#password', $reader->get('DB_PASSWORD'));
        $this->assertEquals('abc123', $reader->get('API_KEY'));
        $this->assertEquals('no_quotes', $reader->get('SIMPLE_VALUE'));
    }

    public function testSkipsCommentsAndEmptyLines()
    {
        $this->createTestEnvFile('
# This is a comment
GOOGLE_CLIENT_ID=12345abc

# Another comment
USER_SERVICE_PORT=3000

DB_HOST=localhost
');

        $reader = new KEnvReader($this->testEnvPath);
        
        $this->assertEquals('12345abc', $reader->get('GOOGLE_CLIENT_ID'));
        $this->assertEquals('3000', $reader->get('USER_SERVICE_PORT'));
        $this->assertEquals('localhost', $reader->get('DB_HOST'));
        $this->assertNull($reader->get('NONEXISTENT_KEY'));
    }

    public function testSkipsInvalidLinesWithoutEquals()
    {
        $this->createTestEnvFile('
VALID_KEY=valid_value
INVALID_LINE_WITHOUT_EQUALS
ANOTHER_VALID=another_value
');

        $reader = new KEnvReader($this->testEnvPath);
        
        $this->assertEquals('valid_value', $reader->get('VALID_KEY'));
        $this->assertEquals('another_value', $reader->get('ANOTHER_VALID'));
        $this->assertNull($reader->get('INVALID_LINE_WITHOUT_EQUALS'));
    }

    public function testReturnsDefaultForMissingKeys()
    {
        $this->createTestEnvFile("EXISTING_KEY=existing_value");

        $reader = new KEnvReader($this->testEnvPath);
        
        $this->assertEquals('existing_value', $reader->get('EXISTING_KEY'));
        $this->assertNull($reader->get('NONEXISTENT_KEY'));
        $this->assertEquals('default_value', $reader->get('NONEXISTENT_KEY', 'default_value'));
        $this->assertEquals(42, $reader->get('NONEXISTENT_KEY', 42));
    }

    public function testGetMethodWorksAfterConstruction()
    {
        $this->createTestEnvFile("TEST_KEY=test_value");

        $reader = new KEnvReader($this->testEnvPath);
        
        // Should work immediately after construction
        $this->assertEquals('test_value', $reader->get('TEST_KEY'));
    }

    public function testHandlesSpecialCharactersInValues()
    {
        $this->createTestEnvFile('
PASSWORD=my@secure#pass$word!
URL=https://example.com:3000/api/v1
JSON_CONFIG={"host":"localhost","port":3306}
');

        $reader = new KEnvReader($this->testEnvPath);
        
        $this->assertEquals('my@secure#pass$word!', $reader->get('PASSWORD'));
        $this->assertEquals('https://example.com:3000/api/v1', $reader->get('URL'));
        $this->assertEquals('{"host":"localhost","port":3306}', $reader->get('JSON_CONFIG'));
    }
}