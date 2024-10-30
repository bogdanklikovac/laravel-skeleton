<?php

namespace App\Http\Middleware;

use App\Constants\ApiStatus;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiVersionDeprecate
{
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        if (! $response instanceof JsonResponse) {
            return $response;
        }

        $headers = [];
        $version = $this->extractVersionFromRoute($request->path());

        if (in_array($version, config('setup.api.unsupported_versions'), true)) {
            $headers['Api-Status'] = ApiStatus::UNSUPPORTED;
        } elseif (in_array($version, config('setup.api.sunset_versions'), true)) {
            $headers['Api-Status'] = ApiStatus::SUNSET;
        } else {
            $headers['Api-Status'] = ApiStatus::SUPPORTED;
        }

        $response->header('Api-Status', $headers['Api-Status']);

        return $response;
    }

    private function extractVersionFromRoute(string $route): ?string
    {
        $currentVersion = $this->getVersion($route);

        if (! str_starts_with($currentVersion, 'v')) {
            return null;
        }

        return strtolower($currentVersion);
    }

    private function getVersion(string $path): mixed
    {
        preg_match("/v(\d)/i", $path, $matches);

        return $matches[0];
    }
}
