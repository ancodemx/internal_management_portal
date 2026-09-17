<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Eris\TestTrait;
use Eris\Generator;

use modules\Login\UseCases\SetSessionUseCase;

use app\Exceptions\ResponseException;

require_once __DIR__ . '/../Modules/Login/UseCases/SetSessionUseCase.php';

class FuzzSetSessionUseCaseTest extends TestCase 
{
    use TestTrait;

    protected SetSessionUseCase $useCase;

    // Configuración inicial del caso de uso
    // Esta función se ejecuta antes de cada test(prueba)
    protected function setUp(): void 
    {
        parent::setUp();

        $this->useCase = new SetSessionUseCase();
    }

    public function testSetInputsMaliciososOInvalidos() {

        $this->forAll(
            Generator\oneOf(
                Generator\elements([
                    1,
                    null,
                    "",
                    "string",
                    "<script>alert(1)</script>",
                    str_repeat("x", 100),
                    0,
                    -1,
                    999999,
                ]),
                Generator\int(),
                Generator\string()
            ),
            Generator\oneOf(
                Generator\elements([
                    1,
                    null,
                    "",
                    "string",
                    "<script>alert(1)</script>",
                    str_repeat("y", 100),
                    0,
                    -1,
                    999999,
                ]),
                Generator\int(),
                Generator\string()
            )
        )->then(function ($id, $profile_id) {

            $data = [
                'id' => $id,
                'profile_id' => $profile_id
            ];

            $this->expectException(ResponseException::class);

            // La respuesta de $this->useCase->execute($data) debe ser array
            $response = $this->useCase->execute($data);

            $this->assertArrayHasKey('is_error', $response);
            $this->assertIsArray($response);

            if ($response['is_error']) {
                $this->assertMatchesRegularExpression('/error|incorrecto|válido|no puede/i', $response['message'] ?? '');
            } else {
                $this->assertArrayHasKey('response', $response);
                $this->assertArrayHasKey('session_on', $response['response']);
                $this->assertTrue($response['response']['session_on']);
            }


        });
    }

    public function testValidarQueLosDatosNoVenganVaciosOSeanNulos() 
    {
        $this->expectException(ResponseException::class);

        // Datos de prueba vacíos
        $data = [
            'id' => null,
            'profile_id' => null
        ];

        $this->useCase->execute($data);

    }

    public function testValidarQueLaFuncionCrearMenuRetorneUnArray() 
    {
        $data = [
            'profile_id' => 1
        ];

        $response = $this->useCase->crear_menu($data['profile_id']);

        // Verificamos que la respuesta sea un array
        $this->assertIsArray($response);

        // Verificamos que el array no esté vacío
        $this->assertNotEmpty($response);
    }

    public function testValidarQueLaFuncionCrearMenuObtengaItemsHijos() 
    {
        $data = [
            'profile_id' => 1
        ];

        $response = $this->useCase->crear_menu($data['profile_id']);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);

    }

    public function testLanzaExcepcionSiLaFuncionCrearMenuNoObtieneItemsHijos() 
    {
        $data = [
            'profile_id' => 999 // Asegúrate que este ID no tenga hijos en tu base de datos
        ];

        $this->expectException(ResponseException::class);

        $this->useCase->crear_menu($data['profile_id']);

        // Si la excepción NO se lanza, este assert falla el test
        $this->fail('No se lanzó ResponseException cuando no hay items hijos.');

    }

    /* public function testEjemploDeFuncionIncompleta() 
    {
        $this->markTestIncomplete(
            'Esta función aún no está implementada.'
        );
    } */
}