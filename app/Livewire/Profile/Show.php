<?php

namespace App\Livewire\Profile;

use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

#[Title('My Profile')]
class Show extends Component
{
    use WithFileUploads;

    // Personal Info
    public string $name      = '';
    public string $email     = '';

    // Profile fields
    public string $phone       = '';
    public string $institution = '';
    public string $faculty     = '';
    public string $department  = '';
    public string $level       = '';
    public string $semester    = '';
    public string $bio         = '';

    // Avatar
    public $avatar = null;        // new upload
    public ?string $avatarPreview = null;  // existing URL

    // Password change
    public string $currentPassword  = '';
    public string $newPassword       = '';
    public string $confirmPassword   = '';

    // UI state
    public bool $showPasswordSection = false;

    public function mount(): void
    {
        $user    = auth()->user();
        $profile = $user->profile;

        $this->name          = $user->name;
        $this->email         = $user->email;
        $this->avatarPreview = $user->avatar;

        if ($profile) {
            $this->phone       = $profile->phone       ?? '';
            $this->institution = $profile->institution ?? '';
            $this->faculty     = $profile->faculty     ?? '';
            $this->department  = $profile->department  ?? '';
            $this->level       = $profile->level       ?? '';
            $this->semester    = $profile->semester    ?? '';
            $this->bio         = $profile->bio         ?? '';
        }

        // Show password section only for email-registered accounts
        $this->showPasswordSection = is_null($user->provider) || $user->provider === 'email';
    }

    // ----------------------------------------------------------------
    // Live avatar preview
    // ----------------------------------------------------------------
    public function updatedAvatar(): void
    {
        $this->validateOnly('avatar', [
            'avatar' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    // ----------------------------------------------------------------
    // Update profile
    // ----------------------------------------------------------------
    public function updateProfile(): void
    {
        $user = auth()->user();

        $this->validate([
            'name'        => ['required', 'string', 'min:2', 'max:100'],
            'email'       => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'       => ['nullable', 'string', 'max:20'],
            'institution' => ['nullable', 'string', 'max:150'],
            'faculty'     => ['nullable', 'string', 'max:150'],
            'department'  => ['nullable', 'string', 'max:150'],
            'level'       => ['nullable', 'string', 'max:30'],
            'semester'    => ['nullable', 'string', 'max:30'],
            'bio'         => ['nullable', 'string', 'max:1000'],
            'avatar'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        try {
            // Handle avatar upload
            if ($this->avatar) {
                // Delete old avatar if it exists on local storage
                if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $path = $this->avatar->store('avatars', 'public');
                $user->avatar = $path;
                $this->avatarPreview = $path;
                $this->avatar = null;
            }

            $user->name  = $this->name;
            $user->email = $this->email;
            $user->save();

            // Upsert profile
            UserProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone'       => $this->phone       ?: null,
                    'institution' => $this->institution ?: null,
                    'faculty'     => $this->faculty     ?: null,
                    'department'  => $this->department  ?: null,
                    'level'       => $this->level       ?: null,
                    'semester'    => $this->semester    ?: null,
                    'bio'         => $this->bio         ?: null,
                ]
            );

            session()->flash('success', 'Profile updated successfully!');
        } catch (Throwable $e) {
            session()->flash('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Change password
    // ----------------------------------------------------------------
    public function changePassword(): void
    {
        $this->validate([
            'currentPassword' => ['required', 'string'],
            'newPassword'     => ['required', 'string', 'min:8', 'confirmed:confirmPassword'],
            'confirmPassword' => ['required', 'string'],
        ]);

        $user = auth()->user();

        if (!Hash::check($this->currentPassword, $user->password)) {
            $this->addError('currentPassword', 'The current password is incorrect.');
            return;
        }

        try {
            $user->password = Hash::make($this->newPassword);
            $user->save();

            $this->currentPassword  = '';
            $this->newPassword      = '';
            $this->confirmPassword  = '';

            session()->flash('success', 'Password changed successfully!');
        } catch (Throwable $e) {
            session()->flash('error', 'Failed to change password: ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Remove avatar
    // ----------------------------------------------------------------
    public function removeAvatar(): void
    {
        $user = auth()->user();

        if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = null;
        $user->save();

        $this->avatarPreview = null;
        $this->avatar = null;

        session()->flash('success', 'Avatar removed successfully.');
    }

    public function render()
    {
        return view('livewire.profile.show', [
            'user' => auth()->user()->load('profile'),
        ])->layout('layouts.app');
    }
}
