<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Eris\TestTrait;
use Eris\Generator;

use app\Core\Transaction;
use modules\User\UseCases\GetUserUseCase;
use modules\User\UseCases\CreateUserUseCase;
use modules\User\UseCases\UpdateUserUseCase;

use app\Exceptions\ResponseException;

require_once __DIR__ . '/../Modules/User/UseCases/CreateUserUseCase.php';

class FuzzUserUseCaseTest extends TestCase 
{
    use TestTrait;

    protected Transaction $transaction;
    protected GetUserUseCase $getUserUseCase;
    protected CreateUserUseCase $createUserUseCase;
    protected UpdateUserUseCase $updateUserUseCase;

    // public function __construct() {
    //     $this->transaction = new Transaction();
    // }

    // Configuración inicial del caso de uso
    // Esta función se ejecuta antes de cada test(prueba)
    protected function setUp(): void 
    {
        parent::setUp();

        $this->transaction = new Transaction();
        $this->getUserUseCase = new GetUserUseCase();
        $this->createUserUseCase = new CreateUserUseCase();
        $this->updateUserUseCase = new UpdateUserUseCase();
    }

    // Metodo privado para obtener datos de usuario
    private function getUserData(array $overrides = []): array
    {
        $faker = \Faker\Factory::create();
        $data = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'middle_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'profile_id' => $faker->numberBetween(1, 5),
            'username' => $faker->unique()->userName,
            'password' => 'TestPass123!',
            'confirm_password' => 'TestPass123!',
            'json_categories' => ["1","2"],
            'user_id' => null,
            'token' => $faker->sha256,
            'user_action_id' => 1
        ];
        return array_merge($data, $overrides);
    }
    

    public function testValidarQueLosDatosSeanCorrectosAlCrearUsuario() 
    {
        $data = $this->getUserData();

        $this->transaction->startTransaction();
        $result = $this->createUserUseCase->execute($data, false, false);
        $this->transaction->rollback();
        
        $this->assertTrue(
            !$result['is_error'] && $result['http_status_code'] === 201
        );
    }


    public function testNoPermiteEmailDuplicado(): void
    {
        $data = $this->getUserData(['email' => 'ancodemx@gmail.com']);

        try {
            $this->createUserUseCase->execute($data, true, false);
            $this->fail('No se lanzó ResponseException');
        } catch (\app\Exceptions\ResponseException $e) {
            $this->assertEquals(409, $e->getHttpStatus());
            $this->assertMatchesRegularExpression('/email.*en uso/i', $e->getMessage());
        }
    }


    public function testNoPermiteUsernameDuplicado(): void
    {
        $data = $this->getUserData(['username' => 'admin']);

        try {
            $this->createUserUseCase->execute($data, true, false);
            $this->fail('No se lanzó ResponseException');
        } catch (\app\Exceptions\ResponseException $e) {
            $this->assertEquals(409, $e->getHttpStatus());
            $this->assertMatchesRegularExpression('/usuario.*en uso/i', $e->getMessage());
        }
    }


    public function testNoPermiteContrasenasQueNoCoincidan(): void
    {
        $data = $this->getUserData(['confirm_password' => 'Alfonso1983!']);


        try {
            $this->createUserUseCase->execute($data, true, false);
            $this->fail('No se lanzó ResponseException');
        } catch (\app\Exceptions\ResponseException $e) {
            $this->assertEquals(409, $e->getHttpStatus());
            $this->assertMatchesRegularExpression('/contraseñ(a|as).*coinciden/i', $e->getMessage());
        }
    }


    public function testMinimo8Caracteres(): void
    {
        $data = $this->getUserData(['password' => 'alfonso', 'confirm_password' => 'alfonso']);

        try {
            $this->createUserUseCase->execute($data, true, false);
            $this->fail('No se lanzó ResponseException');
        } catch (\app\Exceptions\ResponseException $e) {
            $this->assertEquals(409, $e->getHttpStatus());
            $this->assertMatchesRegularExpression('/contraseñ(a|as).*8 caracteres/i', $e->getMessage());
        }
    }


    public function testAlMenosUnaMayusculaUnaMinusculaUnNumeroYUnCaracterEspecial(): void
    {
        $data = $this->getUserData(['password' => 'alfonsooo', 'confirm_password' => 'alfonsooo']);

        try {
            $this->createUserUseCase->execute($data, true, false);
            $this->fail('No se lanzó ResponseException');
        } catch (\app\Exceptions\ResponseException $e) {
            $this->assertEquals(409, $e->getHttpStatus());
            $this->assertMatchesRegularExpression('/contraseñ(a|as).*mayúscula.*minúscula.*número.*carácter especial/i', $e->getMessage());
        }
    }


    public function testValidarQueLosDatosSeanCorrectosAlActualizarUsuario() 
    {
        $data = $this->getUserData([
            'id' => 1, 
            'first_name' => 'Gabriela', 
            'last_name' => 'Desales', 
            'middle_name' => 'Nuñez', 
            'email' => 'gabriela@hotmail.com', 
            'profile_id' => 2, 
            'username' => 'gabriela', 
            'password' => 'Alfonso1983!', 
            'confirm_password' => 'Alfonso1983!', 
            'json_categories' => ["1","2"], 
            'user_id' => null, 
            'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxLCJwcm9maWxlX2lkIjoxLCJpYXQiOjE3NTY1NjQxMTYsImV4cCI6MTc1NjU2NDE0Nn0.rbfckrtfaRjZpSZiJBbd9Sc_AN-1Wlbg52URy9AoNpI', 
            'user_action_id' => 1
        ]);

        $this->transaction->startTransaction();
        $result = $this->createUserUseCase->execute($data, false, false);
        $this->transaction->rollback();
        
        $this->assertTrue(
            !$result['is_error'] && $result['http_status_code'] === 201
        );
    }


    public function testObtenerUsuarioPorId(): void
    {
        $result = $this->getUserUseCase->execute(2);

        $this->assertTrue(
            !$result['is_error'] && $result['http_status_code'] === 200
        );
    }

}