<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class);
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
        $project = Project::create([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
            'client_project_id' => $validated['client_project_id'],
            'status' => $validated['status'],
            'invoice_email' => $validated['invoice_email'],
        ]);
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
        //
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
        $updated = $project->update([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
            'client_project_id' => $validated['client_project_id'],
            'status' => $validated['status'],
            'invoice_email' => $validated['invoice_email'],
            'gst_applicable' => isset($validated['gst_applicable']) ? true : false,
        ]);
        return redirect(route('projects.edit', $project->id))->with('status', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function destroy(Project $project)
    {
        //
    }

    public function generateInvoice(Request $request, Project $project)
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadView('project.invoice-templates.default', ['isPdf' => true, 'project' => $project]);
        return $pdf->inline();
    }
}
