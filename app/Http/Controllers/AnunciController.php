<?php

namespace App\Http\Controllers;

use App\Models\Anunci;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnunciController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('ListAnunci',[
            'anuncis' => Anunci::with('category')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CreateAnunci',[
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'titol' => 'required|max:255',
            'descripcio' => 'required|max:255',
            'date' => 'required|max:255',
            'hora' => 'required|max:255',
            'email' => 'required|max:255',
            'category_id' => 'required|max:255'
        ]);

        Anunci::create($validate);
        return redirect()->route('anunci.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anunci $anunci)
    {
        return Inertia::render('ShowAnunci',[
            'anunci' => $anunci->load('category')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anunci $anunci)
    {
        return Inertia::render('EditAnunci',[
            'anunci' => $anunci,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anunci $anunci)
    {
        $validate = $request->validate([
            'titol' => 'max:255',
            'descripcio' => 'max:255',
            'date' => 'max:255',
            'hora' => 'max:255',
            'email' => 'max:255',
            'category_id' => 'max:255'
        ]);

        $anunci->update($validate);
        return redirect()->route('anunci.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anunci $anunci)
    {
        $anunci->delete();
        return redirect()->route('anunci.index');
    }

    /**
     * Filter anuncis by category name.
     */
    public function filterByCategory(Request $request)
    {
        $category = $request->query('category');
        
        $anuncis = Anunci::with('category')
            ->whereHas('category', function($query) use ($category) {
                $query->where('name', $category);
            })
            ->get();
            
        return response()->json($anuncis);
    }
}
