<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
        ]);

        $address = $request->user()->addresses()->create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Address added successfully.',
                'html' => view('profile.partials.address-card', compact('address'))->render()
            ]);
        }

        return redirect()->back()->with('success', 'Address added successfully.');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Address deleted successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Address deleted successfully.');
    }

    public function setPrimary(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        // Unset primary for all other user addresses
        auth()->user()->addresses()->update(['is_primary' => false]);

        // Set this address as primary
        $address->update(['is_primary' => true]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Primary address updated.',
                'id' => $address->id
            ]);
        }

        return redirect()->back()->with('success', 'Primary address updated.');
    }
}
