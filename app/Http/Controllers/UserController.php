<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->userRepository->getAll();
    }

    public function store(UserStoreRequest $request)
    {
        try {
            return $this->userRepository->create($request->validated());
        } catch (\Exception $e) {
            logger()->error('Error creating user: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while creating the user.'], 500);
        }
    }

    public function show(string $id)
    {
        return $this->userRepository->getById($id);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrfail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255',
                'username' => [
                    'sometimes',
                    'string',
                    'max:255',
                    Rule::unique('users', 'username')->ignore($user ? $user->id : null), // Ignore current user
                ],
                'password' => 'sometimes|nullable|string|min:8',
                'is_active' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            return $this->userRepository->update($user, $request->all());
        } catch (\Exception $e) {
            logger()->error('Error creating user: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while creating the user.'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            return $this->userRepository->delete($id);
            return response()->json(['done' => 'the user is deleted'], 204);
        } catch (\Exception $e) {
            logger()->error('Error delete user: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the user.'], 500);
        }
    }

    public function updateAvatar(Request $request, $id)
    {
        try {
            $user = User::findOrfail($id);
            $validator = Validator::make($request->all(), [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            return $this->userRepository->updateAvatar($user, $request->avatar);
        } catch (\Exception $e) {
            logger()->error('Error delete user: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the user.'], 500);
        }
    }
}
