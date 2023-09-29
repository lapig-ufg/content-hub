<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\UserAuthorized;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormController extends Controller
{
    public function store(Request $request)
    {
        $answer = new Answer;

        if (!UserAuthorized::isAuthorized($request->input('email')))
            return response()->json([
                'mensage' => 'User not authorized.',
                'state' => '401',
            ], Response::HTTP_UNAUTHORIZED);

        $answer->answer = $request->input('answer');
        $answer->form = $request->input('form');
        $answer->date = $request->input('date');

        try
        {
            if ($answer->save()) {
                return response()->json([
                    'mensage' => 'Answer saved succefully.',
                    'state' => '201',
                ], Response::HTTP_CREATED);
            }
            else
            {
                return response()->json([
                    'mensage' => 'Answer not saved.',
                    'state' => '400',
                ], Response::HTTP_BAD_REQUEST);
            }  
        } catch (Exception $e) {
            //TODO: only return message when in dev mode;
            return response()->json([
                'mensage' => $e->getMessage(),
                'state' => '422',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}