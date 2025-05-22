<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Lista wyjątków, które nie są zgłaszane.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [];

    /**
     * Lista wyjątków, które nie są logowane.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Zgłoś lub zarejestruj wyjątek.
     */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * Renderuj odpowiedź dla wyjątku.
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $statusCode = $exception->getStatusCode();

            if ($statusCode === 403) {
                return response()->view('403', [], 403);
            }

            if ($statusCode === 404) {
                return response()->view('404', [], 404);
            }

            if ($statusCode === 500) {
                return response()->view('500', [], 500);
            }
        }

        return parent::render($request, $exception);
    }
}