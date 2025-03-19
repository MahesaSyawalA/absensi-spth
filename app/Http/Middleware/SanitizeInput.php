<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Loop melalui semua input request
        foreach ($request->all() as $key => $value) {
            if (is_string($value)) {
                // Sanitasi input: hapus tag HTML dan karakter berbahaya
                $request->merge([$key => $this->sanitize($value)]);
            }
        }

        return $next($request);
    }

    /**
     * Sanitize the given value.
     *
     * @param  string  $value
     * @return string
     */
    protected function sanitize($value)
    {
        // Hapus tag HTML dan karakter khusus
        return htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
    }
}