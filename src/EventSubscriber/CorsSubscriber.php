<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class CorsSubscriber implements EventSubscriberInterface
{
    private const ALLOWED_ORIGINS = [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
    ];

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 9999],
            KernelEvents::RESPONSE => ['onKernelResponse', -9999],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ('OPTIONS' === $request->getMethod() && $this->isAllowedOrigin($request->headers->get('Origin'))) {
            $event->setResponse(new Response(null, Response::HTTP_NO_CONTENT));
        }
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $origin = $event->getRequest()->headers->get('Origin');

        if (!$this->isAllowedOrigin($origin)) {
            return;
        }

        $headers = $event->getResponse()->headers;
        $headers->set('Access-Control-Allow-Origin', $origin);
        $headers->set('Access-Control-Allow-Credentials', 'true');
        $headers->set('Access-Control-Allow-Headers', 'Authorization, Content-Type, Accept, X-XSRF-TOKEN');
        $headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
        $headers->set('Access-Control-Max-Age', '3600');
        $headers->set('Vary', 'Origin');
    }

    private function isAllowedOrigin(?string $origin): bool
    {
        return null !== $origin && in_array($origin, self::ALLOWED_ORIGINS, true);
    }
}
