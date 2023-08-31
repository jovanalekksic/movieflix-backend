<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class UserMovieController extends Controller
{
    public function index($user_id)
    {
        $movies = Movie::get()->where('user_id', $user_id);
        if (is_null($movies)) {
            return response()->json('Data not found', 404);
        }
        return response()->json($movies);
    }
}
