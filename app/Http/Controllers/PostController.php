<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createpost(Request $request){
        $incomingField = $request->validate(
            [
                'post_title'=>'required',
                'body'=>'required'


            ]
            );

            $incomingField['title']=strip_tags($incomingField['post_title']);
            $incomingField['body']=strip_tags($incomingField['body']);
            $incomingField['user_id']=auth()->id();
            Post::create($incomingField);
            return redirect('/');

    }
}
