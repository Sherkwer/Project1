<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Events\QueryExecuted;
use PDOException;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Registers a DB::listen() hook using the valid QueryExecuted event so
     * that slow or failed queries can be observed at runtime. The
     * reconnection helper below can be invoked from exception handlers
     * whenever a "MySQL server has gone away" error is caught.
     */
    public function boot(): void
    {
        // Listen to every executed query via the valid Laravel API.
        DB::listen(function (QueryExecuted $query) {
            // Intentionally lightweight — extend here for slow-query logging.
        });
    }

    /**
     * Reconnect to the given database connection when the MySQL server has
     * gone away (SQLSTATE HY000 / error 2006).
     *
     * Call this from a catch block in your exception handler after detecting
     * a gone-away error with isGoneAwayError().
     */
    public function reconnectOnGoneAway(\Throwable $exception, ?string $connectionName = null): void
    {
        if (! $this->isGoneAwayError($exception)) {
            return;
        }

        $connectionName ??= config('database.default');

        Log::warning('MySQL server has gone away — attempting to reconnect.', [
            'connection' => $connectionName,
            'error'      => $exception->getMessage(),
        ]);

        try {
            DB::connection($connectionName)->reconnect();
        } catch (\Throwable $e) {
            Log::error('Failed to reconnect to MySQL after "gone away" error.', [
                'connection' => $connectionName,
                'error'      => $e->getMessage(),
            ]);
        }
    }

    /**
     * Determine whether the given exception is a "MySQL server has gone away"
     * error (SQLSTATE HY000, error code 2006).
     */
    public function isGoneAwayError(\Throwable $exception): bool
    {
        $message = $exception->getMessage();

        return str_contains($message, 'server has gone away')
            || str_contains($message, 'SQLSTATE[HY000] [2006]')
            || (
                $exception instanceof PDOException
                && $exception->errorInfo[1] === 2006
            );
    }
}
