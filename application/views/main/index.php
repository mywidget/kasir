<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
	</div>
	
    <div class="row mb-3">
		
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 ">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Order Total </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 load-count">0</div>
						</div>
                        <div class="col-auto" data-toggle='tooltip' title="Transaksi Baru [CTRL+O]">
							<a href="#" data-toggle="modal" data-target="#OpenCart-1" id="cart"><i class="fas fa-fw fa-cart-plus fa-2x mdlFire"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Order Hari ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 load-now">0</div>
						</div>
                        <div class="col-auto">
							<a href="#" data-toggle="modal" data-target="#OpenTrx-1" data-id="0">
							<i class="fas fa-shopping-cart fa-2x text-success"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Order Baru</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 load-baru">0</div>
						</div>
                        <div class="col-auto">
							<a href="#" data-toggle="modal" data-target="#OpenTrx-1" data-id="baru">
							<i class="fas fa-shopping-cart fa-2x text-info"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Order Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 load-pending">0</div>
						</div>
                        <div class="col-auto">
							<a href="#" data-toggle="modal" data-target="#OpenTrx-1" data-id="pending">
							<i class="fas fa-shopping-cart fa-2x text-warning"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Order Batal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 load-batal">0</div>
						</div>
                        <div class="col-auto">
							<a href="#" data-toggle="modal" data-target="#OpenTrx-1" data-id="batal">
							<i class="fas fa-shopping-cart fa-2x text-danger"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Konsumen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 load-konsumen">0</div>
						</div>
                        <div class="col-auto">
							<a href="#" data-toggle="modal" data-target="#OpenKon" data-id="1">
								<i class="fas fa-user-plus fa-2x text-primary"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!--Row-->
	<!-- Card Start --
  <div class="card">
    <div class="row ">

      <div class="col-md-7 px-3">
        <div class="card-block px-6">
          <h4 class="card-title">Horizontal Card with Carousel - Bootstrap 4 </h4>
          <p class="card-text">
            The Carousel code can be replaced with an img src, no problem. The added CSS brings shadow to the card and some adjustments to the prev/next buttons and the indicators is rounded now. As in Bootstrap 3
          </p>
          <p class="card-text">Made for usage, commonly searched for. Fork, like and use it. Just move the carousel div above the col containing the text for left alignment of images</p>
          <br>
          <a href="#" class="mt-auto btn btn-primary  ">Read More</a>
        </div>
      </div>
      <!-- Carousel start --
      <div class="col-md-5">
        <div id="CarouselTest" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#CarouselTest" data-slide-to="0" class="active"></li>
            <li data-target="#CarouselTest" data-slide-to="1"></li>
            <li data-target="#CarouselTest" data-slide-to="2"></li>

          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block" src="https://picsum.photos/450/300?image=1072" alt="">
            </div>
            <div class="carousel-item">
              <img class="d-block" src="https://picsum.photos/450/300?image=855" alt="">
            </div>
            <div class="carousel-item">
              <img class="d-block" src="https://picsum.photos/450/300?image=355" alt="">
            </div>
            <a class="carousel-control-prev" href="#CarouselTest" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
            <a class="carousel-control-next" href="#CarouselTest" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
          </div>
        </div>
      </div>
      <!-- End of carousel --
    </div>
  </div-->
</div>
<style>
	.title {
	
    margin-bottom: 50px;
    text-transform: uppercase;
	}
	
	.card-block {
    font-size: 1em;
    position: relative;
    margin: 0;
    padding: 1em;
    border: none;
    border-top: 1px solid rgba(34, 36, 38, .1);
    box-shadow: none;
	
	}
	.card {
    font-size: 1em;
    overflow: hidden;
    padding: 5;
    border: none;
    border-radius: .28571429rem;
    box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
    margin-top:20px;
	}
	
	.carousel-indicators li {
    border-radius: 12px;
    width: 12px;
    height: 12px;
    background-color: #404040;
	}
	.carousel-indicators li {
    border-radius: 12px;
    width: 12px;
    height: 12px;
    background-color: #404040;
	}
	.carousel-indicators .active {
    background-color: white;
    max-width: 12px;
    margin: 0 3px;
    height: 12px;
	}
	.carousel-control-prev-icon {
	background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
	}
	
	.carousel-control-next-icon {
	background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
	}
	lex-direction: column;
	}
	
	.btn {
	margin-top: auto;
	}
</style>
<script>
$(document).ready(function() {
	loadcount();baru();pending();konsumen();hari_ini();batal();
	
});

function loadcount(){
	$.ajax({
		url:  base_url+"penjualan/totaltrx",
		cache: false,
		success: function (data) {
            $('.load-count').html(data);
		}
	});
}
function hari_ini(){
	$.ajax({
		url:  base_url+"penjualan/hari_ini",
		cache: false,
		success: function (data) {
            $('.load-now').html(data);
		}
	});
}
function baru(){
	$.ajax({
		url:  base_url+"penjualan/baru",
		cache: false,
		success: function (data) {
            $('.load-baru').html(data);
		}
	});
}
function pending(){
	$.ajax({
		url:  base_url+"penjualan/pending",
		cache: false,
		success: function (data) {
            $('.load-pending').html(data);
		}
	});
}
function batal(){
	$.ajax({
		url:  base_url+"penjualan/batal",
		cache: false,
		success: function (data) {
            $('.load-batal').html(data);
		}
	});
}
function konsumen(){
	$.ajax({
		url:  base_url+"penjualan/konsumen",
		cache: false,
		success: function (data) {
            $('.load-konsumen').html(data);
		}
	});
}
</script>