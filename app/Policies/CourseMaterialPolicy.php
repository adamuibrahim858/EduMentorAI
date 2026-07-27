<?php

namespace App\Policies;

use App\Models\CourseMaterial;
use App\Models\User;

class CourseMaterialPolicy
{
    public function view(User $user, CourseMaterial $material): bool
    {
        return $user->id === $material->course->user_id;
    }

    public function delete(User $user, CourseMaterial $material): bool
    {
        return $user->id === $material->course->user_id;
    }
}
