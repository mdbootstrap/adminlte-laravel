<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;

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
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

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
            $user = User::factory()->create(['password' => Hash::make('passw0RD')]);

            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'passw0RD')
                ->press('Sign In')
                ->waitFor('#result')
                ->pause(5000)
                ->assertPathIs('/home')
                ->assertSee($user->name)
                ->assertAuthenticated();
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
     * Test Login required fields errors disappears on key down.
     *
     * @return void
     */
    public function testLoginRequiredFieldsDisappearsOnKeyDown()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', '')
                ->type('password', '')
                ->press('Sign In')
                ->pause(1000)
                ->type('email', 's')
                ->waitUntilMissing('#validation_error_email')
                ->assertDontSee('The email field is required')
                ->type('password', 'p')
                ->waitUntilMissing('#validation_error_password')
                ->assertDontSee('The password field is required');
        });
    }

    /**
     * Test Login credentials not match.
     *
     * @return void
     */
    public function testLoginCredentialsNotMatch()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'emailquesegurquenoexisteix@sadsadsa.com')
                ->type('password', '12345678')
                ->press('Sign In')
                ->pause(1000)
                ->assertSee('These credentials do not match our records');
        });
    }

    /**
     * Test Login credentials not match disappears on key down.
     *
     * @return void
     */
    public function testLoginCredentialsNotMatchDissappearsOnKeyDown()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->waitFor("[name='email']")
                ->type('email', 'emailquesegurquenoexisteix@sadsadsa.com')
                ->type('password', '12345678')
                ->press('Sign In')
                ->pause(1000)
                ->type('password', '1')
                ->pause(2000)
                ->assertDontSee('These credentials do not match our records');
        });
    }

    /**
     * Test Login with remember me.
     *
     * @return void
     */
    public function testLoginWithRememberMe()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create(['password' => Hash::make('passw0RD')]);

            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'passw0RD')
                ->script("$('input[name=remember]').iCheck('check');");

            $browser->press('Sign In')
                ->waitFor('#result')
                ->pause(5000)
                ->assertPathIs('/home')
                ->assertHasCookie(Auth::getRecallerName())
                ->assertSee($user->name);
        });

        $this->logout();
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
            $user = User::factory()->create();

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
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            view()->share('user', $user);

            $browser->loginAs($user)
                ->visit('/home')
                ->assertSee($user->name);
        });

        $this->logout();
    }

    /**
     * Test log out.
     *
     * @return void
     */
    public function testLogout()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            view()->share('user', $user);

            $browser->loginAs($user)
                ->visit('/home')
                ->click('#user_menu')
                ->pause(500)
                ->click('#logout')
                ->pause(500)
                ->assertGuest();
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
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', '')
                ->type('email', '')
                ->type('password', '')
                ->press('Register')
                ->pause(1000)
                ->assertSee('The name field is required')
                ->assertSee('The email field is required')
                ->assertSee('The password field is required')
                ->assertSee('The terms field is required');
        });
    }

    /**
     * Test new user registration required fields disappears on key down.
     *
     * @return void
     */
    public function testNewUserRegistrationRequiredFieldsDissappearsOnKeyDown()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', '')
                ->type('email', '')
                ->type('password', '')
                ->press('Register')
                ->pause(2000)
                ->type('name', 'S')
                ->pause(2000)
                ->assertDontSee('The name field is required')
                ->type('email', 's')
                ->pause(2000)
                ->assertDontSee('The email field is required')
                ->type('password', 'p')
                ->pause(2000)
                ->assertDontSee('The password field is required')
                ->click('.icheckbox_square-blue')
                ->pause(2000)
                ->assertDontSee('The terms field is required');
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
            $user = User::factory()->create();

            $browser->visit('password/reset')
                ->type('email', $user->email)
                ->press('Send Password Reset Link')
                ->pause(1000)
                ->assertDontSee('We can\'t find a user with that email address.');
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
                ->type('email', 'notexistingemail@gmail.com')
                ->press('Send Password Reset Link')
                ->pause(1000)
                ->assertSee('We can\'t find a user with that email address.');
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

    /**
     * Test send password reset required fields dissapears on key down.
     *
     * @return void
     */
    public function testSendPasswordResetRequiredFieldsDisappearsOnKeyDown()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('password/reset')
                ->type('email', '')
                ->press('Send Password Reset Link')
                ->pause(1000)
                ->type('email', 's')
                ->pause(2000)
                ->assertDontSee('The email field is required.');
        });
    }
}
