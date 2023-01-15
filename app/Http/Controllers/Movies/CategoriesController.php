<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movies\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as Status;

class CategoriesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return JsonResponse
	 */
	public function index(): JsonResponse
	{
		return response()->json(['data'=>Category::all(),'message'=>'fetch all categories'],Status::HTTP_OK);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateCategoryRequest $request
	 * @return JsonResponse
	 */
	public function store(CreateCategoryRequest $request): JsonResponse
	{
		$category = Category::create($request->all());
		return response()->json(["data" => $category, "message" => "category created successfully"], Status::HTTP_CREATED);
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param CreateCategoryRequest $request
	 * @param int $id
	 * @return JsonResponse
	 */
	public function update(int $id,CreateCategoryRequest $request): JsonResponse
	{
		if (Category::find($id) == null) return response()->json(["message" => "Id not Found"], Status::HTTP_NOT_FOUND);
		Category::where('id', $id)->update($request->validated());
		$category = Category::find($id);
		return response()->json(["message" => "Category updated successfully", "data" => $category], Status::HTTP_OK);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return JsonResponse
	 */
	public function destroy(int $id): JsonResponse
	{
		if(Category::destroy($id)) return response()->json(["message"=>"Category deleted Successfully"],Status::HTTP_OK);
		return  response()->json(['message'=>'Category Not Found'],Status::HTTP_NOT_FOUND);
	}
}
