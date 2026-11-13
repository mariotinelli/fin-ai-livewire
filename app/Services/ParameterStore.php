<?php

declare(strict_types = 1);

namespace App\Services;

use Aws\Ssm\SsmClient;
use UnexpectedValueException;

class ParameterStore
{
    public function __construct(private readonly SsmClient $client)
    {
    }

    public function get(string $name): ?string
    {
        $result = $this->client->getParameter([
            'Name'           => $name,
            'WithDecryption' => true,
        ]);

        $parameter = $result['Parameter'];
        $value     = is_array($parameter) ? ($parameter['Value'] ?? null) : null;

        return is_string($value) ? $value : null;
    }

    /** @return array<string, string> */
    public function getByPath(string $path): array
    {
        $parameters = [];
        $nextToken  = null;

        do {
            $payload = [
                'Path'           => $path,
                'Recursive'      => true,
                'WithDecryption' => true,
            ];

            if ($nextToken !== null) {
                $payload['NextToken'] = $nextToken;
            }

            $result = $this->client->getParametersByPath($payload);

            $page = $result['Parameters'] ?? [];

            if (!is_array($page)) {
                throw new UnexpectedValueException('Resposta inválida do Parameter Store.');
            }

            foreach ($page as $parameter) {
                if (!is_array($parameter) || !is_string($parameter['Name'] ?? null) || !is_string($parameter['Value'] ?? null)) {
                    throw new UnexpectedValueException('Resposta inválida do Parameter Store.');
                }

                $parameters[$this->environmentKey($path, $parameter['Name'])] = $parameter['Value'];
            }

            $nextToken = $result['NextToken'] ?? null;

            if ($nextToken !== null && !is_string($nextToken)) {
                throw new UnexpectedValueException('Paginação inválida do Parameter Store.');
            }
        } while ($nextToken !== null);

        return $parameters;
    }

    private function environmentKey(string $path, string $name): string
    {
        return (string) str($name)
            ->after(rtrim($path, '/') . '/')
            ->replace('/', '_')
            ->upper();
    }
}
