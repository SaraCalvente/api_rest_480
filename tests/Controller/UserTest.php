<?php


namespace AppBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;


class UserTest extends TestCase
{
    public function testUserCreation()
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'verify' => false, 
        ]);

        $email = 'test' . rand(0, 9999) . '@example.com';
        $data = [
            'email' => $email,
            'nombre' => 'Test User',
            'edad' => 25,
            'password' => 'securepassword123',
        ];

        $response = $client->post('/user/post', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($data),
        ]);

        $this->assertEquals(200, $response->getStatusCode(), 'El código de respuesta debería ser 201');

        $responseData = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('message', $responseData, 'La respuesta debería contener un mensaje');
        $this->assertEquals('Usuario Creado Correctamente', $responseData['message'], 'El mensaje de respuesta debería indicar que el usuario fue creado.');
    }

    public function testGetUsers()
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'verify' => false, 
        ]);

        $response = $client->get('/user/get', [
            'headers' => ['Content-Type' => 'application/json'],
        ]);

        $this->assertEquals(200, $response->getStatusCode(), 'El código de respuesta debería ser 200');

        $responseData = json_decode($response->getBody()->getContents(), true);

        $this->assertIsArray($responseData, 'La respuesta debería ser un array');
        $this->assertNotEmpty($responseData, 'El array de usuarios no debería estar vacío');
    }

    /*public function testDeleteUser()
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'verify' => false, 
        ]);
    
        $loginResponse = $client->post('/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'username' => 'prueba@sara.com', 
                'password' => 'Password'
            ]),
        ]);
    
        $this->assertEquals(200, $loginResponse->getStatusCode(), 'El código de respuesta debería ser 200 en login');
        $token = json_decode($loginResponse->getBody()->getContents(), true)['token'];
    
        $email = 'test' . rand(0, 9999) . '@example.com';
        $userData = [
            'email' => $email,
            'nombre' => 'User To Delete',
            'edad' => 30,
            'password' => 'deletepassword123',
        ];
    
        $createResponse = $client->post('/user/post', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token, 
            ],
            'body' => json_encode($userData),
        ]);
    
        $this->assertEquals(200, $createResponse->getStatusCode(), 'El código de respuesta debería ser 200 al crear el usuario');
    
        $createdUserResponse = json_decode($createResponse->getBody()->getContents(), true);
        $this->assertIsArray($createdUserResponse, 'La respuesta no es un JSON válido');
        $this->assertArrayHasKey('id', $createdUserResponse, 'La respuesta debería contener el ID del usuario creado');
        $userId = $createdUserResponse['id'];
    
        $deleteResponse = $client->delete("/user/delete/{$userId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
    
        $this->assertEquals(200, $deleteResponse->getStatusCode(), 'El código de respuesta debería ser 200 al eliminar el usuario');
    
        $deleteResponseData = json_decode($deleteResponse->getBody()->getContents(), true);
        $this->assertEquals('Usuario eliminado correctamente', $deleteResponseData['message'], 'El mensaje debería indicar que el usuario fue eliminado');
    }*/
}