<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:comments,id', // Validate if parent_id is provided
        ]);

        Comment::create([
            'product_id' => $request->input('product_id'),
            'user_id' => auth()->id(), 
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id'), 
        ]);

        return redirect()->route('products.show', $request->input('product_id'))
            ->with('success', 'Comment added successfully!');
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment); // Ensure the user is authorized to edit
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified comment in the database.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment); // Ensure the user is authorized to update

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update([
            'content' => $request->input('content'),
        ]);

        return redirect()->route('products.show', $comment->product_id)
            ->with('success', 'Comment updated successfully!');
    }
}
