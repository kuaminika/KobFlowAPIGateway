<?php
// tests/SimpleTestRunner.php

require_once __DIR__ . '/../K_Utilities/KEnvReader.php';

use K_Utilities\KEnvReader;

class SimpleTestRunner
{
    private $passed = 0;
    private $failed = 0;

    public function runAllTests()
    {
        echo "Running KEnvReader Tests...\n";
        echo "==========================\n";

        $this->testBasicFunctionality();
        $this->testQuotedValues();
        $this->testCommentsAndEmptyLines();
        $this->testDefaultValues();
        $this->testFileNotFound();

        echo "\n==========================\n";
        echo "Results: {$this->passed} passed, {$this->failed} failed\n";
    }

    private function assert($testName, $condition, $message = "")
    {
        if ($condition) {
            echo "✅ PASS: $testName\n";
            $this->passed++;
        } else {
            echo "❌ FAIL: $testName - $message\n";
            $this->failed++;
        }
    }

    private function createTestFile($content)
    {
        $path = __DIR__ . '/test.env';
        file_put_contents($path, $content);
        return $path;
    }

    private function cleanupTestFile($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function testBasicFunctionality()
    {
        $content = "GOOGLE_CLIENT_ID=12345abc\nUSER_SERVICE_PORT=3000";
        $path = $this->createTestFile($content);

        try {
            $reader = new KEnvReader($path);
            $this->assert(
                'Basic Functionality',
                $reader->get('GOOGLE_CLIENT_ID') === '12345abc' && 
                $reader->get('USER_SERVICE_PORT') === '3000',
                'Failed to read basic key-value pairs'
            );
        } finally {
            $this->cleanupTestFile($path);
        }
    }

    public function testQuotedValues()
    {
        $content = 'PASSWORD="my@pass#word"';
        $path = $this->createTestFile($content);

        try {
            $reader = new KEnvReader($path);
            $this->assert(
                'Quoted Values',
                $reader->get('PASSWORD') === 'my@pass#word',
                'Failed to handle quoted values'
            );
        } finally {
            $this->cleanupTestFile($path);
        }
    }

    public function testCommentsAndEmptyLines()
    {
        $content = "# Comment\n\nKEY=value\n# Another comment";
        $path = $this->createTestFile($content);

        try {
            $reader = new KEnvReader($path);
            $this->assert(
                'Comments and Empty Lines',
                $reader->get('KEY') === 'value' && 
                $reader->get('NONEXISTENT') === null,
                'Failed to handle comments and empty lines'
            );
        } finally {
            $this->cleanupTestFile($path);
        }
    }

    public function testDefaultValues()
    {
        $content = "EXISTING=value";
        $path = $this->createTestFile($content);

        try {
            $reader = new KEnvReader($path);
            $this->assert(
                'Default Values',
                $reader->get('NONEXISTENT', 'default') === 'default' &&
                $reader->get('EXISTING', 'default') === 'value',
                'Failed to return correct default values'
            );
        } finally {
            $this->cleanupTestFile($path);
        }
    }

    public function testFileNotFound()
    {
        try {
            $reader = new KEnvReader('/nonexistent/path/.env');
            $this->assert(
                'File Not Found',
                false,
                'Should have thrown exception for non-existent file'
            );
        } catch (Exception $e) {
            $this->assert(
                'File Not Found',
                strpos($e->getMessage(), 'Environment file not found') !== false,
                'Exception message incorrect'
            );
        }
    }
}

// Run the tests
$testRunner = new SimpleTestRunner();
$testRunner->runAllTests();