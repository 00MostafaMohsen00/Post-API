<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Controllers\API\apiResponseTrait;
use App\Http\Resources\postResource;
use Illuminate\Support\Facades\Validator;

class postController extends Controller
{
    use apiResponseTrait;

    public function index(){
        $posts=postResource::collection(Post::all());
        return  $this->apiResponse($posts,"done",200);
    }

    public function show($id){
        try{
        $post = new postResource(Post::findOrFail($id));

            return  $this->apiResponse($post,"done",200);
        }catch(\Exception $ex){
            return  $this->apiResponse(null,"Post Doesn't Exist . . .",401);
        }
    }

    public function store(Request $request){

        $validator=Validator::make($request->all(),[
            "title"=>"required|max:255",
            "body"=>"required",
        ]);

        if($validator->fails()){

            return $this->apiResponse(null,$validator->errors(),400);

        }

        $post = Post::create([
            "title"=>$request->title,
            "body"=>$request->body,
        ]);

        if($post){
            return $this->apiResponse(new postResource($post),"Post Creted Successfully . . .",201);
        }

        return $this->apiResponse(null,"Post Not Creted  . . .",400);

    }

    public function update(Request $request,$id){

        $validator=Validator::make($request->all(),[
            "title"=>"required|max:255",
            "body"=>"required",
        ]);

        if($validator->fails()){

            return $this->apiResponse(null,$validator->errors(),400);

        }

        try{

            $post=Post::findOrFail($id);

            $post->title=$request->title;
            $post->body=$request->body;
            $post->save();
            return $this->apiResponse(new postResource($post),"Post Updated Successfully . . .",201);

        }catch(\Exception $ex){
            return  $this->apiResponse(null,"Post Doesn't Exist . . .",401);
        }



    }
    public function destroy($id){
        try{

            $post=Post::findOrFail($id);
            $post->delete();
            return $this->apiResponse(new postResource($post),"Post Deleted Successfully . . .",201);

        }catch(\Exception $ex){
            return  $this->apiResponse(null,"Post Doesn't Exist . . .",401);
        }
    }
}
