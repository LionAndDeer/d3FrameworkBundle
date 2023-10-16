<?php

namespace Liondeer\Framework\DependencyInjection;

use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

class AwsEnvVarProcessor implements EnvVarProcessorInterface
{
    public function getEnv(string $prefix, string $name, \Closure $getEnv): mixed
    {
        if ($getEnv('APP_ENV') == 'dev') {
            return $getEnv($name);
        }
        try {
            $json = json_decode(shell_exec('/opt/elasticbeanstalk/bin/get-config environment'), true, 512, JSON_THROW_ON_ERROR);
            return $json[$name];
        } catch (\Exception $exception) {
            return $getEnv($name);
        }

    }

    public static function getProvidedTypes(): array
    {
        return [
            'secret' => 'string',
            'string' => 'string'
        ];
    }
}
