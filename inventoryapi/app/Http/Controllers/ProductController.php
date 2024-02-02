<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Summary of ProductController
 */
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Retunera alla filmer
        return Products::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {


        $validatedUser = Validator::make(
            $request->all(),
            [
                'ProductName' => 'required',
                'SKU' => 'required',
                'Description' => 'required',
                'UnitsInInventory' => 'required',
                'MinStockLevel' => 'required',
                'Price' => 'required',
                'categories_id' => 'required'
            ]
        );
        /*   //Validera om alla fält har information
        $request->validate([
        ]);*/
        $data = $request->all();
        // Image upload
        if ($request->hasFile('Image')) {
            $request->validate([
                'Image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
            ]);

            $image = $request->file('Image');
            $filesize = $request->file('Image')->getSize();

            // Generate a unique name for the image
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the uploaded image to a storage directory
            $image->move(public_path('productImage'), $imageName);

            // Create the URL for the uploaded image
            $imageUrl = asset('productImage/' . $imageName);

            // Remove image from request
            unset($request['Image']);

            // Add image to data array
            $data['Image'] = $imageUrl;
            $data = array_merge($request->all(), $data);
        }
        //felaktig inmatning
        if ($validatedUser->fails()) {
            return response()->json([
                'message' => 'Authorization failed',
                'error' => $validatedUser->errors()
            ], 401);
        }

        $products = Products::create($data);

    }
    public function addProduct(Request $request, $id)
    {
        $Category = Category::find($id);

        $validatedUser = Validator::make(
            $request->all(),
            [
                'ProductName' => 'required',
                'SKU' => 'required',
                'Description' => 'required',
                'UnitsInInventory' => 'required',
                'MinStockLevel' => 'required',
                'Price' => 'required',
                'category_id' => 'required'
            ]
        );
        /*   //Validera om alla fält har information
        $request->validate([
        ]);*/
        $data = $request->all();
        // Image upload
        if ($request->hasFile('Image')) {
            $request->validate([
                'Image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
            ]);

            $image = $request->file('Image');
            $filesize = $request->file('Image')->getSize();

            // Generate a unique name for the image
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the uploaded image to a storage directory
            $image->move(public_path('productImage'), $imageName);

            // Create the URL for the uploaded image
            $imageUrl = asset('productImage/' . $imageName);

            // Remove image from request
            unset($request['Image']);

            // Add image to data array
            $data['Image'] = $imageUrl;
            $data = array_merge($request->all(), $data);
        }
        //felaktig inmatning
        if ($validatedUser->fails()) {
            return response()->json([
                'message' => 'Authorization failed',
                'error' => $validatedUser->errors()
            ], 401);
        }
        $products = new Products();
        $products->category_id = $request->ProductName;
        $Category->Products()->save($products);


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $Products = Products::find($id);

        //Kollar om filmen finns
        if ($Products != null) {
            return $Products;
        } else {
            //Om filmen inte finns skriv ut felmeddelande
            return response()->json([
                'Product not found'
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {

        $Products = Products::find($id);
        //Kollar om filmen finns
        if ($Products != null) {
            //Validera om alla fält har information
            $request->validate([
                'ProductName' => 'required',
                'SKU' => 'required',
                'Description' => 'required',
                'UnitsInInventory' => 'required',
                'MinStockLevel' => 'required',
                'Price' => 'required',
                'categories_id' => 'required'
            ]);

            $Products->update($request->all());
            return $Products;
        } else {
            //Om filmen inte finns skriv ut felmeddelande
            return response()->json([
                'Product not found'
            ], 404);
        }
    }

    //Update image
    public function updateImage(Request $request, $id)
    {
        $Products = Products::find($id);
        // Image upload
        if ($Products != null) {
            $request->validate([
                'Image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
            ]);

            $image = $request->file('Image');
            $filesize = $request->file('Image')->getSize();

            // Generate a unique name for the image
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the uploaded image to a storage directory
            $image->move(public_path('productImage'), $imageName);

            // Create the URL for the uploaded image
            $imageUrl = asset('productImage/' . $imageName);

            // Add image to data array
            $data['Image'] = $imageUrl;
            $Products->update($data);
            return $Products;
        }else {
            //Om filmen inte finns skriv ut felmeddelande
            return response()->json([
                'Product not found'
            ], 404);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Products = Products::find($id);
        //Kollar om filmen finns
        if ($Products != null) {
            $Products->delete();
            return response()->json([
                'Product Deleted'
            ]);
        } else {
            //Om filmen inte finns skriv ut felmeddelande
            return response()->json([
                'Product not found'
            ], 404);
        }
    }
    public function searchCategory($categories_id)
    {
        return Products::where('categories_id', $categories_id)->get();
    }


}
