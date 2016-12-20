<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">



<style>
    
    #loader{
        background: rgba(0, 0, 0, 0.3) url("loading.gif") no-repeat scroll center center;
        height: 100%;
        width: 100%;
        position: absolute;
        display: none;
    }
    
</style>
<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
    function playandmerge(){

        var vdolist = [];
        $(".videolist").each(function(){
            if($(this).is(':checked')){
                vdolist.push($(this).val());
            }
        }).promise().done( function(){
            if(vdolist.length && typeof($('.audiolist:checked').val()) != 'undefined'){
                $('#loader').show();
                $.post("video.php",{vdolist:vdolist,audio:$('.audiolist:checked').val()},function(res){
                    var resarr = JSON.parse(res);
                    $('#loader').hide();

                    if(resarr.error == 0){

                        $('#myModal').find('#myModalLabel').text('Merged File');
                        $('#myModal').find('#myModalBody').html('<video width="568" controls autoplay><source src="'+resarr.msg+'" type="video/mp4"></video>');

                        $('#myModal').modal('show');


                    }else{
                        alert("Error ocurred! try again.");
                    }

                })
            }
        });
    }

    function play_video(file_name){

        $('#myModal').find('#myModalLabel').text(file_name);
        $('#myModal').find('#myModalBody').html('<video width="568" controls autoplay><source src="video/'+file_name+'" type="video/mp4"></video>');

        $('#myModal').modal('show');
    }

    function play_audio(file_name){

        $('#myModal').find('#myModalLabel').text(file_name);
        $('#myModal').find('#myModalBody').html('<audio controls autoplay><source src="audio/'+file_name+'" type="audio/mpeg"></audio>');

        $('#myModal').modal('show');
    }


    $(function(){
        $('#myModal').on('hidden.bs.modal', function (e) {
            $('#myModal').find('#myModalBody').html('');
        })
    })


</script>

<div id="loader"></div>

<div id="videolist" style="display: block;">

    <h2>Video List</h2>

    <div style="margin-bottom: 15px;">
        <video width="300" controls>
            <source src="video/2.mp4" type="video/mp4">
        </video>
        <br>
        <input type="checkbox" class="videolist" name="videolist[]" value="2.mp4">
        <label>2.mp4</label>
        <!--<input type="button" value="play" onclick="play_video('2.mp4')">-->
    </div>
    <div style="margin-bottom: 15px;">
        <video width="300" controls>
            <source src="video/3.mp4" type="video/mp4">
        </video>
        <br>
        <input type="checkbox" class="videolist" name="videolist[]" value="3.mp4">
        <label>3.mp4</label>
    </div>
    <div style="margin-bottom: 15px;">
        <video width="300" controls>
            <source src="video/4.mp4" type="video/mp4">
        </video>
        <br>
        <input type="checkbox" class="videolist" name="videolist[]" value="4.mp4">
        <label>4.mp4</label>
    </div>
    <div style="margin-bottom: 15px;">
        <video width="300" controls>
            <source src="video/5.mp4" type="video/mp4">
        </video>
        <br>
        <input type="checkbox" class="videolist" name="videolist[]" value="5.mp4">
        <label>5.mp4</label>
    </div>
    <div style="margin-bottom: 15px;">
        <video width="300" controls autoplay>
            <source src="video/6.mp4" type="video/mp4">
        </video>
        <br>
        <input type="checkbox" class="videolist" name="videolist[]" value="6.mp4">
        <label>6.mp4</label>
    </div>
    <div style="margin-bottom: 15px;">
        <video width="300" controls>
            <source src="video/7.mp4" type="video/mp4">
        </video>
        <br>
        <input type="checkbox" class="videolist" name="videolist[]" value="7.mp4">
        <label>7.mp4</label>
    </div>
    <div style="margin-bottom: 15px;">
        <video width="300" controls>
            <source src="video/8.mp4" type="video/mp4">
        </video>
        <br>
        <input type="checkbox" class="videolist" name="videolist[]" value="8.mp4">
        <label>8.mp4</label>
    </div>

    <h2>Audio List</h2>
    <div style="margin-bottom: 15px;">
        <audio controls>
            <source src="audio/1.mp3" type="audio/mpeg">
        </audio>
        <br>
        <input type="radio" class="audiolist" name="audiolist" value="1.mp3">
        <label>1.mp3</label>
<!--        <input type="button" value="play" onclick="play_audio('1.mp3')">-->
    </div>
    <div style="margin-bottom: 15px;">
        <audio controls>
            <source src="audio/2.mp3" type="audio/mpeg">
        </audio>
        <br>
        <input type="radio" class="audiolist" name="audiolist" value="2.mp3">
        <label>2.mp3</label>
    </div>
    <div style="margin-bottom: 15px;">
        <audio controls>
            <source src="audio/3.mp3" type="audio/mpeg">
        </audio>
        <br>
        <input type="radio" class="audiolist" name="audiolist" value="3.mp3">
        <label>3.mp3</label>
    </div>
    <div style="margin-bottom: 15px;">
        <audio controls>
            <source src="audio/4.mp3" type="audio/mpeg">
        </audio>
        <br>
        <input type="radio" class="audiolist" name="audiolist" value="4.mp3">
        <label>4.mp3</label>
    </div>
    <div style="margin-bottom: 15px;">
        <audio controls>
            <source src="audio/5.mp3" type="audio/mpeg">
        </audio>
        <br>
        <input type="radio" class="audiolist" name="audiolist" value="5.mp3">
        <label>5.mp3</label>
    </div>


    <br><br>
    <input type="button" value="merge & play" onclick="playandmerge()">
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body" id="myModalBody" style="text-align: center;">
            </div>
        </div>
    </div>
</div>


