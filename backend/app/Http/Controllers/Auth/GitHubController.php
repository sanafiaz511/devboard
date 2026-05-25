<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Analytics\GitHubAnalyticsService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Services\GitHub\GitHubService;
use Inertia\Inertia;

class GitHubController extends Controller
{
    public function __construct(
        protected GitHubService $gitHubService,
        protected GitHubAnalyticsService $analyticsService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user->github_token) {
            return Inertia::render('GitHub/Index', [
                'error' => 'GitHub not connected'
            ]);
        }

        return Inertia::render('GitHub/Index', [
            'repos' => $this->gitHubService->getRepos($user->github_token),
            'prs' => $this->gitHubService->getPullRequests($user->github_token),
            'analytics' => $this->analyticsService->dashboard($user->github_token),
        ]);
    }

    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();
        $user = User::where('email', $githubUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                'email' => $githubUser->getEmail() ?? "github_{$githubUser->getId()}@github.local",
                'password' => bcrypt(str()->random(32)),
            ]);
        }

        $user->github_id = $githubUser->id;
        $user->github_token = $githubUser->token;
        $user->github_avatar = $githubUser->avatar;
        $user->save();

        Auth::login($user);

        return redirect('/dashboard');
    }
}
