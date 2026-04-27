<?php

namespace Tests\Feature\Admin;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_project_with_normalized_metadata(): void
    {
        Storage::fake('public');

        $response = $this->actingAs(User::factory()->create())->post(route('admin.projects.store'), [
            'title' => '  Portfolio Control Panel  ',
            'description' => '  Centralised management for project publishing.  ',
            'long_description' => '  Tracks entries, links and visibility state.  ',
            'technologies' => 'Laravel, Tailwind CSS, Laravel, MySQL  ',
            'live_url' => 'https://example.com/projects',
            'github_url' => 'https://github.com/example/projects',
            'featured' => '1',
            'is_active' => '1',
            'order' => '3',
            'image' => UploadedFile::fake()->image('cover.png'),
        ]);

        $response->assertRedirect(route('admin.projects.index'));

        $project = Project::firstOrFail();

        $this->assertSame('Portfolio Control Panel', $project->title);
        $this->assertSame('Centralised management for project publishing.', $project->description);
        $this->assertSame('Tracks entries, links and visibility state.', $project->long_description);
        $this->assertSame(['Laravel', 'Tailwind CSS', 'MySQL'], $project->technologies);
        $this->assertTrue($project->featured);
        $this->assertTrue($project->is_active);
        $this->assertNotNull($project->image);
        $this->assertNull($project->image_url);
        Storage::disk('public')->assertExists($project->image);
    }

    public function test_admin_can_update_a_project_and_switch_to_a_hosted_image(): void
    {
        Storage::fake('public');

        Storage::disk('public')->put('projects/original.png', 'placeholder');

        $project = Project::factory()->create([
            'image' => 'projects/original.png',
            'image_url' => null,
            'fallback_image_url' => null,
            'technologies' => ['Laravel', 'Redis'],
            'featured' => true,
            'is_active' => true,
        ]);

        $response = $this->actingAs(User::factory()->create())->put(route('admin.projects.update', $project), [
            'title' => 'Hosted Image Project',
            'description' => 'Updated summary',
            'long_description' => '',
            'technologies' => '',
            'live_url' => '',
            'github_url' => 'https://github.com/example/hosted-image-project',
            'featured' => '0',
            'is_active' => '0',
            'order' => '9',
            'image_url' => 'https://cdn.example.com/project-cover.png',
            'fallback_image_url' => 'https://cdn.example.com/project-fallback.png',
        ]);

        $response->assertRedirect(route('admin.projects.index'));

        $project->refresh();

        $this->assertSame([], $project->technologies);
        $this->assertFalse($project->featured);
        $this->assertFalse($project->is_active);
        $this->assertNull($project->image);
        $this->assertSame('https://cdn.example.com/project-cover.png', $project->image_url);
        $this->assertSame('https://cdn.example.com/project-fallback.png', $project->fallback_image_url);
        Storage::disk('public')->assertMissing('projects/original.png');
    }

    public function test_index_filters_and_sorts_projects_using_query_parameters(): void
    {
        Project::factory()->create(['title' => 'Atlas Console', 'featured' => true, 'is_active' => false]);
        Project::factory()->create(['title' => 'Beacon Studio', 'featured' => true, 'is_active' => false]);
        Project::factory()->create(['title' => 'Cascade Engine', 'featured' => true, 'is_active' => false]);
        Project::factory()->create(['title' => 'Dormant Standard', 'featured' => false, 'is_active' => false]);
        Project::factory()->create(['title' => 'Live Featured', 'featured' => true, 'is_active' => true]);

        $response = $this->actingAs(User::factory()->create())->get(route('admin.projects.index', [
            'status' => '0',
            'featured' => '1',
            'sort_field' => 'title',
            'sort_direction' => 'desc',
            'per_page' => 25,
        ]));

        $response
            ->assertOk()
            ->assertSeeInOrder(['Cascade Engine', 'Beacon Studio', 'Atlas Console'])
            ->assertDontSee('Dormant Standard')
            ->assertDontSee('Live Featured');
    }

    public function test_bulk_delete_removes_selected_projects_and_their_local_images(): void
    {
        Storage::fake('public');

        Storage::disk('public')->put('projects/first.png', 'first');
        Storage::disk('public')->put('projects/second.png', 'second');

        $first = Project::factory()->create(['image' => 'projects/first.png']);
        $second = Project::factory()->create(['image' => 'projects/second.png']);
        $untouched = Project::factory()->create();

        $response = $this->actingAs(User::factory()->create())->deleteJson(route('admin.projects.bulk-delete'), [
            'project_ids' => [$first->id, $second->id],
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('projects', ['id' => $first->id]);
        $this->assertDatabaseMissing('projects', ['id' => $second->id]);
        $this->assertDatabaseHas('projects', ['id' => $untouched->id]);
        Storage::disk('public')->assertMissing('projects/first.png');
        Storage::disk('public')->assertMissing('projects/second.png');
    }

    public function test_toggle_status_returns_json_for_async_requests(): void
    {
        $project = Project::factory()->create(['is_active' => true]);

        $response = $this->actingAs(User::factory()->create())
            ->postJson(route('admin.projects.toggle-status', $project));

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('is_active', false);

        $this->assertFalse($project->fresh()->is_active);
    }
}
