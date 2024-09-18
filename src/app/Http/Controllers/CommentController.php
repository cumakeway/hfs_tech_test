<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'article_id' => 'required',
                'user_id' => 'required',
                'body' => 'required', 
             ],
             [
                 'article_id.required' => 'Please provide the article',
                 'user_id.required' => 'Please provide the user leaving the comment',
                 'body.required' => 'Please provide the body of the comment'
             ]);

             if($validator->fails()){
                return response()->json([
                    "error" => $validator->errors()
                ], 422);
            }

            $comment = new Comment();
            $comment->article_id = $request['article_id'];
            $comment->user_id = $request['user_id'];
            $comment->body = $request['body'];
            $comment->parent_id = $request->has(['parent_id']) ? $request['parent_id'] : "";
            $comment->save();

            return response()->json(['comment' => $comment ,
            'message' => 'Comment submitted!'], 201);

        }
        catch(\Exception $ex)
        {
            return response()->json($ex->getMessage() );
        }
    }
}
