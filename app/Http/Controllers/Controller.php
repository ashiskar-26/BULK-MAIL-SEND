<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function send_mail(){
        $userData = DB::table('user')->get();
        $userCount = DB::table('user')->count();

        // AT a time 250 emails send.
        $each = 250;

        // To reduce load in server pause after each response.
        $pause = 1;
         
        for($i=0; $i<$userCount; $i+=$each){
            foreach($userData as $ud){
                $name = $ud->name;
                $email = $ud->email;

                $data=['name'=>$name,'data'=>"Hello " .$name."!"];
                $user['to']=$email;
                Mail::send('mail',$data,function($message) use ($user){
                    $message->to($user['to']);
                    $message->subject('My Subscription');
                });

            }
            echo "send";

            // After 250 mail send atonce, Sleep server to reduse load.
            sleep($pause);

        }
      
        
    }
}
