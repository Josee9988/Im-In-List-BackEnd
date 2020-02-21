<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{

    /**
     * testRoutesTest
     * Summary: prueba defecto
     *
     * @return void
     */
    public function testRoutesTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

    }

    /**
     * testListasTest
     * Summary: prueba de listas get
     *
     * @return void
     */
    public function testListasTest()
    {
        $response = $this->get('/api/listas/Borja_UrlBorjaList/1234');
        $response->assertStatus(200);
        $response->assertJson([
            "id" => 1,
            "user_id" => 1,
            "url" => "Borja_UrlBorjaList",
        ]);

        $response = $this->get('/api/listas/Borja_UrlBorjaList');
        $response->assertJson([
            "message" => "Error, indique la contraseña de la lista",
        ]);

    }

    /**
     * testCaptchaTest
     * Summary: prueba fallo de captcha
     *
     * @return void
     */
    public function testCaptchaTest()
    {
        $response = $this->json('POST', 'api/register', ['name' => 'UnitUser',
            'email' => 'unit@gmail.com',
            'password' => '1234']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Error, Actividad sospechosa',
            ]);
    }

    /**
     * testLoginTest
     * Summary: prueba login
     *
     * @return void
     */
    public function testLoginTest()
    {
        $response = $this->json('POST', 'api/login',
            ['email' => 'jose@gmail.com',
                'password' => '1234']);
        $response->assertStatus(200);

        $response = $this->json('POST', 'api/login',
            ['email' => 'Fallo@gmail.com',
                'password' => '1234']);
        $response
            ->assertStatus(401)
            ->assertJson(['message' => '- Error de login, password o email incorrectos']);
    }

    /**
     * testCreateListTest
     * Summary: prueba crear fallo
     *
     * @return void
     */
    public function testCreateListTest()
    {
        $response = $this->json('POST', 'api/listas',
            ['titulo' => 'Lista unitaria',
                'descripcion' => 'Lista de prueba de test']);
        $response
            ->assertStatus(200)
            ->assertJson(["message" => "Error, Actividad sospechosa"]);
    }
}
