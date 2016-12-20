<?php

set_time_limit(0);

if(count($_POST)){
    if(count($_POST['vdolist']) > 1){
        $videolist = $_POST['vdolist'];
        $audio = $_POST['audio'];
        $output_prev = time()."_".rand()."_prev.mp4";
        $output_prev1 = time()."_".rand()."_prev1.mp4";
        $output = time()."_".rand().".mp4";

        $mpglist = '';
        $mpglistarr = array();

        foreach ($videolist as $row){
            $origfilename = $row;
            $info = pathinfo($origfilename);
            $rawname = $info['filename'];

            $mpgfilename = $rawname.".mpg";
            $mpglist .= ' '.$mpgfilename;
            $mpglistarr[] = $mpgfilename;

            exec("/usr/bin/ffmpeg -i video/".$origfilename." -qscale 1 ".$mpgfilename);
        }

        exec("cat ".$mpglist." | /usr/bin/ffmpeg -f mpeg -i - -qscale 1 -vcodec mpeg4 ".$output_prev);

        $x = exec("/usr/bin/ffmpeg -i ".$output_prev." 2>&1 | grep Duration | awk '{print $2}' | tr -d ,");
        $y = exec("/usr/bin/ffmpeg -i audio/".$audio." 2>&1 | grep Duration | awk '{print $2}' | tr -d ,");

        $x_arr = explode(':',$x);
        $y_arr = explode(':',$y);

        if(intval($x_arr[0]) != intval($y_arr[0])){
            if(intval($x_arr[0]) > intval($y_arr[0])){
                $is_video = 1;

                $loop_audio = intval($x_arr[0])/intval($y_arr[0]);
                $loop_audio = intval($loop_audio);
                $loop_audio = $loop_audio+1;

            }else{
                $is_video = 0;
            }
        }else if(intval($x_arr[1]) != intval($y_arr[1])){
            if(intval($x_arr[1]) > intval($y_arr[1])){
                $is_video = 1;

                $loop_audio = intval($x_arr[1])/intval($y_arr[1]);
                $loop_audio = intval($loop_audio);
                $loop_audio = $loop_audio+1;

            }else{
                $is_video = 0;
            }
        }else if(intval($x_arr[2]) != intval($y_arr[2])){
            if(intval($x_arr[2]) > intval($y_arr[2])){
                $is_video = 1;

                $loop_audio = intval($x_arr[2])/intval($y_arr[2]);
                $loop_audio = intval($loop_audio);
                $loop_audio = $loop_audio+1;

            }else{
                $is_video = 0;
            }
        }else if(intval($x_arr[3]) != intval($y_arr[3])){
            if(intval($x_arr[3]) > intval($y_arr[3])){
                $is_video = 1;

                $loop_audio = intval($x_arr[3])/intval($y_arr[3]);
                $loop_audio = intval($loop_audio);
                $loop_audio = $loop_audio+1;

            }else{
                $is_video = 0;
            }
        }else{
            $is_video = 0;
        }

        if($is_video){
            $audio_list = array();

            for($i=0;$i<$loop_audio;$i++){
                $audio_list[] = "audio/".$audio;
            }

            exec("/usr/bin/ffmpeg -i concat:\"".implode('|',$audio_list)."\" -acodec copy looped.mp3");

            exec("/usr/bin/ffmpeg -i ".$output_prev." -i looped.mp3 -shortest -acodec libfaac -ab 96k -vcodec libx264 -vpre slower -vpre main -level 21 -refs 2 -b 345k -bt 345k -threads 0 -s 640x360 ".$output);
        }else{
            exec("/usr/bin/ffmpeg -i ".$output_prev." -i audio/".$audio." -shortest -acodec libfaac -ab 96k -vcodec libx264 -vpre slower -vpre main -level 21 -refs 2 -b 345k -bt 345k -threads 0 -s 640x360 ".$output);
        }


        foreach ($mpglistarr as $row){
            @unlink($row);
        }

        @unlink("looped.mp3");
        @unlink($output_prev);

        echo json_encode(array("error"=>0,"msg"=>$output));


    }else{
        echo json_encode(array("error"=>2));
    }
}else{
    echo json_encode(array("error"=>1));
}

?>
