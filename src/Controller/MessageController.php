<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Helper\Parser;
use App\Service\FileUploader;

class MessageController extends AbstractController
{
    /**
     * @Route("/messages", name="message", methods={"POST"})
     * 
     * @param $fileName The name of the file to be uploaded
     */
    public function messages(Request $request)
    {
        $file_name = $request->request->get('file_name');
        
        if (!$file_name) {

           return $this->json([
              "status" => "error",
              "message" => "Invalid file name",
           ]);
        }

        $file_link = "uploads/$file_name";

        if (!file_exists($file_link) ) {
            return $this->json([
                "status" => "error",
                "message" => "File not found on the server",
            ]);
        }
        
        $messageParser = (new Parser($file_link))->parseMessage();

        return $this->json([
            "status" => "success",
            "messages" => $messageParser->toArray(),
            "users" => $messageParser->usernameOnly(),
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function users()
    {
        return $this->json([
            "messages" => (new Parser())->parseMessage()->usernamneOnly()
        ]);
    }
}
