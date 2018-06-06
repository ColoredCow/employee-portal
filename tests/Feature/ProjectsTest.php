<?php

namespace Tests\Feature;

use App\User;

class ProjectsTest extends FeatureTest
{

    /** @test */
    public function an_authorised_user_can_see_projects() {
        $this->anAuthorizedUser();
        $this->get('/projects')
            ->assertStatus(200);
    }

    /** @test */
    public function an_unauthorised_user_cant_see_projects() {
        $this->withoutExceptionHandling()
            ->expectException('Illuminate\Auth\Access\AuthorizationException');
        $this->signIn();
        $this->get('/projects');
    }

    /** @test */
    public function a_guest_cant_see_projects() {
        $this->get('/projects')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authorised_user_can_create_a_project() {
        $this->anAuthorizedUser();
        $project = create('App\Models\Project');
        $this->post('/projects/', $project->toArray());
        $this->get($project->path() . '/edit')
            ->assertSee($project->name);
    }

    /** @test */
    public function an_authorised_user_can_update_a_project() {
        $this->anAuthorizedUser();
        $project = create('App\Models\Project');
        $this->get($project->path() . '/edit')
            ->assertSee($project->name);
        $newProject = make('App\Models\Project');
        $this->patch($project->path(), $newProject->toArray());
        $this->get($project->path() . '/edit')
            ->assertSee($newProject->name);
    }

    public function anAuthorizedUser() {
        $this->signIn(create(User::class)->assignRole('super-admin'));
    }
}
