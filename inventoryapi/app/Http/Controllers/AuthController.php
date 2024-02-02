<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Register User
    public function register(Request $request)
    {
        $validatedUser = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'phone' => 'required'

            ]
        );
        $data = $request->all();

         // Image upload
         if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
            ]);

            $image = $request->file('image');
            $filesize = $request->file('image')->getSize();

            // Generate a unique name for the image
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the uploaded image to a storage directory
            $image->move(public_path('uploads'), $imageName);

            // Create the URL for the uploaded image
            $imageUrl = asset('uploads/' . $imageName);

            // Remove image from request
            unset($request['image']);

            // Add image to data array
            $data['image'] = $imageUrl;
            $data = array_merge($request->all(), $data);
        }



        //felaktig inmatning
        if ($validatedUser->fails()) {
            return response()->json([
                'message' => 'Authorization failed',
                'error' => $validatedUser->errors()
            ], 401);
        }


        //rätt inmatning - spara användare och token
        $user = User::create($data);

        $token = $user->createToken('APITOKEN')->plainTextToken;

        $response = [
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    //log in user

    public function login(Request $request)
    {

        $validatedUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        //felaktig inmatning
        if ($validatedUser->fails()) {
            return response()->json([
                'message' => 'Authorization failed',
                'error' => $validatedUser->errors()
            ], 401);
        }

        //incorrect login credentials
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid email/password'
            ], 401);

        }
        //correct login - return access token
        $user = User::where('email', $request->email)->first();
        $id = User::where('email', $request->email)->first()->id;
        return response()->json([
            'message' => 'User logged in',
            'token' => $user->createToken('APITOKEN')->plainTextToken,
            'id' => $id
        ], 200);

    }

    //logga ut användare
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        $response = [
            'message' => 'User logged out'
        ];

        return response($response, 200);
    }
    //skriv ut användare
    public function index(Request $request)
    {
        //Retunera alla användare
        return User::all();
    }
    //användare med id
    public function show($id)
    {

        $User = User::find($id);

        //Kollar om user finns
        if ($User != null) {
            return $User;
        } else {
            //Om user inte finns skriv ut felmeddelande
            return response()->json([
                'User not found'
            ], 404);
        }
    }



}
