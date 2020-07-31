<?php

namespace App\Services\Social;

use App\Mail\SocialProviderSentMail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\SocialIdentity;

class SocialService
{
    public function getSocialProviderIndex($provider)
    {
        $socialProvider = $this->getSocialIndex($provider);
        return Socialite::driver($socialProvider)->redirect();
    }

    public function handleSocialProviderCallback($provider)
    {
        $user = $this->createUser(Socialite::driver($provider)->stateless()->user(), $provider);
        Auth::login($user);
        return true;
    }

    /**
     * Check the user is registered If not then register the user.
     * @return Object
     */
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


}
