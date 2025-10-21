<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\{Dashboard, GruposEconomicos, Bandeiras, Unidades, Colaboradores, Relatorios, Logs};
use Livewire\Volt\Volt;
use Laravel\Fortify\Features;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Grupos Econômicos Routes
    Route::get('/grupos_economicos', GruposEconomicos::class)->name('grupos_economicos');
    Route::controller(GruposEconomicos::class)->group(function () {
        Route::prefix('grupos_economicos')->group(function () {
            Route::post('/delete', 'deleteGroup')->name('grupos_economicos.delete');
            Route::post('/update', 'updateGroup');
        }); 
    });

    // Bandeiras Routes
    Route::get('/bandeiras', Bandeiras::class)->name('bandeiras');
    Route::controller(Bandeiras::class)->group(function () {
        Route::prefix('bandeiras')->group(function () {
            Route::post('/delete', 'deleteFlag')->name('bandeiras.delete');
            Route::post('/update', 'updateFlag');
        });
    });

    // Unidades Routes
    Route::get('/unidades', Unidades::class)->name('unidades');
    Route::controller(Unidades::class)->group(function () {
        Route::prefix('unidades')->group(function () {
            Route::post('/delete', 'deleteUnit')->name('unidades.delete');
            Route::post('/update', 'updateUnit');
        });
    });

    // Colaboradores Routes
    Route::get('/colaboradores', Colaboradores::class)->name('colaboradores');
    Route::controller(Colaboradores::class)->group(function () {
        Route::prefix('colaboradores')->group(function () {
            Route::post('/delete', 'deleteCollaborator')->name('colaboradores.delete');
            Route::post('/update', 'updateCollaborator');
        });
    });

    Route::get('/relatorios', Relatorios::class)->name('relatorios');
    Route::controller(Relatorios::class)->group(function () {
        Route::prefix('relatorios')->group(function () {
            Route::post('/get_report', 'getReport');
        });
    });

    Route::get('/logs', Logs::class)->name('relatorios');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';

