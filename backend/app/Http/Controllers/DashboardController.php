<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\GitHub\GitHubService;

class DashboardController extends Controller
{
    public function __construct(
        protected GitHubService $gitHubService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();

        // If GitHub is not connected
        if (!$user->github_token) {
            return Inertia::render('Home', [
                'stats' => [
                    'repos' => 0,
                    'prs' => 0,
                    'tasks' => 0,
                ],
                'error' => 'GitHub not connected'
            ]);
        }

        $token = $user->github_token;

        // Fetch GitHub data
        $repos = $this->gitHubService->countRepos($token);
        $prs = $this->gitHubService->countPullRequests($token);
        $tasks = Task::all();

        return Inertia::render('Home', [
            'stats' => [
                'repos' => $repos,
                'prs' => $prs,
                'tasks' => $tasks ? count($tasks) : 0,
            ],
        ]);
    }
}
