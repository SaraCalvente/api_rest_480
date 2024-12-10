<?php

namespace AppBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class LibroTest extends TestCase
{
    public function testLibroCreation()
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'verify' => false, 
        ]);

        $data = [
            'titulo' => 'Test Book ' . rand(0, 9999),
            'autor' => 'Test Author',
            'genero' => 'Fiction',
            'año_publicacion' => 2020,
        ];

        $response = $client->post('/libro/post', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($data),
        ]);

        $this->assertEquals(201, $response->getStatusCode(), 'El código de respuesta debería ser 201');

        $responseData = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals('Libro Creado Correctamente', $responseData, 'El mensaje de respuesta debería indicar que el libro fue creado.');
    }

    public function testGetLibros()
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'verify' => false, 
        ]);

        $response = $client->get('/libro/get', [
            'headers' => ['Content-Type' => 'application/json'],
        ]);

        $this->assertEquals(200, $response->getStatusCode(), 'El código de respuesta debería ser 200');

        $responseData = json_decode($response->getBody()->getContents(), true);
        $this->assertIsArray($responseData, 'La respuesta debería ser un array');
        $this->assertNotEmpty($responseData, 'El array de libros no debería estar vacío');
    }

    /*public function testDeleteLibro()
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

        $data = [
            'titulo' => 'Book To Delete',
            'autor' => 'Author to Delete',
            'genero' => 'Fiction',
            'año_publicacion' => 2021,
        ];

        $createResponse = $client->post('/libro/post', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token, 
            ],
            'body' => json_encode($data),
        ]);

        $this->assertEquals(201, $createResponse->getStatusCode(), 'El código de respuesta debería ser 201 al crear el libro');

        $createdBookResponse = json_decode($createResponse->getBody()->getContents(), true);
        $this->assertIsArray($createdBookResponse, 'La respuesta no es un JSON válido');
        $this->assertArrayHasKey('id', $createdBookResponse, 'La respuesta debería contener el ID del libro creado');
        $bookId = $createdBookResponse['id'];

        $deleteResponse = $client->delete("/libro/delete/{$bookId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        $this->assertEquals(200, $deleteResponse->getStatusCode(), 'El código de respuesta debería ser 200 al eliminar el libro');

        $deleteResponseData = json_decode($deleteResponse->getBody()->getContents(), true);
        $this->assertEquals('Libro borrado correctamente', $deleteResponseData['message'], 'El mensaje debería indicar que el libro fue eliminado');
    }

    public function testUpdateLibro()
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'verify' => false, 
        ]);

        // Iniciar sesión y obtener un token JWT válido
        $loginResponse = $client->post('/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'username' => 'prueba@sara.com', 
                'password' => 'Password'
            ]),
        ]);

        $this->assertEquals(200, $loginResponse->getStatusCode(), 'El código de respuesta debería ser 200 en login');
        $token = json_decode($loginResponse->getBody()->getContents(), true)['token'];

        $data = [
            'titulo' => 'Book To Update',
            'autor' => 'Author to Update',
            'genero' => 'Fiction',
            'año_publicacion' => 2021,
        ];

        $createResponse = $client->post('/libro/post', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token, 
            ],
            'body' => json_encode($data),
        ]);

        $this->assertEquals(201, $createResponse->getStatusCode(), 'El código de respuesta debería ser 201 al crear el libro');

        $createdBookResponse = json_decode($createResponse->getBody()->getContents(), true);
        $bookId = $createdBookResponse['id'];

        $updatedData = [
            'titulo' => 'Updated Book Title',
            'autor' => 'Updated Author',
            'genero' => 'Drama',
            'año_publicacion' => 2022,
        ];

        $updateResponse = $client->put("/libro/put/{$bookId}", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'body' => json_encode($updatedData),
        ]);

        $this->assertEquals(200, $updateResponse->getStatusCode(), 'El código de respuesta debería ser 200 al actualizar el libro');

        $updateResponseData = json_decode($updateResponse->getBody()->getContents(), true);
        $this->assertEquals('Libro actualizado correctamente', $updateResponseData['message'], 'El mensaje debería indicar que el libro fue actualizado');
    }*/
}