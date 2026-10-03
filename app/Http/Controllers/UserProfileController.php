<?php

namespace App\Http\Controllers;

use App\Services\PlanAccess;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function __invoke(Request $request, PlanAccess $plans): View
    {
        $user = $request->user();
        $activeSubscription = $plans->activeSubscription($user);
        $plan = $plans->currentPlan($user);

        return view('users.profile', [
            'user' => $user,
            'plan' => $plan,
            'planDetails' => config("plans.packages.{$plan}"),
            'activeSubscription' => $activeSubscription,
        ]);
    }
}
