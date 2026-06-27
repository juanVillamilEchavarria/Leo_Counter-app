<?php
namespace Tests\Unit\Shared\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use App\Shared\Domain\ValueObjects\Password;
use InvalidArgumentException;

final class PasswordTest extends TestCase
{
    public function test_it_throws_exception_if_password_is_under_eight_characters(){
        $string = '12';
        $this->expectException(InvalidArgumentException::class);
        Password::create($string);
    }
    public function test_it_hash_correctly(){
        $plainPassword = '12345678';
        $password = Password::create($plainPassword);
        $this->assertNotEquals($plainPassword, $password);
    }

}