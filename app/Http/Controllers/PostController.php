<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //create page
    public function createpage () {
        //$posts = Post::orderby('created_at', 'desc' )->get()->toArray();
        $posts = Post::orderby('created_at', 'desc' )->paginate(4);
        return view('create',compact('posts'));
    }

    //post create
    public function postCreate (Request $request){

        //image upload
        $this->postValidationCheck($request);           //Validation function
        $data = $this->getPostData($request);           //array type

        if($request->hasFile('postImage')){
            $filename = uniqid () . $request->file('postImage')->getClientOriginalName();                //both name and files type
            $request->file('postImage')->storeAs('public',$filename);
            $data['image'] = $filename;     //data photo stroage in database
        }

        Post::create($data);    //final insert data into database with Model::view(var_name function called);
        return redirect( )->route('post#createPage')->with(['insertSuccess'=>'Post လုပ်ဆောင်ခြင်း အောင်မြင်ပါသည်။']);
    }

    //post delete
    public function postDelete($id){
        //first way
        Post::where('id',$id)->delete();
        return redirect( )->route('post#createPage');

        //second way
        //$post = Post::find($id)-> delete();    //only for id
    }


    //post Update
    public function postUpdate($id){
       $post = Post::where('id',$id)->first();
       return view('update',compact('post'));
    }

    //post Edit
    public function postEdit($id){
        $post = Post::where('id',$id)->first();
        return view('edit',compact('post'));
    }


    //edit -> data update
    public function postDataUpdate(Request $request) {

        $this->postValidationCheck($request);            // edit updat data Viladation
        $dataUpdate = $this->getPostData($request);  //array
        $id = $request->postID;

        if($request->hasFile('postImage')){

            //delete old image when we upload new image
            $oldImage =  Post::select('image')->where('id', $request->postID)->first()->toArray();
            $oldImage = $oldImage['image'];

            if($oldImage != null){
                Storage::delete('public/' .$oldImage);          //delete image in storage folder
            }

            //saved new image
            $filename = uniqid () . $request->file('postImage')->getClientOriginalName();                //both name and files type
            $request->file('postImage')->storeAs('public',$filename);
            $dataUpdate['image'] = $filename;     //data photo stroage in database
        }

        Post::where('id',$id)->update($dataUpdate);
        return redirect()->route('post#createPage')->with(['updateSuccess'=>'Update လုပ်ဆောင်ခြင်းအောင်မြင်ပါသည်']);
    }

    // get post data
    //get edit-> data update
    private function getPostData($request){
        $dataInput = [
            'title' => $request->postTitle,
            'description' => $request->postDescription,
        ];

        $dataInput['price'] = $request->postFees == null ? 2000 : $request->postFees;
        $dataInput['address'] = $request->postAddress == null ? 'United States' : $request->postAddress;
        $dataInput['rating'] = $request->postRating == null ? 4 : $request->postRating;

        return $dataInput;

            // 'price' => $request->postFees,
            // 'address'=> $request->postAddress,
            // 'rating'=> $request->postRating,

    }

    //Viladation error check with function call
    private function postValidationCheck($request){

            $validationRules = [
                'postTitle' => 'required|min:5|unique:posts,title,'.$request->postID ,
                'postDescription' => 'required',
                'postImage' => 'mimes:jpg,bmp,png',

                'postFees'=> 'required',
                'postAddress' => 'required',
                'postRating' => 'required',

            ];


        //custom error message
        $validationMessage =[
            'postTitle.required' => 'Post ခေါင်းစဉ်ဖြည့်ရန် လိုအပ်ပါသည်.',
            'postTitle.min'=> 'ကျေးဇူးပြု၍ ၅လုံးနှင့်အထက် ဖြည့်သွင်းပေးပါ့.',
            'postTitle.unique'=> 'Data နာမည်ချင်းထပ်တူနေပါသည်. ထပ်မံအသစ်ဖြည့်သွင်းပေးပါ. ',
            'postDescription.required' => 'Post စာပိုဒ်ဖြည့်ရန် လိုအပ်ပါသည်.',
            'postFees.required' => 'Post Fees လိုအပ်ပါသည်.',
            'postAddress.required' => 'Post Address လိုအပ်ပါသည်.',
            'postRating.required' => 'Post Rating လိုအပ်ပါသည်.',
        ];

        Validator::make($request->all(), $validationRules, $validationMessage)->validate();
    }
}
