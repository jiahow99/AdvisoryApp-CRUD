<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateListingRequest;
use App\Http\Requests\GetListingRequest;
use App\Http\Requests\GetListingsRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Create listing
     */
    public function index($id) 
    {
        // Find user
        $user = User::find($id);

        // User not found
        if (!$user) return response()->json(['message' => 'User not found'], 404);

        // Get user's listings
        $listings = $user->listings()->paginate(10);

        return response()->json($listings);
    }

    /**
     * Create listing
     */
    public function store(CreateListingRequest $request) 
    {
        // Get data from request
        $data = $request->only(['name', 'longitude', 'latitude', 'userId']);

        // Find user
        $user = User::find($data['userId']);

        // Create listing for the user
        if ($user) 
        {
            $user->listings()->create([
                'name' => $data['name'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);
        }
    }

    /**
     * Update listing
     */
    public function update(UpdateListingRequest $request, Listing $listing) 
    {
        // Get data from request
        $data = $request->only(['name','longitude','latitude','userId']);

        // Update listing
        $listing->fill($data);
        // If user changed
        if ($data['userId'] != $listing->user->id)
        {
            $listing->user_id = $data['userId'];
        }
        
        // Save changes
        $listing->save();
    }

    /**
     * Delete listing
     */
    public function destroy(Listing $listing)
    {
        if ($listing) {
            $listing->delete();
        }
    }
}
