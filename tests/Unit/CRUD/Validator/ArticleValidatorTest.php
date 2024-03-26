<?php

namespace Unit\CRUD\Validator;

use App\Domain\CRUD\Entity\PostedData;
use App\Domain\CRUD\Validator\ArticleValidator;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;

class ArticleValidatorTest extends TestCase
{
    private ArticleValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new ArticleValidator();
    }

    public function testArticleValidatorSuccess(): void
    {
        $postedData = new PostedData([
            'title' => 'Custom Title Not blank with 25 char min',
            'description' => 'Custom description',
            'content' => 'Custom content',
        ]);

        $this->assertTrue($this->validator->validate($postedData));
    }

    /**
     * @dataProvider dataProviderArticleValidatorFailed
     */
    public function testArticleValidatorFailed(array $data, string $exception, string $message): void
    {
        $this->expectException($exception);
        $this->expectExceptionMessage($message);

        $this->validator->validate(new PostedData($data));
    }

    public static function dataProviderArticleValidatorFailed(): \Generator
    {
        yield 'test_missing_title' => [
            'data' => [],
            'exception' => AssertionFailedException::class,
            'message' => 'Value "<NULL>" is blank, but was expected to contain a value.',
        ];

        yield 'test_empty_title' => [
            'data' => ['title' => ''],
            'exception' => AssertionFailedException::class,
            'message' => 'Value "" is blank, but was expected to contain a value.',
        ];

        yield 'test_short_title' => [
            'data' => ['title' => 'short'],
            'exception' => AssertionFailedException::class,
            'message' => 'Value "short" is too short, it should have at least 25 characters, but only has 5 characters.',
        ];

        yield 'test_too_large_title' => [
            'data' => ['title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condimentum, magna ligula porta tellus, ac hendrerit lorem elit vitae urna. Cras eget tempus lectus. Nam sed dapibus leo. Aenean iaculis purus dui, at lobortis nunc.'],
            'exception' => AssertionFailedException::class,
            'message' => 'Value "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condim..." is too long, it should have no more than 255 characters, but has 256 characters.',
        ];
    }
}
