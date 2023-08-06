<?php

namespace App\Http\Controllers;

use App\Models\Boost;
use Illuminate\Http\Request;

class BoostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $boosts = Boost::take(3)->get();

        return view('show', compact('boosts'));


    }

    /**
     * Show the form for creating a new resource.
     */
    protected function create()
    {
        return view('boosts');

    }
        /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $boosts = Boost::all();
    $count = $boosts->count();

    if ($count > 2)  {
            return redirect()->route('boosts.index')->with('error', 'Boost count exceeded. Cannot create more boosts.');

    }

    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'desc' => 'required',
        'price' => 'required',
        'discount' => 'required',
    ]);

    Boost::create([
        'name' => $validatedData['name'],
        'desc' => $validatedData['desc'],
        'price' => $validatedData['price'],
        'discount' => $validatedData['discount'],
    ]);

    return redirect('boosts');
}

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // Assuming you have a Boost model or similar
        $boost = Boost::findOrFail($request->id);

        return response()->json([
            'message' => 'Boost retrieved successfully',
            'token' => $request->header('Authorization'), // Assuming you want to retrieve the token from the request header
            'boost' => $boost,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $boost = Boost::findOrFail($id);
    return view('edit', compact('boost'));
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'desc' => 'required',
        'price' => 'required',
        'discount' => 'required',
    ]);

    $boost = Boost::findOrFail($id);
    $boost->update($validatedData);

    return redirect()->route('boosts.index', $id)->with('success', 'Boost updated successfully');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Boost $boost)
    {
        //
    }
}
