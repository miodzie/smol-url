<?php

namespace Tests\Unit\TinyUrls;

use App\TinyUrls\UrlValidator;
use PHPUnit\Framework\TestCase;

class UrlValidatorTest extends TestCase
{
    /**
     * @dataProvider validUrlProvider
     */
    public function test_lax_regex_valid_urls(string $url)
    {
        // Arrange
        // Act
        $result = UrlValidator::validate($url);

        // Assert
        $this->assertTrue($result);
    }

    public function validUrlProvider(): array
    {
        return [
            ['https://example.com/'],
            ['http://example.com/potato?salad=delcious[]=asdf^delicious[]=yum#asdf-twoA'],
            ['http://example'],
            ['https://ddg.gg'],
        ];
    }

    /**
     * @dataProvider invalidUrlProvider
     */
    public function test_invalid_urls(string $url)
    {
        // Arrange
        // Act
        $result = UrlValidator::validate($url);

        // Assert
        $this->assertFalse($result);
    }

    public function invalidUrlProvider(): array
    {
        return [
            [''],
            ['bl"ah'],
            ['http://e xample.com'],
            ['http:://example.com'],
            ['http:\/example.com'],
            ['ftp://example.com'],
            ['://example.com'],
        ];
    }
}
