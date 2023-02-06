<?php

namespace App\Http\Livewire\Main\Auth\Social\Linkedin;

use App\Models\User;
use App\Utils\Uploader\ImageUploader;
use Laravel\Socialite\Facades\Socialite;
use Livewire\Component;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class CallbackComponent extends Component
{
    use SEOToolsTrait;
    
    /**
     * Init component
     *
     * @return void
     */
    public function mount()
    {
        // SEO
        $separator   = settings('general')->separator;
        $title       = __('messages.t_linkedin_login') . " $separator " . settings('general')->title;
        $description = settings('seo')->description;
        $ogimage     = src( settings('seo')->ogimage );

        $this->seo()->setTitle( $title );
        $this->seo()->setDescription( $description );
        $this->seo()->setCanonical( url()->current() );
        $this->seo()->opengraph()->setTitle( $title );
        $this->seo()->opengraph()->setDescription( $description );
        $this->seo()->opengraph()->setUrl( url()->current() );
        $this->seo()->opengraph()->setType('website');
        $this->seo()->opengraph()->addImage( $ogimage );
        $this->seo()->twitter()->setImage( $ogimage );
        $this->seo()->twitter()->setUrl( url()->current() );
        $this->seo()->twitter()->setSite( "@" . settings('seo')->twitter_username );
        $this->seo()->twitter()->addValue('card', 'summary_large_image');
        $this->seo()->metatags()->addMeta('fb:page_id', settings('seo')->facebook_page_id, 'property');
        $this->seo()->metatags()->addMeta('fb:app_id', settings('seo')->facebook_app_id, 'property');
        $this->seo()->metatags()->addMeta('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1', 'name');
        $this->seo()->jsonLd()->setTitle( $title );
        $this->seo()->jsonLd()->setDescription( $description );
        $this->seo()->jsonLd()->setUrl( url()->current() );
        $this->seo()->jsonLd()->setType('WebSite');

        // Let's get our user data
        $user = Socialite::driver('linkedin')->stateless()->user();

        // Get nickname
        if ($user->getNickname()) {
            $nickname = strtolower( str_replace(' ', '_', $user->getNickname()) );
        } else {
            $nickname = "user_" . substr(md5(microtime()),rand(0,26),8);
        }

        // Get email address
        $email           = $user->getEmail();

        // Get name
        $name            = $user->getName();

        // Get avatar
        $avatar          = $user->getAvatar();

        // Get user from database where this linkedin email is same
        $is_email_exists = User::withTrashed()->where('email', $email)->first();

        // Check if this email address, already exists
        if ($is_email_exists) {

            // Go back to login page with error
            if (!is_null($is_email_exists->password)) {
                return redirect('auth/login')->with('error', __('messages.t_socialite_error_email_exists'));
            } else if ($is_email_exists->provider_id !== $user->getId()) {
                return redirect('auth/login')->with('error', __('messages.t_socialite_error_email_exists'));
            }

        }

        // Get user with same username
        $is_username_exists = User::withTrashed()->where('username', $nickname)
                                    ->whereNull('provider_name')
                                    ->whereNull('provider_id')
                                    ->first();

        // Check if username exists
        if ($is_username_exists) {
            $username = $nickname . "_" . substr(md5(microtime()),rand(0,26),4);
        } else {
            $username = $nickname;
        }

        // Check if user has avatar
        if ($avatar) {
            
            // Save user avatar
            $avatar_id = ImageUploader::fromUrl($avatar, 'avatars');

        } else {
            $avatar_id = null;
        }

        // Now we can create this user
        $save = User::firstOrCreate(
            [
                'email'         => $email,
                'provider_id'   => $user->getId(),
                'provider_name' => "linkedin"
            ],
            [
                'avatar_id'         => $avatar_id,
                'email_verified_at' => now(),
                'status'            => 'active',
                'level_id'          => 1,
                'uid'               => uid(),
                'username'          => $username,
                'fullname'          => $name ? $name : null
            ]
        );

        // Login this user
        auth()->login($save, true);

        // Redirect to home page
        return redirect('/');
    }
}
