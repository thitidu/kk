<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\TeamStanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    $teams = Team::withCount('players')->orderBy('name')->get();
    $players = Player::with('team')->orderBy('name')->get();
    $featuredTeam = $teams->first();
    $featuredPlayer = $players->first();

    return view('welcome', compact('teams', 'players', 'featuredTeam', 'featuredPlayer'));
})->name('home');

Route::get('/news', function () {
    $teams = Team::withCount('players')->orderBy('name')->get();
    $players = Player::with('team')->orderBy('name')->get();
    $featuredTeam = $teams->first();
    $featuredPlayer = $players->first();

    return view('welcome', compact('teams', 'players', 'featuredTeam', 'featuredPlayer'));
})->name('news');

Route::get('/teams', function () {
    $standings = TeamStanding::with('team')
        ->where('season', '2026/27')
        ->orderByRaw('(won * 3 + drawn) DESC')
        ->orderByRaw('(CAST(goals_for AS SIGNED) - CAST(goals_against AS SIGNED)) DESC')
        ->orderByDesc('goals_for')
        ->get()
        ->keyBy('team_id');
    $teams = Team::withCount('players')->orderBy('name')->get();

    return view('teams.index', compact('teams', 'standings'));
})->name('teams.index');

Route::get('/players', function (Request $request) {
    $teams = Team::orderBy('name')->get();
    $selectedTeamId = $request->query('team_id');
    $playersQuery = Player::with('team')->orderBy('name');

    if ($selectedTeamId !== null && $selectedTeamId !== '') {
        $playersQuery->where('team_id', $selectedTeamId);
    }

    $players = $playersQuery->get();
    $positions = Player::query()->distinct()->orderBy('position')->pluck('position');

    return view('players.index', compact('players', 'teams', 'selectedTeamId', 'positions'));
})->name('players.index');

Route::get('/standings', function () {
    $standings = TeamStanding::with('team')
        ->where('season', '2026/27')
        ->orderByRaw('(won * 3 + drawn) DESC')
        ->orderByRaw('(CAST(goals_for AS SIGNED) - CAST(goals_against AS SIGNED)) DESC')
        ->orderByDesc('goals_for')
        ->get();
    $topScorers = Player::with('team')->orderByDesc('goals')->orderByDesc('assists')->orderBy('name')->take(10)->get();
    $topAssists = Player::with('team')->orderByDesc('assists')->orderByDesc('goals')->orderBy('name')->take(10)->get();

    return view('standings.index', compact('standings', 'topScorers', 'topAssists'));
})->name('standings.index');

Route::get('/login', function () {
    return view('auth.form', ['mode' => 'login']);
})->name('login');

Route::get('/register', function () {
    return view('auth.form', ['mode' => 'register']);
})->name('register');

Route::post('/session/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (! Auth::attempt($credentials)) {
        return response()->json(['message' => 'Email หรือ Password ไม่ถูกต้อง'], 401);
    }

    $request->session()->regenerate();

    $user = $request->user();

    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ],
        'token' => $user->createToken('premierleague-token')->plainTextToken,
    ]);
})->name('session.login');

Route::post('/session/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json(['success' => true]);
})->middleware('auth')->name('session.logout');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');

Route::get('/reset-password/{token}', function (Request $request, $token) {
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->query('email'),
    ]);
})->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $credentials = $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $status = Password::reset($credentials, function ($user, $password) {
        $user->forceFill(['password' => Hash::make($password)])->save();
        $user->tokens()->delete();
    });

    return $status === Password::PASSWORD_RESET
        ? redirect('/')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->name('password.update');
