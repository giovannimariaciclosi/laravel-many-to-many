<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
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
        // creo un array di tecnologie e lo passo con il compact
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
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

        // il save va fatto prima dell'inserimento delle tecnologie (relazione molti a molti)
        // perchè solo quando effettuiamo il salvataggio della riga nel database viene generato l'id
        $newProject->save();
        // inserisco le tecnologie relative al progetto nella tabella ponte
        if (array_key_exists('technologies', $formData)) {
            // il metodo attach della risorsa many-to-many "technologies" che ho collegato a Project
            // mi permette di inserire in automatico nella tabella ponte i collegamenti, riga per riga, con le tecnologie
            // passatigli tramite un array
            $newProject->technologies()->attach($formData['technologies']);
        }

        return redirect()->route('admin.projects.show', $newProject);
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
        // creo un array di tecnologie e lo passo con il compact
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
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
        $this->validation($request, $project->id);

        $formData = $request->all();

        $formData['slug'] = Str::slug($formData['title'], '-');

        $project->update($formData);

        // dobbiamo sempre controllare che l'array esista
        if (array_key_exists('technologies', $formData)) {
            // la funzione sync() ci permette di sincronizzare i tag selezionati nel form con quelli presenti nella tabella ponte
            $project->technologies()->sync($formData['technologies']);
        } else {
            // dobbiamo specificare che se non è stato selezionato alcuna tecnologia, deve eliminare tutti i suoi riferimenti dalla tabella ponte
            $project->technologies()->detach();
        }

        return redirect()->route('admin.projects.show', $project);
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
    private function validation($request, $id = null)
    {
        // con il metodo all prendo i parametri del form
        $formData = $request->all();

        // se cerco di modificare un progetto senza cambiargli il titolo non avrò l'avviso che è già presente un titolo con questo nome
        if ($id != null) {
            $nameValidator = 'required|max:200|min:5|unique:projects,title,' . $id;
        } else {
            $nameValidator = 'required|max:200|min:5|unique:projects,title';
        }

        // importo il validator con il percorso Illuminate\Support\Facades\Validator;
        $validator = Validator::make($formData, [
            // controllo che i parametri del form rispettino le seguenti regole
            'title' => $nameValidator,
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
            'title.unique' => 'È già presente un Titolo con questo nome.',
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
