<?php

namespace Brarcos\LogErrorFrontend\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InjectJs
{
    public function handle($request, Closure $next)
    {
        if (!config('logerrorfrontend.enabled') or !config('logerrorfrontend.inject_js')) {
            return $next($request);
        }

        $response = $next($request);

        // Modify the response to add js
        $this->modifyResponse($request, $response);

        return $response;
    }

    private function modifyResponse(Request $request, Response $response)
    {
        if ($response->headers->has('Content-Type') && strpos($response->headers->get('Content-Type'), 'html') !== false) {
            $content = $response->getContent();

            $pos = strripos($content, '</body>');
            if (false !== $pos) {
                $content = substr($content, 0, $pos) . $this->getJs() . substr($content, $pos);

                // Update the new content and reset the content length
                $response->setContent($content);
                $response->headers->remove('Content-Length');
            }
        }
    }

    private function getJs()
    {
        $script = \Cache::get('logerrorfrontend_js', function () {
            return file_get_contents(__DIR__ . '/../Resources/log-error-fronted.js');
        });

        return '<script type="text/javascript">' . $script . '</script>';
    }
}
