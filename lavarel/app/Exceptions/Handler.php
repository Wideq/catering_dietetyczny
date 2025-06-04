<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;

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


    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            return response()->view('errors.419', ['exception' => $exception], 419);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->view('errors.403', ['exception' => $exception], 403);
        }

        if ($exception instanceof AuthenticationException) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Nieautoryzowany'], 401);
            }
            return response()->view('errors.401', ['exception' => $exception], 401);
        }

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();

            if (view()->exists("errors.{$statusCode}")) {
                return response()->view("errors.{$statusCode}", [
                    'exception' => $exception,
                    'message' => $exception->getMessage()
                ], $statusCode);
            }

            $errorTitle = $this->getErrorTitle($statusCode);
            $errorClass = $this->getErrorClass($statusCode);

            return response()->view('errors.layouts.error', [
                'errorCode' => $statusCode,
                'errorTitle' => $errorTitle,
                'errorClass' => $errorClass,
                'errorMessage' => $exception->getMessage() ?: 'Wystąpił błąd. Prosimy spróbować ponownie.',
                'exception' => $exception
            ], $statusCode);
        }
        
        if ($exception instanceof ValidationException) {
            if ($request->expectsJson()) {
                return parent::render($request, $exception);
            }
        }

        if (!config('app.debug') && 
            !($exception instanceof ValidationException) &&
            !$this->shouldntReport($exception)) {
            return response()->view('errors.500', [
                'exception' => $exception
            ], 500);
        }
        
        return parent::render($request, $exception);
    }

    protected function getErrorTitle($statusCode)
    {
        return match($statusCode) {
            401 => 'Wymagane uwierzytelnienie',
            403 => 'Brak uprawnień',
            404 => 'Strona nie znaleziona',
            419 => 'Sesja wygasła',
            429 => 'Zbyt wiele żądań',
            500 => 'Wewnętrzny błąd serwera',
            503 => 'Serwis tymczasowo niedostępny',
            default => 'Wystąpił błąd'
        };
    }

    protected function getErrorClass($statusCode)
    {
        return match($statusCode) {
            401, 403, 419, 429 => 'text-warning',
            404 => 'text-secondary',
            500, 501, 502 => 'text-danger',
            503 => 'text-primary',
            default => 'text-danger'
        };
    }
}