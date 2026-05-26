<?php

namespace App\Services\GitHub;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GitHubService
{
    protected string $baseUrl = 'https://api.github.com';

    protected function headers($token)
    {
        return [
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/vnd.github+json',
        ];
    }

    public function getRepos($token)
    {
        return Cache::remember("github_repos_{$token}", 600, function () use ($token) {

            return Http::withHeaders($this->headers($token))
                ->get("{$this->baseUrl}/user/repos?per_page=20")
                ->json();
        });
    }

    public function getPullRequests($token)
    {
        return Cache::remember("github_prs_{$token}", 300, function () use ($token) {
            return Http::withHeaders($this->headers($token))
                ->get("{$this->baseUrl}/pulls?per_page=20")
                ->json();
        });
    }

    public function getUserProfile($token)
    {
        return Http::withHeaders($this->headers($token))
            ->get("{$this->baseUrl}/user")
            ->json();
    }

    public function countRepos($token): int
    {
        $repos = $this->getRepos($token);

        return is_array($repos) ? count($repos) : 0;
    }

    public function countPullRequests($token): int
    {
        $prs = $this->getPullRequests($token);

        return is_array($prs) ? count($prs) : 0;
    }
}
