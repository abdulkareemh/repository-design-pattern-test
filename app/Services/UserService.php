<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;

class UserService
{

    protected $imgaeService;
    public function __construct(StoreImageService $imgaeService)
    {
        $this->imgaeService = $imgaeService;
    }

    public function createUser(array $data)
    {
        $user = User::create($data);

        if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            $user->avatar = $this->imgaeService->storeImage($data['avatar'],'avatars');
            $user->save();
        }

        return $user;
    }

    public function updateUser(User $user,array $data)
    {
        $user->update($data);
        return $user;
    }

    public function savaImage($avatar){
        return $this->imgaeService->storeImage($avatar,'avatars');
    }

}
