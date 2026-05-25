<?php

namespace App\Services\Analytics;

use App\Services\GitHub\GitHubService;
use Illuminate\Support\Facades\Cache;

class GitHubAnalyticsService
{
    public function __construct(
        protected GitHubService $gitHubService
    ) {}

    public function dashboard($token)
    {
        return Cache::remember("github_analytics_{$token}", 300, function () use ($token) {

            $repos = $this->gitHubService->getRepos($token);

            $totalRepos = count($repos);

            $languages = [];

            foreach ($repos as $repo) {
                $lang = $repo['language'] ?? 'Unknown';
                $languages[$lang] = ($languages[$lang] ?? 0) + 1;
            }

            return [
                'total_repos' => $totalRepos,
                'languages' => $languages,
            ];
        });
    }
}
