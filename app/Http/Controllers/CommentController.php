<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:500',
        ]);

        // Create a new comment associated with the product and customer
        Comment::create([
            'product_id' => $request->input('product_id'),
            'customer_id' => auth()->user()->id, // Assuming 'customer' is the authenticated user
            'content' => $request->input('content'),
        ]);

        // Redirect back to the product's show page with a success message
        return redirect()->route('products.show', $request->input('product_id'))
                         ->with('success', 'Comment added successfully!');
    }
}
