<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

#[AsEventListener(event: 'kernel.response')]
final class SecurityHeadersSubscriber
{
    public function __invoke(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $headers = $response->headers;

        $headers->set('X-Content-Type-Options', 'nosniff');
        $headers->set('X-Frame-Options', 'SAMEORIGIN');
        $headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        $path = $event->getRequest()->getPathInfo();
        if (!$headers->has('X-Robots-Tag') && (str_starts_with($path, '/admin') || $path === '/login')) {
            $headers->set('X-Robots-Tag', 'noindex, nofollow');
        }
    }
}
