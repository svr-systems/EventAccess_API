<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class MacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blueprint::macro('auditFields', function () {
            $this->boolean('is_active')->default(true);

            $this->timestamps();

            $this->foreignId('created_by_id')
                ->constrained('users');

            $this->foreignId('updated_by_id')
                ->constrained('users');
        });
    }
}