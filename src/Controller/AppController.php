<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;

class AppController extends AbstractController
{
    private $targetDirectory;
    private $request;
    private $fileUploader;

    public function __construct(FileUploader $fileUploader, $targetDirectory="uploads") {
       $this->fileUploader = $fileUploader;
       $this->targetDirectory = $targetDirectory;
    }

    /**
     * @Route("/", name="app")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/files", name="files")
     */
    public function files()
    {
        return $this->json([
            "files" => [
                [
                    "file_name" => "4a2b40a8eae9b67fab7e9977f8513dd0.txt",
                    "name" => "Teasing you :)"
                ],
                [
                    "file_name" => "398ad149f9bcc79b58a261169ccd9200.txt",
                    "name" => "Nah broll;"
                ],
            ]
        ]);
    }

    /**
     * @Route("/upload_file", name="upload_file", methods={"POST"})
     * 
     * @param Request
     * 
     * @return String The name of the file uploaded.
     */
    public function upload_file(Request $request)
    {
        $file = $request->files->get('file');
        
        try {
            $fileName = $this->fileUploader->upload($file);

            $message = [
                "status" => "success",
                "data" => $fileName
            ];
        } catch( \Exception $e) {
            $message = [
                "status" => "error",
                "message" => "File failed to upload with the following error: $e"
            ];
        }

        return $this->json($message);
    }
}
