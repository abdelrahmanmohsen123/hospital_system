<?php

         function returnApi($success,$message,$data){
             response()->json()([
                'success'=>$success,
                'message'=>$message,
                'data'=>$data
            ]);
        }


?>