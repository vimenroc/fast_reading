<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo base_url('public/css/style.css'); ?>">
    <title>Document</title>
</head>
<body>
    

<div class="row">
    <div  class="col-12 text-center mb-5 mt-5">
        <h2 id="cap">
            Capítulo
        </h2>
    </div>
    <div id="texto" class="col-12 text-center" style="font-size: 3rem; min-height: 12vh;">
    </div>
    <div class="col-12 text-center">
        <button class="btn btn-primary" id= "resume" ><i id="btn-icon" class="fa fa-play"></i></button>
        <button class="btn btn-primary" id= "stop" ><i id="btn-icon" class="fa fa-stop"></i></button>
    </div>
    <div class="col-12">
        <div class="input-group mb-3 p-3">
            <span class="input-group-text" id="basic-addon1">Velocidad</span>
            <input type="number" class="form-control" placeholder="250" min="1" value="250" id="speed">
        </div>
    </div>
</div>
    
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        
        
        
        let texto = "Texto de ejemplo";
        let arr1 = texto.split(' ');
        let running = false;
        let start = 0;
        let speed = 250;
        
        // A $( document ).ready() block.
        $( document ).ready(function() {
            console.log( "ready!" );
            
            
            
            $.ajax({
                url: "http://localhost/fast_reading/books/1",
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $("#resume").prop( "disabled", true )
                },
                success: function(data) {
                    
                    arr1 = data[0].body.split(' ');
                    $("#cap").html(`<i class="fa fa-book"></i> ${data[0].chapter}`);
                    $("#resume").prop( "disabled", false )
                },
                error: function(error) {}
            });
            
            $("#stop").click(function(e){
                e.preventDefault();
                running = false;
                $("#btn-icon").removeClass("fa-pause");
                $("#btn-icon").addClass("fa-play");
                start = 0;
                $("#texto").html("");
                
            });
            
            $("#resume").click(function(e){
                e.preventDefault();
                speed = $("#speed").val();
                if (running == true) {
                    $("#btn-icon").removeClass("fa-pause");
                    $("#btn-icon").addClass("fa-play");
                    running = false;
                }else{
                    running = true;
                    $("#btn-icon").removeClass("fa-play");
                    $("#btn-icon").addClass("fa-pause");
                    demo(speed);
                }
            });
            
        });

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function demo(speed) {
            for (let i = start; i < arr1.length && running; i++) {
                $("#texto").html(arr1[i]);
                start = i;
                await sleep(speed);
            }
        }
        
    </script>


</body>
</html>