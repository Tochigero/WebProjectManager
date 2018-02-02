<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function index()
    {
        return new Response('
            <html>
                <body>
                    <h1>Yolo</h1>
                </body>
            </html>
        ');
    }

    public function get($id) {
        return new Response($id);
    }
}
