<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Eris\TestTrait;
use Eris\Generator;

use modules\Login\UseCases\AuthenticateUserUseCase;
// use app\Utils\PasswordUtils;
// use app\Exceptions\ResponseException;

// Mock manual de UserService y otros si quieres más control

require_once __DIR__ . '/../Modules/Login/UseCases/AuthenticateUserUseCase.php';
// require_once __DIR__ . '/../app/Utils/PasswordUtils.php';

class FuzzLoginUseCaseTest extends TestCase {
    use TestTrait;

    protected AuthenticateUserUseCase $useCase;

    protected function setUp(): void {
        $this->useCase = new AuthenticateUserUseCase();
    }

    public function testLoginInputsMaliciososOInvalidos() {

        // Generamos datos de prueba con Eris
        $this->forAll(
            Generator\elements([
                "admin",
                "   ",
                "' OR 1=1; --",
                "<script>alert(1)</script>",
                str_repeat("x", 70), // demasiado largo
                "",
                "usuario@example.com"
            ]),
            Generator\elements([
                "123456",
                "   ",
                "' OR ''='",
                "<script>hack()</script>",
                str_repeat("a", 120),
                "",
                "password123"
            ])
        )->then(function ($username, $password) {

            $loginData = [
                'username' => $username,
                'password' => $password
            ];

            $this->expectException(\app\Exceptions\ResponseException::class);
            // $this->expectException(\TypeError::class);

            $response = $this->useCase->execute($loginData);

            // Verificamos que haya control de errores adecuado
            $this->assertArrayHasKey('is_error', $response);

            $this->assertTrue(isset($response['is_error'])); // no truena

            if ($response['is_error']) {
                $this->assertMatchesRegularExpression('/error|incorrecto|válido|no puede/i', $response['message'] ?? '');
            } else {
                // si pasa, debería devolver un usuario válido
                $this->assertArrayHasKey('response', $response);
                $this->assertArrayHasKey('id', $response['response']);
                $this->assertNotEmpty($response['response']['id']);
            }
        });
    }
}
