<?php

namespace App\Http\Controllers;

use App\Services\GoogleBusinessService;
use Illuminate\Support\Facades\Log;

class BusinessProfileController extends Controller
{
    protected $googleBusinessService;

    public function __construct(GoogleBusinessService $googleBusinessService)
    {
        $this->googleBusinessService = $googleBusinessService;
    }

    public function index()
    {
        $user = auth()->user();
        Log::info('Token do usuário:', ['token' => $user->google_token]);
        
        $this->googleBusinessService->setAccessToken($user->google_token);
        
        $accounts = $this->googleBusinessService->getAccounts();
        Log::info('Resposta das contas:', $accounts);
        
        return view('business.index', compact('accounts'));
    }
}