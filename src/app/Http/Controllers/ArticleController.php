<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use App\Models\Article;

class ArticleController extends Controller
{
    public function create(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'description' => 'required',
                'content' => 'required', 
                'user_id' => 'required'
             ],
             [
                 'title.required' => 'Please provide a name for the account',
                 'description.required' => 'Please provide a description',
                 'content.required' => 'Please provide the content',
                 'user_id.required' => 'The owner of the article must be provided'
             ]);

             if($validator->fails()){
                return response()->json([
                    "error" => $validator->errors()
                ], 422);
            }

            $article = Article::create([
                'title' => $request['title'],
                'description' => $request['description'],
                'content' => $request['content'],
                'user_id' => $request['user_id']
            ]);

            return response()->json(['article' => $article ,
            'message' => 'Article created'], 201);

        }
        catch(\Exception $ex)
        {
            return response()->json($ex->getMessage() );
        }
    }

    public function view(int $id)
    {
        try
        {
            $article = Article::with('comments')->where('id', $id)->first();
            if(empty($article)){
                return response()->json([
                    "error" => "This article does not exist"
                ], 404);
            }
            return response()->json(['article' => $article], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json($ex->getMessage() );
        }
    }

    public function update(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'description' => 'required',
                'content' => 'required', 
                'user_id' => 'required'
             ],
             [
                 'title.required' => 'Please provide a name for the account',
                 'description.required' => 'Please provide a description',
                 'content.required' => 'Please provide the content',
                 'user_id.required' => 'The owner of the article must be provided'
             ]);

             if($validator->fails()){
                return response()->json([
                    "error" => $validator->errors()
                ], 422);
            }
            $article_id = $request['id'];
            $user_id = $request['user_id'];

            $article = Article::where('id', $article_id)->where('user_id', $user_id)->first();

            if(empty($article)){
                return response()->json([
                    "error" => "The article does not exist"
                ], 404);
            }

            $article->title = $request['title'];
            $article->description = $request['description'];
            $article->content = $request['content'];
            $article->user_id = $request['user_id'];
            $article->save();

            return response()->json(['article' => $article ,
            'message' => 'Article updated!'], 201);
        }
        catch(\Exception $ex)
        {
            return response()->json($ex->getMessage() );
        }
    }

    public function delete(int $id, $user_id)
    {
        try
        {
            $article_id = $id;
            $user_id = $user_id;

            $article = Article::where('id', $article_id)->where('user_id', $user_id)->first();

            if(empty($article)){
                return response()->json([
                    "error" => "The article does not exist"
                ], 404);
            }

            $article->delete();
            return response()->json(['message' => 'Article deleted!'], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json($ex->getMessage() );
        }
    }
}
