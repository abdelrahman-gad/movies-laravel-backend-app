<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movies\CreateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as Status;
use App\Traits\ImageUpload;
use function PHPUnit\Framework\isEmpty;

class MoviesController extends Controller
{
	use ImageUpload;
	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request): JsonResponse
	{
		$movies = Movie::query();
		if (isset($request->title)) $movies->where('title', $request->title);
		if (isset($request->rate)) $movies->where('rate', $request->rate);
		if (isset($request->category_id)) $movies->where('category_id', $request->category_id);
		$movies = $movies->with(['category'])->paginate();
		return response()->json(['data' => $movies, 'message' => 'Fetched movies'], Status::HTTP_OK);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateMovieRequest $request
	 * @return JsonResponse
	 */
	public function store(CreateMovieRequest $request): JsonResponse
	{
		$data = $request->all();
		$image = $request->file('image');
		$imageName = $this->uploadImage($image);
		$data['image'] = $imageName;
		$movie = Movie::create($data);
		return response()->json(['data' => $movie, 'message' => 'Movie created Successfully'], Status::HTTP_CREATED);

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param CreateMovieRequest $request
	 * @param int $id
	 * @return JsonResponse
	 */
	public function update( int $id, CreateMovieRequest $request): JsonResponse
	{
		if (Movie::find($id) == null) return response()->json(["message" => "Movie not Found"], Status::HTTP_NOT_FOUND);
		if(isEmpty($request->validated())) return response()->json(["message" => "Too few data"], Status::HTTP_BAD_REQUEST);
		$data = $request->all();
		$image = $request->file('image');
		$imageName = $this->uploadImage($image);
		$data['image'] = $imageName;
		$movie = Movie::where('id',$id)->update($data);
		return response()->json(['data' => $movie, 'message' => 'Movie Updated Successfully'], Status::HTTP_CREATED);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return JsonResponse
	 */
	public function destroy(int $id): JsonResponse
	{
		if(Movie::destroy($id)) return response()->json(["message"=>"Movie deleted Successfully"],Status::HTTP_OK);
		return  response()->json(['message'=>'Movie Not Found'],Status::HTTP_NOT_FOUND);
	}
}
