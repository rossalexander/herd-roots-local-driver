<?php

use Valet\Drivers\BasicValetDriver;

class LocalValetDriver extends BasicValetDriver
{
    /**
     * Determine if the driver serves the request.
     */
    public function serves(string $sitePath, string $siteName, string $uri): bool
    {
        return true;
    }

    /**
     * !!!! ENTER THE WEB ROOT IN THE $staticFilePath VARIABLE
     * Determine if the incoming request is for a static file.
     */
    public function isStaticFile(string $sitePath, string $siteName, string $uri)
    {
        $staticFilePath = $sitePath.'/public'.$uri;

        if ($this->isActualFile($staticFilePath)) {
            return $staticFilePath;
        }

        return false;
    }

    /**
     * !!!! ENTER THE WEB ROOT IN THE $sitePath VARIABLE
     * Get the fully resolved path to the application's front controller.
     */
    public function frontControllerPath(string $sitePath, string $siteName, string $uri): ?string
    {
        return parent::frontControllerPath(
            $sitePath.'/public',
            $siteName,
            $this->forceTrailingSlash($uri)
        );
    }

    /**
     * Redirect to uri with trailing slash.
     */
    private function forceTrailingSlash($uri)
    {
        if (substr($uri, -1 * strlen('/wp/wp-admin')) == '/wp/wp-admin') {
            header('Location: '.$uri.'/');
            exit;
        }

        return $uri;
    }
}
