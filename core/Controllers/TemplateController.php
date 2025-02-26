<?php

namespace Core\Controllers;

use Core\Controllers\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class TemplateController extends Controller
{
    protected string $defaultImage = 'no-photo.png';

    protected string $template_active = "default";

    public function __construct()
    {
        http_response_code(200);
        $this->template_active = config("template.active");
    }

    public function index($file)
    {
        $filePath = template_path($file);
        $defaultPath = template_path($this->defaultImage);

        if (!$filePath || !file_exists($filePath)) {
            page_error(404);
            exit;
        }

        // Verifica se o arquivo está dentro do diretório permitido
        if (strpos(realpath($filePath), realpath(__DIR__ . '/../templates/' . $this->template_active)) !== 0) {
            $filePath = $defaultPath;
        } else {
            page_error(403);
        }

        return $this->serveFile($filePath);
    }

    private function serveFile(string $filePath)
    {
        // Garante que não há saída antes de enviar o arquivo
        if (ob_get_length()) {
            ob_end_clean();
        }

        $response = new BinaryFileResponse($filePath);
        $response->headers->set('Content-Type', mime_content_type($filePath) ?: 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'inline; filename="' . basename($filePath) . '"');
        $response->headers->set('Cache-Control', 'public, max-age=86400');

        $response->send();
        exit; // Finaliza o script após enviar o arquivo
    }
}
