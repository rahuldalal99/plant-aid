<?php
	require 'login/header.php';	
?>
<main>
	<!--SLider -->
			<div class="bd-example">
  				<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    					<ol class="carousel-indicators">
      						<li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
      						<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
      						<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    					</ol>		
    					<div class="carousel-inner">
      						<div class="carousel-item active">
        						<img src="images/gesca.jpg" class="d-block w-100" alt="...">
      				 	 		<div class="carousel-caption d-none d-md-block">
          							<h5>Grape Esca</h5>
         							 <p>Common disease in mature grape vines</p>
        						</div>
      						</div>
      						<div class="carousel-item">
        						<img src="images/potato.jpg" class="d-block w-100" alt="...">
        						<div class="carousel-caption d-none d-md-block">
         							 <h5>Potato Blight</h5>
         							 <p>A funges which causes major potato crop destruction</p>
        						</div>
      						</div>
      						<div class="carousel-item">
        						<img src="images/tmold.jpg" class="d-block w-100" alt="...">
        						<div class="carousel-caption d-none d-md-block">
          							<h5>Tomato Leaf Mold</h5>
         							 <p>A disease causing yellow spots on leaves.</p>
        						</div>
      						</div>
    					</div>
    					<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
      						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
      						<span class="sr-only">Previous</span>
    					</a>
    					<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
      						<span class="carousel-control-next-icon" aria-hidden="true"></span>
      						<span class="sr-only">Next</span>
 				   	</a>
 				 </div>
		</div>
		<!-- Main Body -->
			<div class="container">
				<div class="row justify-content-center">
					<h1 id="font">Medivine.ai</h1>
				</div>
				<div class="row justify-content-center">
					<h6><i>Pocket plant disease prediction</i></h6>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 jumbotron box1" style="background-image:url(images/backgroundimg.jpg);background-size:cover;color:white;">
					<h3><i>Towards resolving plant diseases using AI</i></h3>
						<p>Start by uploading an image</p>
						<a class="btn btn-outline-success" href='<?php if(isset($_SESSION['userid'])){
						echo "http://medivine.me:420/upload.php";}
						else{
							echo "http://medivine.me:420/login/login.php";
						}
							?>' 
						role="button">Upload</a>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 jumbotron box1" style="background:none;">
						<h3>About</h3>
						<p>Medivine.ai is a web app which lets you upload images and detect diseases in your plants. Using Medivine.ai farmers, researchers, plant pathologists and even garden enthusiats can not only detect the disease but also obtain quick solutions to cure those disease. </p>					</div>
				</div>
			</div>

<main>


<?php
	require 'login/footer.php';
?>
