<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Summary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CourseManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_courses_index()
    {
        $user = User::factory()->create(['email_verified_at' => now(), 'status' => 'active']);

        $response = $this->actingAs($user)->get('/courses');

        $response->assertStatus(200);
    }

    public function test_user_can_create_course_and_gets_redirected_to_show_page()
    {
        $user = User::factory()->create(['email_verified_at' => now(), 'status' => 'active']);

        Livewire::actingAs($user)
            ->test(\App\Livewire\Course\Index::class)
            ->set('course_code', 'CSC 301')
            ->set('course_title', 'Software Engineering')
            ->set('course_unit', 3)
            ->set('semester', 'First Semester')
            ->set('description', 'Introduction to Software Architecture')
            ->call('saveCourse')
            ->assertRedirect();

        $this->assertDatabaseHas('courses', [
            'user_id' => $user->id,
            'course_code' => 'CSC 301',
            'course_title' => 'Software Engineering',
        ]);
    }

    public function test_user_can_view_course_detail_page()
    {
        $user = User::factory()->create(['email_verified_at' => now(), 'status' => 'active']);
        $course = Course::create([
            'user_id' => $user->id,
            'course_code' => 'CSC 401',
            'course_title' => 'Artificial Intelligence',
            'course_unit' => 3,
            'semester' => 'First Semester',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get('/courses/' . $course->id);

        $response->assertStatus(200);
        $response->assertSee('CSC 401');
        $response->assertSee('Artificial Intelligence');
    }

    public function test_user_cannot_view_another_users_course()
    {
        $user1 = User::factory()->create(['email_verified_at' => now(), 'status' => 'active']);
        $user2 = User::factory()->create(['email_verified_at' => now(), 'status' => 'active']);

        $course = Course::create([
            'user_id' => $user1->id,
            'course_code' => 'CSC 401',
            'course_title' => 'Artificial Intelligence',
            'course_unit' => 3,
            'semester' => 'First Semester',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user2)->get('/courses/' . $course->id);

        $response->assertStatus(403);
    }
}
