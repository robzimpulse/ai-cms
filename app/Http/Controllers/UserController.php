<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use SEOMeta;
use Setting;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;

class UserController extends Controller
{
	public function __construct()
	{
		SEOMeta::addMeta('robots', 'noindex,nofollow');
	}

	public function home()
	{
		return view('user.home');
	}

	public function profile()
	{
		SEOMeta::setTitle(Setting::get('app.name') . ' - User Profile');
		return view('user.profile');
	}

	public function favorites()
	{
		return view('user.favorite');
	}

	public function password()
	{
		return view('user.password');
	}

	public function changePassword(ChangePasswordRequest $request)
	{
		$user = User::find(Auth::user()->id);
		$l_password = $request->input('last_password');
		$n_password = $request->input('new_password');
		$r_password = $request->input('repeat_password');

		if (! Hash::check($l_password, $user->password)) {
			return redirect()->back()->withErrors(['password' => 'Last password is wrong, please input correct password.']);
		}

		$user->password = bcrypt($n_password);
		$user->save();

		return redirect()->route('user.password')->with(['message' => 'Success change password.']);
	}

	public function setting()
	{
		SEOMeta::setTitle(Setting::get('app.name') . ' - User Settings');
		return view('user.setting');
	}
}
