<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class TweetController
 * @package App\Http\Controllers
 */
class TweetController extends Controller
{
    /**
     * @return Application|ResponseFactory|Response
     */
    public function index()
    {
        $tweets = Tweet::all();

        return response($tweets);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function create(Request $request)
    {

        try {
            $requestParams = $request->all();
            $requestParams['user_id'] = auth()->user()->id;
            $tweet = Tweet::create($requestParams);

            return response()->json(
                [
                    'message' => 'Tweet created successfully',
                    'data' => $tweet
                ],
                201,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'message' => 'Tweet create failed',
                ],
                500,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        return response($tweet);
    }
}
