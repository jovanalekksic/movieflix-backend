<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::all();
        // return MovieResource::collection($movies);
        return new MovieCollection($movies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'rating' => 'required',
            'picture' => 'required',
            'genre_id' => 'required',
            'studio_id' => 'required',


        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $movie = Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'rating' => $request->rating,
            'picture' => $request->picture,
            'genre_id' => $request->genre_id,
            'studio_id' => $request->studio_id,
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['Movie created successfully.', new MovieResource($movie)]);
    }

    // {
    //     "title":"Titanic",
    //     "description":"A seventeen-year-old aristocrat falls in love with a kind but poor artist aboard the luxurious, ill-fated R.M.S. Titanic.",
    //     "rating":7.9,
    //     "picture":"https://e1.pxfuel.com/desktop-wallpaper/1022/641/desktop-wallpaper-titanic-movie-poster-titanic-film.jpg",
    //     "genre_id":4,
    //     "studio_id":5
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::find($id);
        return $movie;
        // return new MovieResource($movie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'rating' => 'required',
            'picture' => 'required',
            'genre_id' => 'required',
            'studio_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->rating = $request->rating;
        $movie->picture = $request->picture;
        $movie->genre_id = $request->genre_id;
        $movie->studio_id = $request->studio_id;

        $movie->save();
        return response()->json(['Movie updated successfully.', new MovieResource($movie)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json('Movie deleted successfully');
    }
}
