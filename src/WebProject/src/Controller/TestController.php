<?php
// src/Controller/TestController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function index()
    {
        return new Response('
            <html>
                <body>
                    <h1>Hello Symfony World</h1>
                        <h2> Ceci est la page de test</h2>
                </body>
            </html>
        ');
    }
}
