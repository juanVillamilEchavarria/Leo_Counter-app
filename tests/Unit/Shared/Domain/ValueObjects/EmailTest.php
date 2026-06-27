<?php
namespace Tests\Unit\Shared\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use App\Shared\Domain\ValueObjects\Email;

final class EmailTest extends TestCase
{
    public function test_it_throws_exception_if_isnt_a_valid_email(){
        $string = 'user';
        $this->expectException(InvalidArgumentException::class);
        new Email($string);
    }

}