<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Retunera alla filmer
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        //Validera om alla fält har information
        $request->validate([
            'CategoryName' => 'required'

        ]);


        return Category::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $Category = Category::find($id);
        //Kollar om filmen finns
        if ($Category != null) {
            return $Category;
        } else {
            //Om filmen inte finns skriv ut felmeddelande
            return response()->json([
                'Category not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {

        $Category = Category::find($id);
        //Kollar om filmen finns
        if ($Category != null) {
            $Category->update($request->all());
            return $Category;
        } else {
            //Om filmen inte finns skriv ut felmeddelande
            return response()->json([
                'Category not found'
            ], 404);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Category = Category::find($id);
        //Kollar om filmen finns
        if ($Category != null) {
            $Category->delete();
            return response()->json([
                'Category Deleted'
            ]);
        } else {
            //Om filmen inte finns skriv ut felmeddelande
            return response()->json([
                'Category not found'
            ], 404);
        }
    }

    public function searchProduct($id){
        return Category::where('id', $id)->get();

    }

}
