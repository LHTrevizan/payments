<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * HealthCheckController
 */
class HealthCheckController extends AbstractController
{
    /**
     * This method is supposed to return an error if there's anything wrong with
     * our application's health.
     * For now, we're only returning a simple HTTP 200, meaning that if the request
     * got here, everything should be fine
     *
     * @param LoggerInterface $logger
     *
     * @return JsonResponse
     */
    public function health(LoggerInterface $logger): JsonResponse
    {
        $load   = sys_getloadavg();
        $memory = [
            "usage"      => memory_get_usage(),
            "peak_usage" => memory_get_peak_usage()
        ];

        $response = [
            "message"  => "Everything's fine here :) Thanks for checking!",
            "memory"   => $memory,
            "load_avg" => $load
        ];

        $logger->debug('Healthcheck OK');

        return $this->json($response);
    }
}
