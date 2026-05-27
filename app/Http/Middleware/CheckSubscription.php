<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('hustle-posed.login');
        }

        $subscription = \App\Models\Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->first();

        // TEMPORARY BYPASS FOR TESTING
        if (!$subscription) {
            $subscription = new \App\Models\Subscription([
                'user_id' => $user->id,
                'plan_id' => 2,
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addYear()
            ]);
            $subscription->plan = \App\Models\Plan::find(2);
        }

        if (!$subscription) {
            // Optional: redirect to pricing page or show error
            return redirect('/#pricing')->with('error', 'You need an active subscription to access this feature.');
        }

        // Attach plan details to request for easy access
        $request->merge(['subscription' => $subscription, 'plan' => $subscription->plan]);

        return $next($request);
    }
}
