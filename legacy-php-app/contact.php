<?php include("header.php"); ?> <!-- END header -->

<?php if( !isset($_SESSION["user"]) ) { exit(0); }  ?>

    <section class="site-section">
      <div class="container">
        <div class="row mb-4"> <div class="col-md-6"> <h1>Contact Admin Panel</h1> </div> </div>
        <div class="row blog-entries">
          
          <div class="col-md-12 col-lg-8 main-content">
            <form action="#" method="post">
              <div class="row">
                <div class="col-md-12 form-group">
                  <textarea name="message" id="message" class="form-control " cols="30" rows="8"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <button class="btn btn-dark rounded"> send message </button>
                </div>
              </div>
            </form>
          </div>
          <!-- END main-content -->

          <div class="col-md-12 col-lg-4 sidebar">
            <?php include("searchBox.php"); ?><!-- END sidebar-box -->

            <?php include("profile.php"); ?> <!-- END sidebar-box -->  
            
            <?php include("popularPost.php"); ?> <!-- END sidebar-box -->

            <?php include("tag.php"); ?> <!-- END sidebar-box -->
          </div>
          <!-- END sidebar -->

        </div>
      </div>
    </section>
  
<?php include("footer.php") ?>