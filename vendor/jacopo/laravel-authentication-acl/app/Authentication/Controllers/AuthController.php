<?php namespace LaravelAcl\Authentication\Controllers;

use Illuminate\Http\Request;
use Sentry, Redirect, App, Config, DB;
use LaravelAcl\Authentication\Validators\ReminderValidator;
use LaravelAcl\Library\Exceptions\JacopoExceptionsInterface;
use LaravelAcl\Authentication\Services\ReminderService;

class AuthController extends Controller {

    protected $authenticator;
    protected $reminder;
    protected $reminder_validator;

    public function __construct(ReminderService $reminder, ReminderValidator $reminder_validator)
    {
        $this->authenticator = App::make('authenticator');
        $this->reminder = $reminder;
        $this->reminder_validator = $reminder_validator;
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

    //  wzg coding start ----------------------
    private function pbkdf2($p, $s, $c, $dk_len, $algo = 'sha1') {

    // experimentally determine h_len for the algorithm in question
        static $lengths;
        if (!isset($lengths[$algo])) { $lengths[$algo] = strlen(hash($algo, null, true)); }    
        $h_len = $lengths[$algo];
    
        if ($dk_len > (pow(2, 32) - 1) * $h_len) {
            return false; // derived key is too long
        } else {
            $l = ceil($dk_len / $h_len); // number of derived key blocks to compute
            $t = null;
            for ($i = 1; $i <= $l; $i++) {
                $f = $u = hash_hmac($algo, $s . pack('N', $i), $p, true); // first iterate
                for ($j = 1; $j < $c; $j++) {
                    $f ^= ($u = hash_hmac($algo, $u, $p, true)); // xor each iterate
                }
                $t .= $f; // concatenate blocks of the derived key
            }
            return substr($t, 0, $dk_len); // return the derived key of correct length
        }

    }
    private function check_password($raw_password, $encoded){
        #$encoded = 'pbkdf2_sha256$12000$sISLZL4fiqDX$RByE+rrWa89cOwuVqedK7abA3dj52i5XLCJp0DexZh4=';
        #$encoded = 'pbkdf2_sha256$12000$k4m0cjBwlqpo$d5OZEAwCrcflBmjFhFcypG16U2QIMwJ+9yNT8B3YW1M=';
        $list = explode('$',$encoded);
        $salt = $list[2];
        $iterate = intval($list[1]);

        $hash = $this->pbkdf2($raw_password, $salt, $iterate, 32,$algo = 'sha256');
        $hash2 = base64_encode($hash);
        $raw_encoded = 'pbkdf2_sha256$'.strval($iterate).'$'.$salt.'$'.$hash2;
        //echo $hash2;
        if ($raw_encoded == $encoded) {
            return 1;
        }else{
            return 0;
        }
    }

    //  wzg coding end ----------------------
    public function postClientLogin(Request $request)
    {
        list($email, $password, $remember) = $this->getLoginInput($request);
        
        // wzg coding start ----------------------

        $users = DB::select('select * from users where email = ?;', [$email]);

        //if (isset($users[0]->password_old)){
        //$password_old = $users[0]->password_old;
        if (!isset($users[0]->password) or strlen($users[0]->password)<=1){
            //return redirect()->route("user.admin.login");
            if($this->check_password($password, $users[0]->password_old)){
                return Redirect::to(Config::get('acl_base.user_login_redirect_url'));
            }else{
                return redirect()->route("user.login");
            }


            
        }else{
    
        // wzg coding   end  ----------------------
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
    }

    /**
     * Logout utente
     * 
     * @return string
     */
    public function getLogout()
    {
        $this->authenticator->logout();

        return redirect('/admin/login');
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
