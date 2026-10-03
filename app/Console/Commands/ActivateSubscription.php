<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\PlanAccess;
use Illuminate\Console\Command;

class ActivateSubscription extends Command
{
    protected $signature = 'subscriptions:activate {email} {plan : pro or pro_plus} {--days=30}';

    protected $description = 'Aktifkan langganan berbayar setelah pembayaran dikonfirmasi.';

    public function handle(PlanAccess $plans): int
    {
        $plan = $this->argument('plan');
        $days = (int) $this->option('days');

        if (! in_array($plan, ['pro', 'pro_plus'], true) || $days < 1) {
            $this->error('Paket harus pro atau pro_plus, dan durasi minimal satu hari.');

            return self::INVALID;
        }

        $user = User::query()->where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('Pengguna dengan email tersebut tidak ditemukan.');

            return self::FAILURE;
        }

        try {
            $plans->activate($user, $plan, $days);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            $this->error('Tidak ada permintaan langganan pending untuk paket dan pengguna ini.');

            return self::FAILURE;
        }

        $this->info("Paket {$plan} aktif selama {$days} hari untuk {$user->email}.");

        return self::SUCCESS;
    }
}
