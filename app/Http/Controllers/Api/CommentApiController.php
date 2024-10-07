<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;

class CommentApiController extends Controller
{
    // Display a listing of the comments for a specific product
    public function index(Product $product)
    {
        $comments = $product->comments()->with('customer')->get();

        return response()->json([
            'status' => true,
            'message' => __('comment.comments_retrieved_successfully'),
            'data' => $comments,
        ]);
    }

    // Store a newly created comment
    public function store(CommentRequest $request)
    {
        try {
            $comment = Comment::create([
                'product_id' => $request->product_id,
                'customer_id' => Auth::id(),
                'content' => $request->comment,
                'rate' => $request->rate,
            ]);

            $comment->load('customer');

            return response()->json([
                'status' => true,
                'message' => __('comment.comment_added_successfully'),
                'data' => new CommentResource($comment),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('comment.comment_addition_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    // Update the specified comment
    public function update(CommentRequest $request, $productId, $commentId)
    {
        try {
            // Retrieve the comment by its ID and the product it belongs to
            $comment = Comment::where('id', $commentId)->where('product_id', $productId)->first();

            if (!$comment) {
                return response()->json([
                    'status' => false,
                    'message' => __('comment.comment_update_failed', ['error' => 'Comment not found']),
                ], 404);
            }

            // Check if the authenticated user is the owner of the comment
            if ($comment->customer_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => __('comment.comment_update_failed', ['error' => 'Unauthorized']),
                ], 403);
            }

            $comment->update($request->only(['content', 'rate']));

            // Eager load the customer relation
            $comment->load('customer');

            return response()->json([
                'status' => true,
                'message' => __('comment.comment_updated_successfully'),
                'data' => new CommentResource($comment), // Return the resource
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('comment.comment_update_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }


    // Remove the specified comment
    public function destroy($productId, $commentId)
    {
        try {
            // Retrieve the comment by its ID and ensure it belongs to the correct product
            $comment = Comment::where('id', $commentId)
                ->where('product_id', $productId)
                ->first();

            if (!$comment) {
                return response()->json([
                    'status' => false,
                    'message' => __('comment.comment_deletion_failed', ['error' => 'Comment not found']),
                ], 404);
            }

            // Check if the authenticated user is the owner of the comment
            if ($comment->customer_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => __('comment.comment_deletion_failed', ['error' => 'Unauthorized']),
                ], 403);
            }

            // Delete the comment
            $comment->delete();

            return response()->json([
                'status' => true,
                'message' => __('comment.comment_deleted_successfully'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('comment.comment_deletion_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }
}
