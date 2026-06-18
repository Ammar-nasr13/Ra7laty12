<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

        $middleware->alias([
            'auth.admin' => \App\Http\Middleware\AdminAuthenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->is('admin*') && ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH') || $request->isMethod('DELETE'))) {
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return null;
                }
                
                $message = $e->getMessage();
                if (str_contains(strtolower($message), 'missing') || str_contains(strtolower($message), 'invalid') || str_contains(strtolower($message), 'required')) {
                    $friendly = (app()->getLocale() === 'ar')
                        ? 'فشل حفظ البيانات: بعض الحقول المطلوبة مفقودة أو قيمها غير صالحة. يرجى مراجعة كافة الحقول.'
                        : 'Failed to save: some required fields are missing or invalid. Please review all fields.';
                    $friendlyMessage = $friendly . ' (' . $message . ')';
                } else {
                    $friendlyMessage = ((app()->getLocale() === 'ar') ? 'حدث خطأ أثناء حفظ البيانات: ' : 'An error occurred while saving: ') . $message;
                }

                return redirect()->back()
                    ->withInput()
                    ->withErrors(['appwrite_error' => $friendlyMessage])
                    ->with('error', $friendlyMessage);
            }
        });
    })->create();
