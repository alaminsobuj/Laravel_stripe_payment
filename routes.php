Route::post('stripepayment', [App\Http\Controllers\StripepaymentController::class, 'stripepayment'])->name('stripepayment');
Route::get('stripe_page', [App\Http\Controllers\StripepaymentController::class, 'gotoStripe'])->name('stripe_page');