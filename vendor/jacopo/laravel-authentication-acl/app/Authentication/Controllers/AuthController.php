<?php namespace LaravelAcl\Authentication\Controllers;

use Illuminate\Http\Request;
use Sentry, Redirect, App, Config, DB, Log;
use LaravelAcl\Authentication\Validators\ReminderValidator;
use LaravelAcl\Library\Exceptions\JacopoExceptionsInterface;
use LaravelAcl\Authentication\Services\ReminderService;


class AuthController extends Controller {

    protected $authenticator;
    protected $reminder;
    protected $reminder_validator;
    protected $profile_repository;

    public function __construct(ReminderService $reminder, ReminderValidator $reminder_validator)
    {
        $this->authenticator = App::make('authenticator');
        $this->reminder = $reminder;
        $this->reminder_validator = $reminder_validator;
        $this->profile_repository = App::make('profile_repository');
    }

    public function getClientLogin()
    {
        return view('laravel-authentication-acl::client.auth.login');
    }

    public function getAdminLogin()
    {
        return view('laravel-authentication-acl::admin.auth.login');
    }

    public function postAdminLogin(Request $request)
    {
        list($email, $password, $remember) = $this->getLoginInput($request);
        
            try
            {
                $this->authenticator->authenticate(array(
                                                "email" => $email,
                                                "password" => $password
                                             ), $remember);
            }
            catch(JacopoExceptionsInterface $e)
            {
                $errors = $this->authenticator->getErrors();
                return redirect()->route("user.admin.login")->withInput()->withErrors($errors);
            }

            return redirect()->route('dashboard.default');

    }


    public function postClientLogin(Request $request)
    {

        list($email, $password, $remember) = $this->getLoginInput($request);
        
    
        try
        {
            $this->authenticator->authenticate(array(
                                                    "email" => $email,
                                                    "password" => $password
                                               ), $remember);
        }
        catch(JacopoExceptionsInterface $e)
        {
            $errors = $this->authenticator->getErrors();
            return redirect()->route("user.login")->withInput()->withErrors($errors);
        }

        return Redirect::to(Config::get('acl_base.user_login_redirect_url'));
        
    }


    public function editUser(Request $request)
    {
        try
        {
            $user = $this->user_repository->find($request->get('id'));
        } catch(JacopoExceptionsInterface $e)
        {
            $user = new User;
        }
        $presenter = new UserPresenter($user);

        return View::make('laravel-authentication-acl::admin.user.edit')->with(["user" => $user, "presenter" => $presenter]);
    }

    public function postEditUser(Request $request)
    {
        $id = $request->get('id');

        DbHelper::startTransaction();
        try
        {
            $user = $this->f->process($request->all());
            $this->profile_repository->attachEmptyProfile($user);
        } catch(JacopoExceptionsInterface $e)
        {
            DbHelper::rollback();
            $errors = $this->f->getErrors();
            // passing the id incase fails editing an already existing item
            return Redirect::route("users.edit", $id ? ["id" => $id] : [])->withInput()->withErrors($errors);
        }

        DbHelper::commit();

        return Redirect::route('users.edit', ["id" => $user->id])
                       ->withMessage(Config::get('acl_messages.flash.success.user_edit_success'));
    }

    public function test(Request $request)
    {                                                
        return view('profile.test', [
        ]);

    }

    public function editProfile(Request $request)
    {
        $user_id = $request->get('user_id');
        Log::info('user id ----------------- '.$user_id.'====');
        $user_id = '3';
        try
        {
            $user_profile = $this->profile_repository->getFromUserId($user_id);
        } catch(UserNotFoundException $e)
        {
            return Redirect::route('users.list')
                           ->withErrors(new MessageBag(['model' => Config::get('acl_messages.flash.error.user_user_not_found')]));
        } catch(ProfileNotFoundException $e)
        {
            $user_profile = new UserProfile(["user_id" => $user_id]);
        }
        $custom_profile_repo = App::make('custom_profile_repository', [$user_profile->id]);

        return view('profile.index', [
                                    'user_profile'   => $user_profile,
                                    "custom_profile" => $custom_profile_repo
                                                                                  ]);
    }


    public function postEditProfile(Request $request)
    {
        $input = $request->all();
        $service = new UserProfileService($this->profile_validator);

        try
        {
            $service->processForm($input);
        } catch(JacopoExceptionsInterface $e)
        {
            $errors = $service->getErrors();
            return Redirect::back()
                           ->withInput()
                           ->withErrors($errors);
        }
        return Redirect::back()
                       ->withInput()
                       ->withMessage(Config::get('acl_messages.flash.success.user_profile_edit_success'));
    }


    /**
     * Logout utente
     * 
     * @return string
     */
    public function getLogout()
    {
        $this->authenticator->logout();

        return redirect('/login');
    }

    /**
     * Recupero password
     */
    public function getReminder()
    {
        return view("laravel-authentication-acl::client.auth.reminder");
    }

    /**
     * Invio token per set nuova password via mail
     *
     * @return mixed
     */
    public function postReminder(Request $request)
    {
        $email = $request->get('email');

        try
        {
            $this->reminder->send($email);
            return redirect()->route("user.reminder-success");
        }
        catch(JacopoExceptionsInterface $e)
        {
            $errors = $this->reminder->getErrors();
            return redirect()->route("user.recovery-password")->withErrors($errors);
        }
    }

    public function getChangePassword(Request $request)
    {
        $email = $request->get('email');
        $token = $request->get('token');

        return view("laravel-authentication-acl::client.auth.changepassword", array("email" => $email, "token" => $token) );
    }

    public function postChangePassword(Request $request)
    {
        $email = $request->get('email');
        $token = $request->get('token');
        $password = $request->get('password');
        //Log::info('reset password : '.$password);
        if (! $this->reminder_validator->validate($request->all()) )
        {
          return redirect()->route("user.change-password")->withErrors($this->reminder_validator->getErrors())->withInput();
        }

        try
        {
            $this->reminder->reset($email, $token, $password);
        }
        catch(JacopoExceptionsInterface $e)
        {
            $errors = $this->reminder->getErrors();
            return redirect()->route("user.change-password")->withErrors($errors);
        }

        return redirect()->route("user.change-password-success");

    }

    /**
     * @return array
     */
    private function getLoginInput(Request $request)
    {
        $email    = $request->get('email');
        $password = $request->get('password');
        $remember = $request->get('remember');

        return array($email, $password, $remember);
    }
}
