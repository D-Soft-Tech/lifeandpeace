<style>
    .disabled{
        cursor: not-allowed;
        color: currentColor;
        opacity: 0.5;
        text-decoration: none;
    }
</style>

    <?php

        function disable_link($address)
        {
            if(isset($_SESSION['username']) AND isset($_SESSION['password'])){
                echo $address;
            }
            else{
                echo '';
            }
        }

        function disable_class(){
            if(isset($_SESSION['username']) AND isset($_SESSION['password'])){
                echo "";
            }
            else{
                echo "disabled";
            }
        }
    ?>


<!-- The following code snippets will help to check if a user has signed in before wanting to view this page -->
<?php
    include_once '../php/db.php';

    $conn = get_DB();
    session_start();

    if(isset($_SESSION['username']) AND isset($_SESSION['password'])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];

        $sql = "
                    SELECT admin_user, admin_password FROM admin WHERE admin_user = :username AND admin_password = :password
                ";

        $check = $conn->prepare($sql);
        $check->bindParam(':username', $username);
        $check->bindParam(':password', $password);

        $check = $check->execute();

        if($check === true){
        ?>
            <!-- the main page starts from here -->

        

            <!-- the main page ends here -->
            <script>
                var forala = new FroalaEditor('textarea');
            </script>
        <?php
        }
        else{
            header("Location: index.php");
        }
    }
    else{
            header("Location: index.php");
    }
?>

<!-- Ajax Object builder -->
<script type="text/javascript" src="../ajax_class.js"></script>
<script type="text/javascript">
    function content(address)
    {
        XmlHttp
        (
            {
                url: 'repost.php',
                type: 'POST',
                data: "address="+address,
                complete:function(xhr,response,status)
                {   if (address === response)
                    {
                        document.getElementById('maincontent').innerHTML = "<?php include_once 'test.php'; ?>";
                    }
                    else{ document.getElementById('maincontent').innerHTML = '<?php echo "all is well"; ?>';}
                }
            }
        );
    }
</script>


<!-- Our team that has image upload with preview, i have not implemented the preview functionality -->

<!-- Our Team -->

<!-- Header -->
<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="card mb-3 alert bg-premium-dark">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="fsize-2 font-weight-bold">TEAM</h4>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-transition btn-outline-info btn-sm">
                                Add Team Memeber
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4"></div>
</div>
<!-- List of Each of the Team members -->
<div class="row">
    <div class="col-xs-12 col-md-3">
        <div class="col-xs-12 col-md-1">
            <!-- empty -->
        </div>
        <div class="main-card mb-3 card">
            <div class="card-header pl-0 pr-0 image-top justify-content-center" style="height: 250px;">
                <img src="assets/images/avatars/team.jpg" alt="" class="image-responsive" style="height: 250px;">
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    Pastor Isaac
                </h5>
                Descipleship Coordinator
            </div>
            <div class="card-footer">
                Facebook / Tweeter
                <button class="btn btn-warning btn-sm ml-auto mr-2">Edit</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-3">
        <div class="main-card mb-3 card">
            <div class="card-header pl-0 pr-0 image-top justify-content-center" style="height: 250px;">
                <img src="assets/images/avatars/team.jpg" alt="" class="image-responsive" style="height: 250px;">
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    Pastor Isaac
                </h5>
                Descipleship Coordinator
            </div>
            <div class="card-footer">
                Facebook / Tweeter
                <button class="btn btn-warning btn-sm ml-auto mr-2">Edit</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-3">
        <div class="main-card mb-3 card">
            <div class="card-header pl-0 pr-0 image-top justify-content-center" style="height: 250px;">
                <img src="assets/images/avatars/team.jpg" alt="" class="image-responsive" style="height: 250px;">
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    Pastor Isaac
                </h5>
                Descipleship Coordinator
            </div>
            <div class="card-footer">
                Facebook / Tweeter
                <button class="btn btn-warning btn-sm ml-auto mr-2">Edit</button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-2">
        <!-- empty -->
    </div>
</div>



<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="card mb-2 widget-content bg-premium-dark">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left shadow">
                    <div class="widget-heading"><h5 class="font-weight-bold">OUR TEAM</h5></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4"></div>
</div>

<div class="col-xs-12 col-md-8 mb-3">
        <div class=" main-card card">
            <div class="card-body shadow">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="title">Name</label>
                            <input type="text" class="form-control" id="title">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="volume">Role</label>
                            <input type="text" class="form-control" name="volume" id="volume">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="facebook">Facebook Link</label>
                            <input type="text" class="form-control" name="facebook" id="facebook">
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="tweeter">Tweeter Link</label>
                            <input type="text" class="form-control" name="tweeter" id="tweeter" Placeholder="(optional)">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="book">
                                Choose file
                            </label>
                            <input type="file" class="form-control" id="book" name="book_pdf">
                        </div>
                        <div class="form-group mb-4 col-md-7" style="height: 150px;">
                            <div class="form-row">
                                <div class="col-12 pl-5">
                                    Preview:
                                </div>
                                <div class="col-12">
                                    <img src="assets/images/avatars/team.jpg" alt="" class="image-responsive pl-5" style="height: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary block btm-sm btn-block mt-1">Save</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
    </div>



    <!DOCTYPE html>
<html>
  <body>
    <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
    <div id="player"></div>

    <script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '390',
          width: '640',
          videoId: 'M7lc1UVf-VE',
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }
    </script>
  </body>

  church template location icon
  <span class="glyphicon glyphicon-map-marker"></span> Melbourne</div>

  
  <div class="text-center has-margin-xs-top"><a class="btn btn-primary btn-lg" href="#" role="button">Join event →</a></div>

</html>


var player;
function onYouTubeIframeAPIReady() {
  player = new YT.Player('player', {
    height: '390',
    width: '640',
    videoId: 'M7lc1UVf-VE',
    events: {
      'onReady': onPlayerReady,
      'onStateChange': onPlayerStateChange
    }
  });
}

$date = '2012/09/26';
 echo date('l jS \of F Y', strtotime($date));
 // Wednesday 26th of September 2012


 sk_test_a1812da9fb6d89298dd8899fdee290eddb66134b   (Test Secrete Key)

 pk_test_e1de14e19e0aee0cd1169fbe1a5d52de0c3d633a  (Test Public Key)




clear db info 
Everything all together is this:
mysql://b39783f939332b:174e1286@us-cdbr-east-02.cleardb.com/heroku_be5ce62eb396741?reconnect=true

<!-- Each of my heroku database details are as follows-->
hostname: us-cdbr-east-02.cleardb.com

databasename:  heroku_be5ce62eb396741

username: b39783f939332b

password: 021533dc36bd794

$host = "us-cdbr-east-02.cleardb.com";
$user = "b39783f939332b";
$password = "021533dc36bd794";
$db_name = "heroku_be5ce62eb396741";


port: this is always 3306

mysql -hus-cdbr-east-02.cleardb.com -ub39783f939332b -p heroku_be5ce62eb396741 < C:\Users\Dell\Desktop\newSql.sql


https://youtu.be/EbaKNvWeHMg

https://youtu.be/EbaKNvWeHMg



<style>
                @media (max-width:300px) {
                    #height {
                        height: 200px;
                    }
                    .image-responsive{
                        height: 200px;
                    }
                }
                @media (max-width: 500px){
                    .image-responsive{
                        height: 150px;
                        width: 100px;
                    }
                    #height{
                        height: 150px;
                        width: 250px;
                    }
                }
                @media (min-width: 550px){
                    #height{
                        max-height: 200px;
                    }
                }

                #pay a{
                    width: 30%; 
                    background-color: white; 
                    border: 2px solid #449D44;
                }
                #pay a:hover{
                    background-color: #DFF0D8;
                }
            </style>



    my google map api key

AIzaSyCQnBM0iTEtxw9NbUZbLifn96sv5RCgCAY

inline locale_get_display_language
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQnBM0iTEtxw9NbUZbLifn96sv5RCgCAY&callback=initMap">
</script>

map = new google.maps.Map(document.getElementById('map'), {
  center: {lat: -34.397, lng: 150.644},
  zoom: 8
});

// strip tags to avoid breaking any html
$string = strip_tags($string);
if (strlen($string) > 500) {

    // truncate string
    $stringCut = substr($string, 0, 500);
    $endPoint = strrpos($stringCut, ' ');

    //if the string doesn't contain any space then it will cut without word basis.
    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    $string .= '... <a href="/this/story">Read More</a>';
}
echo $string;

live secrete key
sk_live_c3753e84039d5fdf192e441f2ec8ddec9c484c3c

live public key 
pk_live_27f73c513a75dc7ce769291d0a0e4588b411ab34

test secrete key
sk_test_a1812da9fb6d89298dd8899fdee290eddb66134b

test public key
pk_test_e1de14e19e0aee0cd1169fbe1a5d52de0c3d633a



<form >
  <script src="https://js.paystack.co/v1/inline.js"></script>
  <button type="button" onclick="payWithPaystack()"> Pay </button> 
</form>
 
<script>
  function payWithPaystack(){
    var handler = PaystackPop.setup({
      key: 'pk_test_86d32aa1nV4l1da7120ce530f0b221c3cb97cbcc',
      email: 'customer@email.com',
      amount: 10000,
      currency: "NGN",
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      metadata: {
         custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: "+2348012345678"
            }
         ]
      },
      callback: function(response){
          alert('success. transaction ref is ' + response.reference);
      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>



<form action="/process" method="POST" >
  <script
    src="https://js.paystack.co/v1/inline.js" 
    data-key="pk_test_221221122121"
    data-email="customer@email.com"
    data-amount="10000"
    data-ref=<UNIQUE TRANSACTION REFERENCE>
  >
  </script>
</form>


$query = "SELECT * 
          FROM books
          WHERE title LIKE CONCAT( '%', :title, '%')";
...
...
statement->bindValue(':title', $title, PDO::PARAM_STR);