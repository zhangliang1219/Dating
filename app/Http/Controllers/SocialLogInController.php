<?php

namespace App\Http\Controllers;

use App\Services\Social\SocialService;
use Socialite;
use Illuminate\Support\Facades\Session;

class SocialLogInController extends Controller
{
    protected $socialService;
    public function __construct(SocialService $socialService)
    {
        $this->socialService = $socialService;
    }

    public function redirect($provider)
    {
       return $this->socialService->getSocialProviderIndex($provider);
    }

    public function callback($provider)
    {
        $response = $this->socialService->handleSocialProviderCallback($provider);
        if($response){
            return redirect()->to('/home');
        }else{
            return redirect()->to('/home');
        }
    }
}
