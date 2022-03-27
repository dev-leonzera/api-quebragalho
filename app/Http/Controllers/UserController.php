<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Worker;
use App\Models\UserFavorite;

class UserController extends Controller
{
    private $loggedUser;

    public function __construct(){
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user();
    }

    public function getUser(){
        $info = $this->loggedUser;
        $info['avatar'] = url('media/avatars/'.$info['avatar']);

        $array['data'] = $info;
    }

    public function toggleFavorite(Request $request){

        $id_worker = $request->input('worker');

        $worker = Worker::find($id_worker);

        if($worker){
            $favorite = UserFavorite::select()
            ->where('id_user', $this->loggedUser->id)
            ->where('id_worker', $id_worker)->first();

            if($favorite){
                $favorite->delete();
            } else {
                $newFavorite = new UserFavorite();
                $newFavorite->id_user = $this->loggedUser->id;
                $newFavorite->id_worker = $id_worker;
                $newFavorite->save();
            }
        } else {
            //
        }
    }

    public function getFavorites() {
        $array = ['error' => '', 'list'=>[]];

        $favorites = UserFavorite::select()
        ->where('id_user', $this->loggedUser->id)
        ->get();

        if($favorites){
            foreach($favorites as $fav){
                $worker = Worker::find($fav['id_worker']);
                $worker['avatar'] = url('/media/avatars/'.$worker['avatar']);
                $array['list'][] = $worker;
            }
        }

        return $array;
    }

    public function updateUser(Request $request){
        $array = ['error' => null];

        $rules = [
            'name' => 'min:2',
            'email' => 'email|unique:users',
            'password' => 'same:password_confirm',
            'password_confirm' => 'same:password'
        ];

        $validator = Validator::make($request->all(), $rules);

        $if($validator->fails()){
            $array['error'] = $validator->messages();
            return $array;
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_confirm = $request->input('password_confirm');

        $user = User::find($this->loggedUser->id);

        if($name) {
            $user->name = $name;
        }

        if($email) {
            $user->email = $email;
        }

        if($password) {
            $user->password = password_hash($password, PASSWORD_DEFAULT);
        }

        $user->save();

        return $array;
    }

    public function updateAvatar(Request $request) {
        $array = ['error'=>''];

        $rules = [
            'avatar' => 'required|image|mimes:png,jpg,jpeg'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            $array['error'] = $validator->messages();
            return $array;
        }

        $avatar = $request->file('avatar');

        $dest = public_path('/media/avatars');
        $avatarName = md5(time().rand(0,9999)).'.jpg';

        $img = Image::make($avatar->getRealPath());
        $img->fit(300, 300)->save($dest.'/'.$avatarName);

        $user = User::find($this->loggedUser->id);
        $user->avatar = $avatarName;
        $user->save();

        return $array;
    }
}
