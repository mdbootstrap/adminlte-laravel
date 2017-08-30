<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use ReflectionException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class AcachaAdminLTELaravelTest.
 *
 * @package Tests\Feature
 */
class AcachaAdminLTELaravelTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        App::setLocale('en');
    }

    /**
     * Set up before class.
     */
    public static function setUpBeforeClass()
    {
        passthru('composer dumpautoload');
    }

    /**
     * Test url returns 200.
     *
     * @param $url
     */
    public function urlReturns200($url)
    {
        $this->urlReturnsCode($url, 200);
    }

    /**
     * Test url returns 404.
     *
     * @param $url
     */
    public function urlReturns404($url)
    {
        $this->urlReturnsCode($url, 404);
    }

    /**
     * Test url returns 302.
     *
     * @param $url
     */
    public function urlReturns302($url)
    {
        $this->urlReturnsCode($url, 302);
    }

    /**
     * Test url returns 401.
     *
     * @param $url
     */
    public function urlReturns401($url)
    {
        $this->urlReturnsCode($url, 401);
    }



    /**
     * Test url returns a specific status code.
     *
     * @param $url
     * @param $code
     */
    public function urlReturnsCode($url, $code)
    {
        $response = $this->get($url);

        $response->assertStatus($code);
    }

    /**
     * Test landing page.
     *
     * @return void
     */
    public function testLandingPage()
    {
        $this->urlReturns200('/');
    }

    /**
     * Test home page.
     *
     * @return void
     */
    public function testHomePage()
    {
        $this->urlReturns302('/home');
    }

    /**
     * Test login page.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $this->urlReturns200('/login');
    }

    /**
     * Test register page.
     *
     * @return void
     */
    public function testRegisterPage()
    {
        $this->urlReturns200('/register');
    }

    /**
     * Test password reset page.
     *
     * @return void
     */
    public function testPasswordResetPage()
    {
        $this->urlReturns200('/password/reset');
    }

    /**
     * Test 404 Error page.
     *
     * @return void
     */
    public function test404Page()
    {
        $this->urlReturns404('asdasdjlapmnnk');
    }

    /**
     * Test user api.
     *
     * @return void
     */
    public function testUserApi()
    {
        $this->urlReturns302('/api/user');
    }

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testNewUserRegistration()
    {
        $response = $this->json('POST', '/register', [
            'name' => 'Sergi Tur Badenas',
            'email' => 'sergiturbadenas@gmail.com',
            'terms' => 'true',
            'password' => 'passw0RD',
            'password_confirmation' => 'passw0RD',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => 'Sergi Tur Badenas',
            'email' => 'sergiturbadenas@gmail.com'
        ]);
    }

    /**
     * Test user registration required fields.
     *
     * @return void
     */
    public function testNewUserRegistrationRequiredFields()
    {
        $response = $this->json('POST', '/register', [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertStatus(422)->assertJson([
            'message' => "The given data was invalid.",
            'errors' => [
                'name' => [ "The name field is required." ],
                'email' => [ "The email field is required." ],
                'password' => [ "The password field is required." ],
                'terms' => [ "The terms field is required." ]
            ]
        ]);
    }

    /**
     * Test login.
     *
     * @return void
     */
    public function testLogin()
    {
        $user = factory(\App\User::class)->create(['password' => Hash::make('passw0RD')]);

        $response = $this->json('POST', '/login', [
            'email' => $user->email,
            'password' => 'passw0RD',
        ]);

        $response->assertStatus(302);
    }

    /**
     * Test login failed.
     *
     * @return void
     */
    public function testLoginFailed()
    {
        $response = $this->json('POST', '/login', [
            'email' => 'sergiturbadenas@gmail.com',
            'password' => 'passw0RDinventatquenopotfuncionat',
        ]);

        $response->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [ 'These credentials do not match our records.' ]
            ]
        ]);
    }

    /**
     * Test user registration required fields.
     *
     * @return void
     */
    public function testLoginRequiredFields()
    {
        $response = $this->json('POST', '/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(422)->assertJson([
            'message' => "The given data was invalid.",
            'errors' => [
                'email' => [ "The email field is required." ],
                'password' => [ "The password field is required." ]
            ]
        ]);
    }

    /**
     * Test make:view command
     *
     */
    public function testMakeViewCommand()
    {
        $view = 'ehqwiqweiohqweihoqweiohqweiojhqwejioqwejjqwe';
        $viewPath= 'views/' . $view . '.blade.php';
        try {
            unlink(resource_path($view));
        } catch (\Exception $e) {
        }
        $this->callArtisanMakeView($view);
        $resultAsText = Artisan::output();
        $expectedOutput = 'File ' . resource_path($viewPath) . ' created';
        $this->assertEquals($expectedOutput, trim($resultAsText));
        $this->assertFileExists(resource_path($viewPath));
        $this->callArtisanMakeView($view);
        $resultAsText = Artisan::output();
        $this->assertEquals('File already exists', trim($resultAsText));
        unlink(resource_path($viewPath));
    }

    /**
     * Create view using make:view command.
     *
     * @param $view
     */
    protected function callArtisanMakeView($view)
    {
        Artisan::call('make:view', [
            'name' => $view,
        ]);
    }

    /**
     * Test adminlte:admin command
     *
     * @group
     */
    public function testAdminlteAdminCommand()
    {
        $seed = database_path('seeds/AdminUserSeeder.php');
        try {
            unlink($seed);
        } catch (\Exception $e) {
        }
        $this->callAdminlteAdminCommand();
        $this->assertFileExists($seed);
    }


    /**
     * Call adminlte:admin command.
     */
    protected function callAdminlteAdminCommand()
    {
        try {
            Artisan::call('adminlte:admin');
        } catch (ReflectionException $re) {
            passthru('composer dumpautoload');
            sleep(2);
            $this->callAdminlteAdminCommand();
        }
    }
}
