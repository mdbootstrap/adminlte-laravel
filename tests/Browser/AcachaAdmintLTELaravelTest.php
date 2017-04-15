<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class AcachaAdmintLTELaravelTest.
 *
 * @package Tests\Browser
 */
class AcachaAdmintLTELaravelTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test Landing Page.
     *
     * @return void
     */
    public function testLandingPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Acacha')
                ->assertSee('adminlte-laravel')
                ->assertSee('Pratt');
        });
    }

    /**
     * Test Landing Page with user loged.
     *
     * @return void
     */
    public function testLandingPageWithUserLogged()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create();
            $browser->loginAs($user)
                ->visit('/')
                ->assertSee('Acacha')
                ->assertSee('adminlte-laravel')
                ->assertSee('Pratt')
                ->assertSee($user->name);
        });
    }

    /**
     * Test Login Page.
     *
     *
     * @return void
     */
    public function testLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Sign in to start your session');
        });
    }

    /**
     * Test Login.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create(['password' => Hash::make('passw0RD')]);
            $browser->visit('/login')
                ->type('email', $user->email )
                ->type('password','passw0RD' )
                ->press('Sign In')
                ->waitFor('#result')
                ->pause(5000)
                ->assertPathIs('/home')
                ->assertSee($user->name);
        });
    }

    /**
     * Test Login required fields.
     *
     * @return void
     */
    public function testLoginRequiredFields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', '' )
                ->type('password','' )
                ->press('Sign In')
                ->pause(1000)
                ->assertSee('The email field is required')
                ->assertSee('The password field is required');
        });
    }

    /**
     * Test register page.
     *
     * @return void
     */
    public function testRegisterPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->assertSee('Register a new membership');
        });
    }

    /**
     * Test Password reset Page.
     *
     * @return void
     */
    public function testPasswordResetPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/password/reset')
                ->assertSee('Reset Password');
        });
    }

    /**
     * Test home page is only for authorized Users.
     *
     * @return void
     */
    public function testHomePageForUnauthenticatedUsers()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create();
            view()->share('user', $user);
            $browser->visit('/home')
                ->assertPathIs('/login');
        });
    }

    /**
     * Test home page works with Authenticated Users.
     *
     * @return void
     */
    public function testHomePageForAuthenticatedUsers()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create();
            view()->share('user', $user);
            $browser->loginAs($user)
                ->visit('/home')
                ->assertSee($user->name);
        });
    }

    /**
     * Test log out.
     *
     * @return void
     */
    public function testLogout()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create();
            view()->share('user', $user);
            $browser->loginAs($user)
                ->visit('/home')
                ->click('#user_menu')
                ->click('#logout');
        });
    }

    /**
     * Test 404 Error page.
     *
     * @return void
     */
    public function test404Page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/asdasdjlapmnnkadsdsa')
                ->assertSee('404');
        });
    }

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testNewUserRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name' , 'Sergi Tur Badenas')
                ->type('email' ,'sergiturbadenas@gmail.com')
                ->click('.icheckbox_square-blue')
                ->type('password' , 'passw0RD')
                ->type('password_confirmation' , 'passw0RD')
                ->press('Register')
                ->waitFor('#result')
                ->pause(5000)
                ->assertPathIs('/home')
                ->assertSee('Sergi Tur Badenas');
        });
    }

    /**
     * Test user registration required fields.
     *
     * @return void
     */
    public function testNewUserRegistrationRequiredFields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->press('Register')
                ->pause(1000)
                ->assertSee('The name field is required')
                ->assertSee('The email field is required')
                ->assertSee('The password field is required');
        });
    }

    /**
     * Test send password reset.
     *
     * @return void
     */
    public function testSendPasswordReset()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create();
            $browser->visit('password/reset')
                ->type('email' , $user->email)
                ->press('Send Password Reset Link')
                ->waitFor('#result')
                ->assertSee('We have e-mailed your password reset link!');
        });
    }

    /**
     * Test send password reset user not exists.
     *
     * @return void
     */
    public function testSendPasswordResetUserNotExists()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('password/reset')
                ->type( 'email','notexistingemail@gmail.com')
                ->press('Send Password Reset Link')
                ->pause(1000)
                ->assertSee('We can\'t find a user with that e-mail address.');
        });
    }

    /**
     * Test send password reset required fields.
     *
     * @return void
     */
    public function testSendPasswordResetRequiredFields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('password/reset')
                ->press('Send Password Reset Link')
                ->pause(1000)
                ->assertSee('The email field is required.');
        });
    }

}
