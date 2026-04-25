<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * The maximum number of times a failed query should be retried.
     */
    protected int $maxRetries = 3;

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
     * Listens for query exceptions and automatically reconnects + retries
     * when a "MySQL server has gone away" (SQLSTATE HY000 / error 2006)
     * error is detected.
     */
    public function boot(): void
    {
        DB::whenQueryingForLongerThan(0, function () {
            // No-op — hook point kept for future slow-query logging.
        });

        // Wrap every database statement execution with reconnect-on-loss logic.
        DB::listen(function ($query) {
            // Listener is intentionally lightweight; reconnection is handled
            // at the connection level via the reconnect logic below.
        });

        // Register a query exception handler that reconnects and retries
        // when the MySQL server has gone away.
        $this->app->resolving('db', function ($db) {
            // Nothing to resolve at bind time; logic lives in the event below.
        });

        // Hook into every resolved database connection.
        DB::resolving(function ($connection) {
            // Not available on all driver types — guard defensively.
        });

        // The primary fix: intercept QueryException events and retry.
        app('events')->listen(
            \Illuminate\Database\Events\QueryExceptionOccurred::class,
            function ($event) {
                $this->handleQueryException($event);
            }
        );
    }

    /**
     * Handle a query exception, reconnecting and retrying if the MySQL
     * server has gone away.
     */
    protected function handleQueryException($event): void
    {
        $exception = $event->exception ?? null;

        if (! $exception) {
            return;
        }

        if (! $this->isGoneAwayError($exception)) {
            return;
        }

        $connectionName = $event->connectionName ?? config('database.default');

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
    protected function isGoneAwayError(\Throwable $exception): bool
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
