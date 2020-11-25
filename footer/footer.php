<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-md-3">
        <h5>ABOUT THE CHURCH</h5>
        <p>For the word of God is living and active. Sharper than any double-edged sword, it penetrates even to dividing soul and spirit, joints and marrow; it judges the thoughts and attitudes.</p>
      </div>
      <div class="col-sm-6 col-md-3">
        <h5>QUICK LINKS</h5>
        <ul class="footer-links">
          <li><a href="#">Upcoming events</a></li>
          <li><a href="#">Ministries</a></li>
          <li><a href="#">Recent Sermons</a></li>
          <li><a href="#">Contact us</a></li>
        </ul>
      </div>
      <div class="col-sm-6 col-md-3">
        <h5>OUR ADDRESS</h5>
        <p> Mount Zion Fortress<br>
          Along New Ife Road, Opposite Honors Filling Station <br>
          Adegbayi, Ibadan; Oyo State<br>
          <br>
          Phone: +234 65656565<br>
          Email: <a href="#">lifeandpeace@gmail.com</a></p>
      </div>
      <div class="col-sm-6 col-md-3">
        <h5>CONNECT</h5>
        <div class="social-icons"><a href="#"><img src="images/fb-icon.png" alt="social"></a> <a href="#"><img src="images/tw-icon.png" alt="social"></a> <a href="#"><img src="images/in-icon.png" alt="social"></a></div>
      </div>
    </div>
  </div>
  <div class="copyright">
    <div class="container">
      <p class="text-center">Copyright © - LIFE AND PEACE COMMISSION - 2020. <a data-toggle='tooltip' data-placement="top" title='ADEBAYO OLOYEDE +2349075771869 dynamicsofttechnology@gmail.com'>Developed by D-Soft Tech</a> <br /> All rights reserved</p>
    </div>
  </div>
<!-- Warning Modal before deleting a contact message -->
<div class="modal fade bd-example-modal-lg mt-5" id="logoutModal" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-danger">
                Warning <i class="icon fa pe-7s-attention"></i> 
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-danger">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="position-relative">
                <p>
                    <h6 class="text-center">Are you sure you want to logout?</h6>
                </p>
            </div>
        </div>
        <div class="modal-footer">
            <form method="POST">
              <button class="mr-5 btn btn-success" data-dismiss="modal" style="margin-right: 20px;" >
                  Cancel
              </button>
              <input type="text" id="logoutUsername" name="logoutUsername" value="" hidden required>
              <button type="submit" id="logoutPassword" name="logoutPassword" value="" class="mr-5 btn btn-danger">
                  Yes, Proceed
              </button>
            </form>
        </div>
    </div>
</div>
<!-- Warning Modal before deleting a contact message -->
</footer>
<!-- // END FOOTER --> 
<!-- // END --> 

<!-- Bootstrap core JavaScript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="js/aos/aos.js"></script>
<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>
<script src="assets/fontawesomeForWeb/js/all.js"></script>
<script src="assets/jssocial/jssocials.js"></script>
<script src="js/owl.carousel.min.js"></script> 
<script src="js/ketchup.all.js"></script> 
<script src="js/fancybox.js"></script>
<script src="../assets/forala/js/froala_editor.pkgd.min.js"></script>
<script src="assets/lazyLoader/jquery.lazy.js"></script>
<script type="text/javascript" src="ajax_class.js"></script>

<!--============== SUBSCRIBE FORM =================--> 

<script type="text/javascript">
  
    $(function(){
      var link = 'laravel.com';
      $("#shareNow").jsSocials({
        url: link,
        text: 'just testing',
        showLabel: true,
        showCount: "inside",
        shareIn: "popup",
        shares: ["whatsapp", "facebook", "instagram", "twitter", "email"]
      });
    });
</script>

<script>

  $(function(){
  var shrinkHeader = 300;
    $(window).scroll(function() {
      var scroll = getCurrentScroll();
        if ( scroll >= shrinkHeader ) {
            $('.navbar').addClass('shrink');
          }
          else {
              $('.navbar').removeClass('shrink');
          }
    });
  function getCurrentScroll() {
      return window.pageYOffset || document.documentElement.scrollTop;
      }
  });

</script> 

<!--============== SUBSCRIBE FORM =================--> 

<script>
  $(document).ready(function() {
    $('#subscribeForm').ketchup().submit(function() {
      if ($(this).ketchup('isValid')) {
        var action = $(this).attr('action');
        $.ajax({
          url: action,
          type: 'POST',
          data: {
            email: $('#address').val()
          },
          success: function(data){
            $('#result').php(data);
          },
          error: function() {
            $('#result').php('Sorry, an error occurred.');
          }
        });
      }
      return false;
    });

  });

  $(document).ready(function (){

    // $('.flash_msg').delay(250).fadeOut('slow');

    $('.logOut').click(function (){
        var userU = $(this).attr("id");
        var userP = $(this).attr("name");

        $('#logoutUsername').attr("value", userU);
        $('#logoutPassword').attr("value", userP);

        $('#logoutModal').modal('show');

        // $('#logoutPassword').click(function (){
        //   var u =  $('#logoutUsername').attr("value");
        //   var p = $(this).attr("value");
        //   alert(p);
        // });
    });
  });
</script>

<script>
  $('[data-toggle="tooltip"]').tooltip({boundary: 'window'});
</script>

<script>
  $(document).ready(function() {
    $('img.lazy').lazy({
      threshold: 100,
      effect: 'fadeIn'
    });
  });
</script>