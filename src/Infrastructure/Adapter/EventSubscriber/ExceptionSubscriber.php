<?php

namespace App\Infrastructure\Adapter\EventSubscriber;

use App\Domain\Exception\ApiExceptionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;


readonly class ExceptionSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private LoggerInterface $logger,
    ) {}


    public function onExceptionEvent(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        //log
        $this->logger->error($exception->getMessage(), ['exception' => $exception]);

        if ($exception instanceof ApiExceptionInterface) {
           $dataException = [
               'code' => $exception->getCustomStatusCode() ?? 'Unknown statut code',
               'message' => $exception->getCustomMessage(),
           ];
           $event->setResponse(new JsonResponse($dataException));

        } elseif ($exception instanceof HttpExceptionInterface){
            $dataException = [
                'code' => $exception->getStatusCode() ?? 'Unknown statut code',
                'message' => Response::$statusTexts[$exception->getStatusCode()],
            ];
            $event->setResponse(new JsonResponse($dataException));
        } else {
            $event->setResponse(new JsonResponse([
                'message' => 'Erreur interne. Veuillez réessayer plus tard.'
            ], 500));
        }

    }


    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onExceptionEvent',
        ];
    }
}
