<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as Status;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return jsonResponse
	 */
	public function index(): jsonResponse
	{
		$users = User::paginate();
		return response()->json(['data' => $users, 'message' => 'Fetch All users'], Status::HTTP_OK);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateUserRequest $request
	 * @return JsonResponse
	 */
	public function store(CreateUserRequest $request): JsonResponse
	{
		$user = User::create($request->all());
		return response()->json(['data' => $user, 'message' => 'User Created Successfully'], Status::HTTP_CREATED);
	}
}
