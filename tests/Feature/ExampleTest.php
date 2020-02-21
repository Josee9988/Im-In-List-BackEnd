<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    public function testseeRoutes(){
        
        $login = $this->get('/listas');
        $login->assertStatus(200);
        $login->assertSee('Address');        
        $login->assertSee('Iniciar');
        $login->assertSee('Email');
        $login->assertSee('Password');

        


    }
}
