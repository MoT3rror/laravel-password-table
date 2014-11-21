<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

    public function doRegister()
    {
        $data = Input::all();

        $rules = array(
            'username'   => 'required',
            'password'   => 'required',
        );

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            return Response::json(array('success' => true));
        } else {
            return Response::json(array('success' => false));
        }
    }

    public function getUserInfo()
    {
        $users = User::where('cracked', 0)->get();

        $users_needed = array();
        foreach ($users as $user) {
            $users_needed[] = array(
                'username' => $user->username,
            );
        }

        $users = User::where('cracked', 1)->get();

        $users_cracked = array();
        foreach ($users as $user) {
            $users_cracked[] = array(
                'username' => $user->username,
            );
        }

        if (User::count()) {
            $percentage = (int) ((count($users) / User::count()) * 100);
        } else {
            $percentage = 0;
        }

        return Response::json(array(
            'users_cracked' => $users_cracked,
            'users_needed'  => $users_needed,
            'percentage'    => $percentage,
        ));
    }
}
