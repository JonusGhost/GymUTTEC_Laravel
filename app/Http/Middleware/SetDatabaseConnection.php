<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\DB;

class SetDatabaseConnection
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $dbConfig = [
                'driver'    => 'pgsql',
                'host'      => env('DB_HOST', '127.0.0.1'),
                'port'      => env('DB_PORT', '5432'),
                'database'  => $user->database_name,
                'username'  => $user->db_username,
                'password'  => $user->db_password, 
                'charset'   => 'utf8',
                'prefix'    => '',
                'schema'    => 'public',
                'sslmode'   => 'prefer',
            ];

            Config::set('database.connections.pgsql', $dbConfig);

            DB::purge('pgsql');
            DB::reconnect('pgsql');
        }

        return $next($request);
    }
}
