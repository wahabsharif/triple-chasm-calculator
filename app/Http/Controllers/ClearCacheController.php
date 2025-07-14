<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ClearCacheController extends Controller
{
    /**
     * Clear various caches and storage data via Artisan commands.
     *
     * Only allowed in local environment for security.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearAll()
    {
        // Restrict to local environment (so not exposed in production)
        if (!App::environment('local')) {
            abort(403, 'Forbidden');
        }

        $commands = [
            'config:clear',
            'route:clear',
            'view:clear',
            'cache:clear',
            'optimize:clear',
            'clear-compiled',
            'queue:clear', // Clear failed jobs
            'storage:link', // Recreate storage links after clearing
        ];

        $output = [];

        // Clear sessions manually
        $this->clearSessionData($output);

        // Run artisan commands
        foreach ($commands as $command) {
            Artisan::call($command);
            $output[$command] = trim(Artisan::output());
        }

        return response()->json([
            'status' => 'success',
            'output' => $output,
        ]);
    }


    /**
     * Clear session data based on the configured session driver.
     *
     * @param array &$output Reference to output array
     * @return void
     */
    private function clearSessionData(&$output)
    {
        try {
            $sessionDriver = config('session.driver');

            switch ($sessionDriver) {
                case 'file':
                    $this->clearFileSessionData($output);
                    break;

                case 'database':
                    $this->clearDatabaseSessionData($output);
                    break;

                case 'redis':
                    $this->clearRedisSessionData($output);
                    break;

                case 'memcached':
                case 'dynamodb':
                case 'array':
                    $this->clearCacheSessionData($output);
                    break;

                default:
                    $output['session:clear:info'] = "Session driver '{$sessionDriver}' - manual clearing may be required";
                    break;
            }
        } catch (\Exception $e) {
            $output['session:clear:error'] = 'Error clearing sessions: ' . $e->getMessage();
        }
    }

    /**
     * Clear file-based session data.
     *
     * @param array &$output Reference to output array
     * @return void
     */
    private function clearFileSessionData(&$output)
    {
        $sessionPath = storage_path('framework/sessions');

        if (!is_dir($sessionPath)) {
            $output['session:clear:file'] = 'Session directory does not exist';
            return;
        }

        $files = File::glob($sessionPath . '/*');
        $cleared = 0;

        foreach ($files as $file) {
            if (is_file($file) && !str_ends_with($file, '.gitignore')) {
                if (File::delete($file)) {
                    $cleared++;
                }
            }
        }

        $output['session:clear:file'] = "Cleared {$cleared} session files";
    }

    /**
     * Clear database session data.
     *
     * @param array &$output Reference to output array
     * @return void
     */
    private function clearDatabaseSessionData(&$output)
    {
        $sessionTable = config('session.table', 'sessions');

        try {
            $deleted = DB::table($sessionTable)->delete();
            $output['session:clear:database'] = "Cleared {$deleted} database session records";
        } catch (\Exception $e) {
            $output['session:clear:database:error'] = 'Error clearing database sessions: ' . $e->getMessage();
        }
    }

    /**
     * Clear Redis session data.
     *
     * @param array &$output Reference to output array
     * @return void
     */
    private function clearRedisSessionData(&$output)
    {
        try {
            $prefix = config('session.prefix', 'laravel_session');
            $connection = config('session.connection', config('database.redis.client', 'default'));

            // Use Redis facade directly
            $redis = \Illuminate\Support\Facades\Redis::connection($connection);

            // Find all session keys with the prefix
            $keys = $redis->keys($prefix . ':*');

            if (!empty($keys)) {
                $deleted = $redis->del(...$keys);
                $output['session:clear:redis'] = "Cleared {$deleted} Redis session keys";
            } else {
                $output['session:clear:redis'] = 'No Redis session keys found';
            }
        } catch (\Exception $e) {
            $output['session:clear:redis:error'] = 'Error clearing Redis sessions: ' . $e->getMessage();
        }
    }

    /**
     * Clear cache-based session data (memcached, dynamodb, etc.).
     *
     * @param array &$output Reference to output array
     * @return void
     */
    private function clearCacheSessionData(&$output)
    {
        try {
            // For cache-based sessions, we'll flush the entire cache
            // This is more aggressive but ensures sessions are cleared
            Cache::flush();
            $output['session:clear:cache'] = 'Cache flushed (includes sessions)';
        } catch (\Exception $e) {
            $output['session:clear:cache:error'] = 'Error clearing cache sessions: ' . $e->getMessage();
        }
    }
}
