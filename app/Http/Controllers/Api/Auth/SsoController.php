<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SsoController extends Controller
{
    public function createLink(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'source' => 'required|string',
            'secret' => config('app.env') === 'local' ? 'required|string' : '',
        ]);

        if($request->secret !== config('services.sso.secret') && config('app.env') !== 'local') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        $url = \URL::temporarySignedRoute(
            'sso.login',
            now()->addMinutes(5),
            ['user' => $user->id]
        );

        return response()->json([
            'url' => $url,
        ]);
    }
}
