<?php

namespace App\Http\Middleware;

use App\Services\PlanAccess;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequirePlanFeature
{
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $user = $request->user();

        if (! $user || ! app(PlanAccess::class)->allows($user, $feature)) {
            return redirect()->route('plans.index')->with('upgrade_required', 'Fitur ini tersedia pada paket Pro atau Pro Plus.');
        }

        return $next($request);
    }
}
