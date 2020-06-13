<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

/**
 * UserController
 *
 * @author @TakehiroTada <taketada.works@gmail.com>
 */
class UserController extends Controller
{

    /**
     * index ユーザー一覧の取得
     *
     * @return void
     */
    public function index()
    {
        $users = User::all();

        return response($users);
    }

    /**
     * store ユーザーの登録
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->account_id = $request->account_id;
        $user->email = $request->email;
        $user->password = bcrypt($request->account_id);
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name_kana = $request->last_name_kana;
        $user->first_name_kana = $request->first_name_kana;
        $user->save();
        return redirect('api/articles');
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * update 【WIP】
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        // $article = Article::find($id);
        // $article->title = $request->title;
        // $article->body = $request->body;
        // $article->save();
        // return redirect("api/articles/".$id);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('api/users');
    }
}
