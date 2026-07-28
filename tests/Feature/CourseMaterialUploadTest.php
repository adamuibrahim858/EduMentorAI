<?php

namespace Tests\Feature;

use App\Livewire\Course\Show;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class CourseMaterialUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_material_upload_pipeline_success()
    {
        Storage::fake('public');

        $user = User::factory()->create(['email_verified_at' => now(), 'status' => 'active']);
        $course = Course::create([
            'user_id'     => $user->id,
            'course_code'  => 'CSC 401',
            'course_title' => 'Artificial Intelligence',
            'course_unit'  => 3,
            'semester'    => 'First Semester',
            'status'      => 'active',
        ]);

        $file = UploadedFile::fake()->create('lecture_notes.pdf', 500, 'application/pdf');

        $component = Livewire::actingAs($user)
            ->test(Show::class, ['course' => $course])
            ->set('showMaterialUploadModal', true)
            ->set('materialTitle', 'Lecture Note 1')
            ->set('materialFile', $file)
            ->call('uploadCourseMaterial');

        $component->assertHasNoErrors();

        // 1. Verify Database Record Creation
        $this->assertDatabaseHas('course_materials', [
            'course_id'         => $course->id,
            'uploaded_by'       => $user->id,
            'title'             => 'Lecture Note 1',
            'original_filename' => 'lecture_notes.pdf',
            'mime_type'         => 'application/pdf',
            'status'            => 'completed',
        ]);

        // 2. Verify Storage File Creation
        $material = CourseMaterial::where('title', 'Lecture Note 1')->first();
        $this->assertNotNull($material);
        Storage::disk('public')->assertExists($material->file);
    }

    public function test_course_material_upload_validation_fails_on_empty_file()
    {
        $user = User::factory()->create(['email_verified_at' => now(), 'status' => 'active']);
        $course = Course::create([
            'user_id'     => $user->id,
            'course_code'  => 'CSC 401',
            'course_title' => 'Artificial Intelligence',
            'course_unit'  => 3,
            'semester'    => 'First Semester',
            'status'      => 'active',
        ]);

        $component = Livewire::actingAs($user)
            ->test(Show::class, ['course' => $course])
            ->set('showMaterialUploadModal', true)
            ->set('materialTitle', 'Test Title')
            ->set('materialFile', null)
            ->call('uploadCourseMaterial');

        $component->assertHasErrors(['materialFile' => 'required']);
    }
}
