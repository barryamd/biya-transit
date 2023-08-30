<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Automatically finding the Policies
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return 'App\\Policies\\' . class_basename($modelClass) . 'Policy';
        });

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        $this->registerPolicies();

        // Verification Email Customization
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject(__('Verify Email Address'))
                ->action(__('Verify Email Address'), $url)
                ->markdown('mail.new-user', [
                    'email' => $notifiable->email ?? '',
                    'password' => $notifiable->password ?? '',
                ]);
        });

        // Resetting password
        ResetPassword::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject(__('Reset Password Notification'))
                ->line(__('You are receiving this email because we received a password reset request for your account.'))
                ->action(__('Reset Password'), $url)
                ->line(__('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
                ->line(__('If you did not request a password reset, no further action is required.'));
        });
    }
}
