<?php 

if(!isset($_SESSION['LOGGED'])) {
	echo Config::afterShowInfo('', 'Nu esti logat pe cont!', 'error');
	exit();
}

?>


        <div class="pcoded-wrapper">
        	<div class="box-breadcrump">
                <ul class="breadcrumb">
                    <li class="breadcrumb__item breadcrumb__item-firstChild">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Home</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Shop</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-block">
                                        	<div class="ribbon ribbon-success">+50% more premium points</div>
	                                        	<div class="row">
	                                        		<div class="col-md-12">
	                                        			<div class="col-md-6 offset-md-3">
	                                        				<form action="#"><div class="form-group">
	                                        					<label for="amount">Suma pe care doresti sa o platesti (EUR)</label> 
	                                        					<input type="number" placeholder="Suma in euro" id="amount" class="form-control">
	                                        				</div>
	                                        			</form> 
	                                        			<div class="text-center">
	                                        				<h3 id="you" style="display: none;">You get <b>0</b> premium points for <b>0</b> EUR (~0 RON).</h3> 
	                                        				<h4>Conversie</h4> 
	                                        				<h3>1 EURO = 50 PP</h3> 
	                                        				<div class="col-md-12">
	                                        					<h4>Alege metoda de plata</h4> 
	                                        					<h2 style="display: none;">Loading...</h2> 
	                                        					<div class="row">
	                                        						<div class="col-md-6">
	                                        							<button class="btn btn-block" disabled="disabled">
	                                        								<i class="fa fa-product-hunt"></i> PaySafeCard
	                                        							</button>
	                                        						</div> 
	                                        						<div class="col-md-6">
	                                        							<button class="btn btn-block" disabled="disabled">
	                                        								<i class="fa fa-paypal"></i> Paypal</button>
	                                        						</div>
	                                        					</div> 
	                                            			</div>
	                                            		</div>
	                                            	</div>
	                                            </div>
	                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="<?=Config::$URL?>assets/js/shop.js"></script>