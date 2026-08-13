<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class FreeCodeCampService
{
    protected string $apiUrl;
    protected string $learnUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.freecodecamp.api_url');
        $this->learnUrl = config('services.freecodecamp.learn_url');
    }

    /**
     * Execute a GraphQL query against the freeCodeCamp
     * Curriculum API.
     */
    protected function query(
        string $query,
        array $variables = []
    ): array {
        $response = Http::timeout(15)
            ->acceptJson()
            ->post($this->apiUrl, [
                'query' => $query,
                'variables' => $variables,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Unable to connect to the freeCodeCamp API.'
            );
        }

        $data = $response->json();

        if (!empty($data['errors'])) {
            throw new RuntimeException(
                $data['errors'][0]['message']
                    ?? 'freeCodeCamp API returned an error.'
            );
        }

        return $data['data'] ?? [];
    }

    /**
     * Get the curriculum overview.
     */
    public function curriculum(): array
    {
        $query = <<<'GRAPHQL'
        query {
            curriculum {
                superblocks
                certifications
            }
        }
        GRAPHQL;

        return $this->query($query);
    }

    /**
     * Get a superblock.
     */
    public function superblock(string $dashedName): ?array
    {
        $query = <<<'GRAPHQL'
        query ($dashedName: String!) {
            superblock(dashedName: $dashedName) {
                title
                blocks
                challenges {
                    id
                    title
                }
            }
        }
        GRAPHQL;

        $data = $this->query($query, [
            'dashedName' => $dashedName,
        ]);

        return $data['superblock'] ?? null;
    }

    /**
     * Get chapters and modules belonging to a superblock.
     */
    public function chapters(string $superblockDashedName): array
    {
        $query = <<<'GRAPHQL'
        query ($superblockDashedName: String!) {
            chapters(
                superblockDashedName: $superblockDashedName
            ) {
                dashedName
                modules {
                    dashedName
                    blocks
                }
            }
        }
        GRAPHQL;

        $data = $this->query($query, [
            'superblockDashedName' => $superblockDashedName,
        ]);

        return $data['chapters'] ?? [];
    }

    /**
     * Get modules belonging to a chapter.
     */
    public function modules(string $chapterDashedName): array
    {
        $query = <<<'GRAPHQL'
        query ($chapterDashedName: String!) {
            modules(
                chapterDashedName: $chapterDashedName
            ) {
                dashedName
                moduleType
                blockObjects {
                    title
                    challenges {
                        id
                        title
                    }
                }
            }
        }
        GRAPHQL;

        $data = $this->query($query, [
            'chapterDashedName' => $chapterDashedName,
        ]);

        return $data['modules'] ?? [];
    }

    /**
     * Get a specific block.
     */
    public function block(string $dashedName): ?array
    {
        $query = <<<'GRAPHQL'
        query ($dashedName: String!) {
            block(dashedName: $dashedName) {
                title
                dashedName
                superblocks {
                    dashedName
                    title
                }
            }
        }
        GRAPHQL;

        $data = $this->query($query, [
            'dashedName' => $dashedName,
        ]);

        return $data['block'] ?? null;
    }

    /**
     * Build a freeCodeCamp learning URL.
     */
    public function learnUrl(
        string $superblock,
        ?string $block = null,
        ?string $challenge = null
    ): string {
        $url = rtrim($this->learnUrl, '/');
        $url .= '/' . ltrim($superblock, '/');

        if ($block) {
            $url .= '/' . ltrim($block, '/');
        }

        if ($challenge) {
            $url .= '/' . ltrim($challenge, '/');
        }

        return $url;
    }
}
