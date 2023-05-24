<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// helper per gestire le stringhe
use Illuminate\Support\Str;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technologies = Technology::all();

        return view('admin/technologies/index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.technologies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->all();

        $this->validation($formData);

        $formData['slug'] = Str::slug($formData['name'], '-');

        $newTechnology = new Technology();

        $newTechnology->fill($formData);

        $newTechnology->save();

        return redirect()->route('admin.technologies.show', $newTechnology);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        return view('admin/technologies/show', compact('technology'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {
        return view('admin/technologies/edit', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Technology $technology)
    {
        $formData = $request->all();

        // passo anche l'id che serve nel validator
        $this->validation($formData, $technology->id);

        $formData['slug'] = Str::slug($formData['name'], '-');

        $technology->update($formData);

        return redirect()->route('admin.technologies.show', $technology);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();

        return redirect()->route('admin.technologies.index');
    }

    // validazione
    private function validation($formData, $id = null)
    {

        // se cerco di modificare una tecnologia senza cambiargli il nome non avrò l'avviso che è già presente una tecnologia con questo nome
        if ($id != null) {
            $nameValidator = 'max:100|required|unique:technologies,name,' . $id;
        } else {
            $nameValidator = 'max:100|required|unique:technologies,name';
        }

        $validator = Validator::make($formData, [
            'name' => $nameValidator,
            'color' => 'max:7',
        ], [
            'name.max' => 'Il campo Nome deve essere minore di :max caratteri.',
            'name.required' => 'Devi inserire un Nome.',
            'name.unique' => 'È già presente una Tecnologia con questo nome.',
            'color.max' => 'Il campo Colore deve essere minore di :max caratteri.'
        ])->validate();
        return $validator;
    }
}
