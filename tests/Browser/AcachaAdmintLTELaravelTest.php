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
        dump('testLandingPage');
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Acacha')
                ->assertSee('adminlte-laravel')
                ->assertSee('Pratt');
        });
    }

    /**
     * Logout.
     */
    private function logout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('#user_menu')
                ->click('#logout')
                ->pause(2000);
        });
    }

    /**
     * Test Landing Page with user loged.
     *
     * @return void
     */
    public function testLandingPageWithUserLogged()
    {
        dump('testLandingPageWithUserLogged');
        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create();
            $browser->loginAs($user)
                ->visit('/')
                ->assertSee('Acacha')
                ->assertSee('adminlte-laravel')
                ->assertSee('Pratt')
                ->assertSee($user->name);
        });

        $this->logout();
    }

    /**
     * Test Login Page.
     *
     *
     * @return void
     */
    public function testLoginPage()
    {
        dump('testLoginPage');

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
        dump('testLogin');

        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create(['password' => Hash::make('passw0RD')]);
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'passw0RD')
                ->press('Sign In')
                ->waitFor('#result')
                ->pause(5000)
                ->assertPathIs('/home')
                ->assertSee($user->name);
        });

        $this->logout();
    }

    /**
     * Test Login required fields.
     *
     * @return void
     */
    public function testLoginRequiredFields()
    {
        dump('testLoginRequiredFields');
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', '')
                ->type('password', '')
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
        dump('testRegisterPage');
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
        dump('testPasswordResetPage');
        $this->browse(function (Browser $browser) {
            $browser->visit('/password/reset')
                ->assertSee('Reset Password');
        });
    }

    /**
     * Test home page is only for authorized Users.
     *
     * @group failing
     * @return void
     */
    public function testHomePageForUnauthenticatedUsers()
    {
        dump('testHomePageForUnauthenticatedUsers');
        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create();
            view()->share('user', $user);
            $browser->visit('/home')
                ->pause(2000)
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
        dump('testHomePageForAuthenticatedUsers');

        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create();
            view()->share('user', $user);
            $browser->loginAs($user)
                ->visit('/home')
                ->assertSee($user->name);
        });

        $this->logout();
    }

    /**
     * Test log out.
     * @group shit
     * @return void
     */
    public function testLogout()
    {
        dump('testLogout');
        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create();
            view()->share('user', $user);
            $browser->loginAs($user)
                ->visit('/home')
                ->click('#user_menu')
                ->pause(500)
                ->click('#logout')
                ->pause(500);
        });
    }

    /**
     * Test 404 Error page.
     *
     * @return void
     */
    public function test404Page()
    {
        dump('test404Page');
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
        dump('testNewUserRegistration');
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'Sergi Tur Badenas')
                ->type('email', 'sergiturbadenas@gmail.com')
                ->click('.icheckbox_square-blue')
                ->type('password', 'passw0RD')
                ->type('password_confirmation', 'passw0RD')
                ->press('Register')
                ->waitFor('#result')
                ->pause(5000)
                ->assertPathIs('/home')
                ->assertSee('Sergi Tur Badenas');
        });

        $this->logout();
    }

    /**
     * Test new user registration required fields.
     *
     * @return void
     */
    public function testNewUserRegistrationRequiredFields()
    {
        dump('testNewUserRegistrationRequiredFields');

        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', '')
                ->type('email', '')
                ->type('password', '')
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
     * @group failing
     * @return void
     */
    public function testSendPasswordReset()
    {
        dump('testSendPasswordReset');

        $this->browse(function (Browser $browser) {
            $user = factory(\App\User::class)->create();
            $browser->visit('password/reset')
                ->type('email', $user->email)
                ->press('Send Password Reset Link')
                ->waitFor('#result')
                ->pause(1000)
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
        dump('testSendPasswordResetUserNotExists');

        $this->browse(function (Browser $browser) {
            $browser->visit('password/reset')
                ->type('email', 'notexistingemail@gmail.com')
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
        dump('testSendPasswordResetRequiredFields');

        $this->browse(function (Browser $browser) {
            $browser->visit('password/reset')
                ->press('Send Password Reset Link')
                ->pause(1000)
                ->assertSee('The email field is required.');
        });
    }
}
