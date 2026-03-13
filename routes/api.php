<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventStandConfigController;
use App\Http\Controllers\PresentationDateController;
use App\Http\Controllers\PresentationTicketController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StandTypeController;
use App\Http\Controllers\TicketCheckinController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsClient;
use App\Http\Middleware\EnsureUserIsCompany;
use App\Http\Middleware\EnsureUserIsStaff;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {
  Route::post('logout', [AuthController::class, 'logout']);
  Route::get('/catalogs/{catalog}', [CatalogController::class, 'index']);
});

Route::prefix('v1')->group(function () {
  // -------------------------
  // Público (sin auth)
  // -------------------------
  Route::prefix('public')->group(function () {


    Route::prefix('events')->group(function () {
      Route::get('/', [EventController::class, 'publicIndex']);
      Route::get('/presentation_dates', [PresentationDateController::class, 'publicIndex']);
      Route::get('/presentation_tickets', [PresentationTicketController::class, 'publicIndex']);
      Route::post('/sale', [SaleController::class, 'store']);
    });

    Route::post('users', [UserController::class, 'publicStore']);

    Route::prefix('auth')->group(function () {
      Route::post('login', [AuthController::class, 'login']);

      Route::prefix('account')->group(function () {
        Route::prefix('confirm')->group(function () {
          Route::get('{token}', [UserController::class, 'accountConfirmShow']);
          Route::post('{token}', [UserController::class, 'accountConfirm']);
        });
      });

      Route::prefix('password')->group(function () {
        Route::post('recover', [UserController::class, 'passwordRecover']);

        Route::prefix('reset')->group(function () {
          Route::get('{token}', [UserController::class, 'passwordResetShow']);
          Route::post('{token}', [UserController::class, 'passwordReset']);
        });
      });
    });

    Route::get('catalogs/{catalog}', [CatalogController::class, 'publicIndex']);
  });


  // -------------------------
  // STAFF
  // -------------------------
  Route::group(['middleware' => 'auth:api'], function () {
    Route::middleware([EnsureUserIsStaff::class])->group(function () {
      Route::prefix('staff')->group(function () {

        Route::post('/events/tickets/checkin', [TicketCheckinController::class, 'store']);

      });
    });
  });


  // -------------------------
  // COMPANY
  // -------------------------
  Route::group(['middleware' => 'auth:api'], function () {
    Route::middleware([EnsureUserIsCompany::class])->group(function () {
      Route::prefix('company')->group(function () {

        Route::apiResource('/events/event_stand_configs', EventStandConfigController::class);
        Route::patch('/events/event_stand_configs/{id}/activate', [EventStandConfigController::class, 'activate']);
        
        Route::apiResource('/events/stand_types', StandTypeController::class);
        Route::patch('/events/stand_types/{id}/activate', [StandTypeController::class, 'activate']);

        Route::apiResource('/events/presentation_tickets', PresentationTicketController::class);
        Route::patch('/events/presentation_tickets/{id}/activate', [PresentationTicketController::class, 'activate']);

        Route::apiResource('/events/ticket_types', TicketTypeController::class);
        Route::patch('/events/ticket_types/{id}/activate', [TicketTypeController::class, 'activate']);

        Route::apiResource('/events/presentation_dates', PresentationDateController::class);
        Route::patch('/events/presentation_dates/{id}/activate', [PresentationDateController::class, 'activate']);

        Route::apiResource('/events', EventController::class);
        Route::patch('/events/{id}/activate', [EventController::class, 'activate']);

        Route::apiResource('/users', CompanyUserController::class);
        Route::patch('/users/{id}/activate', [CompanyUserController::class, 'activate']);

        Route::get('companies', [CompanyController::class, 'index']);

        Route::get('catalogs/{catalog}', [CatalogController::class, 'CompanyIndex']);

      });
    });
  });

  // -------------------------
  // Protegido (auth:api)
  // -------------------------
  Route::middleware(['auth:api'])->group(function () {
    Route::middleware([EnsureUserIsAdmin::class])->group(function () {

      Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
      });

      Route::apiResource('companies/users', CompanyUserController::class);
      Route::patch('companies/users/{id}/activate', [CompanyUserController::class, 'activate']);

      Route::apiResource('companies', CompanyController::class);
      Route::patch('companies/{id}/activate', [CompanyController::class, 'activate']);

      Route::apiResource('users', UserController::class);
      Route::patch('users/{id}/activate', [UserController::class, 'activate']);

      Route::get('catalogs/{catalog}', [CatalogController::class, 'index']);
    });
  });
});