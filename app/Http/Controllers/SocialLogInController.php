<?php

namespace App\Http\Controllers;

use App\Services\Social\SocialService;
use App\SocialIdentity;
use App\User;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialLogInController extends Controller
{
    protected $socialService;
    public function __construct(SocialService $socialService)
    {
        
    }
    function getSocialIndex($provider)
    {
        switch($provider)
        {
            case 'google':
                return 'google';
            case 'facebook':
                return 'facebook';
            default:
                return 'google';
        }
    }
    public function redirect($provider)
    {
        $socialProvider = $this->getSocialIndex($provider);
        return Socialite::driver($socialProvider)->redirect();
    }

    public function callback($provider)
    {
        $response = $this->handleSocialProviderCallback($provider);
        if($response){
            return redirect()->to('/home');
        }else{
            return redirect()->to('/register');
        }
    }
    public function handleSocialProviderCallback($provider){
        $user = $this->createUser(Socialite::driver($provider)->stateless()->user(), $provider);
        Auth::login($user);
        return true;
    }
    function createUser($providerUser, $provider)
    {
       $socialIdentity = SocialIdentity::where('provider_name', $provider)
                ->where('provider_id', $providerUser->getId())
                ->first();

       if ($socialIdentity) {
           return $socialIdentity->user;
       } else {
           $user = User::where('email', $providerUser->getEmail())->first();
           if (!$user) {
               $password = '';
               $user = User::create([
                   'email' => $providerUser->getEmail(),
                   'name' => $providerUser->getName(),
                   'facebook_login'=> ($provider == 'facebook')?1:NULL,
                   'google_login'=>($provider == 'google')?1:NULL,
                   'instagram_login'=>($provider == 'instagram')?1:NULL,
               ]);

           }
           $user->social_identities()->create([
                   'user_id' => $user->id,
                   'provider_id' => $providerUser->getId(),
                   'provider_name' => $provider,
               ]);

           return $user;
       }
    }
}
