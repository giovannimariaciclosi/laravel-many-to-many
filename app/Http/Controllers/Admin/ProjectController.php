<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // creo un array di tipi e lo passo con il compact
        $types = Type::all();

        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // chiamo la funzione di validazione

        $this->validation($request);


        $formData = $request->all();

        $formData['slug'] = Str::slug($formData['title'], '-');

        $newProject = new Project();

        $newProject->fill($formData);

        $newProject->save();

        return redirect()->route('admin.projects.show', $newProject->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin/projects/show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // creo un array di tipi e lo passo con il compact
        $types = Type::all();

        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        // chiamo la funzione di validazione
        $this->validation($request);

        $formData = $request->all();

        $formData['slug'] = Str::slug($formData['title'], '-');

        $project->update($formData);

        $project->save();

        return redirect()->route('admin.projects.show', $project->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index');
    }

    // funzione per validare
    private function validation($request)
    {
        // con il metodo all prendo i parametri del form
        $formData = $request->all();

        // importo il validator con il percorso Illuminate\Support\Facades\Validator;
        $validator = Validator::make($formData, [
            // controllo che i parametri del form rispettino le seguenti regole
            'title' => 'required|max:200|min:5',
            'description' => 'required',
            'slug' => 'nullable',
            'github_repository' => 'required|max:255',

            // il campo type_id deve esistere nella tabella types con campo id
            'type_id' => 'nullable|exists:types,id',
        ], [
            // messaggi da comunicare all'utente per ogni errore
            'title.required' => 'Devi inserire un Titolo.',
            'title.max' => 'Il campo Titolo deve essere minore di :max caratteri.',
            'title.min' => 'Il campo Titolo deve essere maggiore di :min caratteri',
            'description.required' => 'Devi inserire una Descrizione.',
            // 'slug.required' => "Il campo Slug non può essere vuoto e deve essere uguale al campo Titolo.",
            // 'slug.max' => 'Il campo Slug deve essere minore di 200 caratteri ed uguale al campo Titolo.',
            // 'slug.min' => 'Il campo Slug deve essere maggiore di 5 caratteri ed uguale al campo Titolo.',
            'github_repository.required' => 'Devi inserire un Link Repository Github.',
            'github_repository.max' => 'Il campo Link Repository Github deve essere minore di :max caratteri.',
            'type_id.exists' => 'Il Tipo deve essere scelto esclusivamente tra le opzioni disponibili.',
        ])->validate();

        // restituisco il validator che in caso di errore fa automaticamente il redirect
        return $validator;
    }
}
