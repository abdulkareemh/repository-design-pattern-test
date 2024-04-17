<?php


namespace App\Repositories;

use App\Models\User;
use App\Services\UserService;

class UserRepository
{
    protected $model;
    protected $userService;

    public function __construct(User $user, UserService $userService)
    {
        $this->model = $user;
        $this->userService = $userService;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        $user = $this->userService->createUser($data);
        return response()->json(['user' => $user], 201);
    }

    public function update(User $user, array $data)
    {
        
        $this->userService->updateUser($user, $data);
        return $user;
    }

    public function delete($id)
    {
        
        $user = $this->model->find($id);
        $imgePath = public_path($user->getRawOriginal('avatar'));
        if (file_exists($imgePath)) {
            unlink($imgePath);
        }
        return $this->model->destroy($id);
    }

    function updateAvatar(User $user,$avatar) {
        $imagePath = public_path($user->getRawOriginal('avatar'));
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $imagePath = $this->userService->savaImage($avatar);
        $user->avatar = $imagePath;
        $user->save();
        return $user;
    }
}
