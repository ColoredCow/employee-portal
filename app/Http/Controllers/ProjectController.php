<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\HR\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Requests\ProjectRequest;
use App\Services\Project\ProjectService;

class ProjectController extends Controller
{
    protected $service;
    public function __construct(ProjectService $projectService)
    {
        $this->authorizeResource(Project::class);
        $this->service = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('list', Project::class);
        
        if (request()->has('client_id')) {
            $client = Client::find(request()->input('client_id'));
            $projects = $client->projects()->paginate();
        } else {
            $projects = Project::getList();
        }
        return view('project.index')->with([
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('project.create')->with([
            'clients' => Client::active()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectRequest $request)
    {
        $validated = $request->validated();
        $project = $this->service->create($validated);
        return redirect(route('projects.edit', $project->id))->with('status', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function show(Project $project)
    {
        $project->load('stages', 'stages.billings', 'stages.billings.invoice', 'employees');

        return view('project.show')->with([
            'project' => $project,
            'clients' => Client::select('id', 'name')->get(),
            'employees' => Employee::select('id', 'name')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project)
    {
        $project->load('stages', 'stages.billings', 'stages.billings.invoice');

        return view('project.edit')->with([
            'project' => $project,
            'clients' => Client::select('id', 'name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        $this->service->setProject($project);
        $this->service->update($validated);
        return redirect(route('projects.edit', $project->id))->with('status', 'Project updated successfully!');
    }

    public function generateInvoice(Request $request, Project $project)
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadView('project.invoice-templates.default', ['isPdf' => true, 'project' => $project]);
        return $pdf->inline();
    }

    /**
     * Add Employees to this Project.
 *
     * @param  \App\Models\Project  $project
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addEmployee(Project $project, Request $request)
    {
        $project->employees()->attach($request->get('employeeId'), ['contribution_type' => $request->get('contribution')]);

        return redirect(route('projects.show', $project))->with('status', 'Employee added to the project successfully!');
    }

    /**
     * Remove Employees from this Project.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeEmployee(Project $project, Request $request)
    {
        $project->employees()->detach($request->get('employeeId'));

        return redirect(route('projects.show', $project))->with('status', 'Employee removed from the project successfully!');
    }
}
