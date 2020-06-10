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
     * index
     *
     * @return void
     */
    public function index()
    {
        $users = User::all();

        return response($users);
    }

    /**
     * store【WIP】
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $user = new User;
        // $article->title = $request->title;
        // $article->body = $request->body;
        // $article->save();
        // return redirect('api/articles');
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
