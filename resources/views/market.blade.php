@extends('layouts.app')

@section('navbarlink')
<ul class="navbar-nav mr-auto">
    <li class="nav-item"><a class="nav-link" href="{{route('instant')}}">Tukar Instan</a></li>
    <li class="nav-item active"><a class="nav-link" href="{{url('/market/IDR/BTC')}}">Market</a></li>
    <li class="nav-item" ><a class="nav-link" href="{{route('balance')}}">Balance</a></li>
    <li class="nav-item" ><a class="nav-link" href="{{route('profil')}}">Profil</a></li>
</ul>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row" style="margin-top: 55px;">
		<!-- list market area -->
		<div class="col-lg-4">
			<!-- maket nav -->
			<div class="no-padding">
				<ul class="nav nav-tabs navbar-dark bg-dark" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" href="{{url('/market/IDR/BTC')}}">
							<h4>IDR</h4>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{url('/market/BTC/ETH')}}">
							<h4>BTC</h4>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{url('/market/ETC/BTC')}}">
							<h4>ETC</h4>
						</a>
					</li>
				</ul>
			</div>
			<!-- end market nav -->
			<table class="table table-dark table-hover no-padding table-striped" style="margin:0px;">
				<thead>
					<tr>
						<td>Kode</td>
						<td>Harga</td>
						<td>Volume</td>
						<td>Change</td>
					</tr>
				</thead>
				<tbody>
					@foreach($price as $key => $p)
						<tr>
							<td>
								@if($key == $to)
									<a class="active" href="/market/{{$from.'/'.$key}}">{{$key}}</a>
								@else
									<a class="" href="/market/{{$from.'/'.$key}}">{{$key}}</a>
								@endif
							</td>
							<td>
								{{number_format($p[$from]['PRICE'], 2, ".", "")}}
							</td>
							<td>
								{{number_format($p[$from]['TOTALVOLUME24H'], 2, ".", "")}}
							</td>
							<td>
								{{number_format($p[$from]['CHANGEPCT24HOUR'], 2, ".", "")}}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<!-- end list market area -->

		<!-- chart etc -->
		<div class="col-lg-8">
			<div class="container-fluid">
				<!-- chart -->
				<div class="row">
					<div class="col-lg-12">
						<div id="chartContainer" style="width: 100%; height: 300px;"></div>
					</div>
				</div>
				<!-- end chart -->

				<!-- buy and sell crypto -->
				<div class="row" style="margin-top: 25px;">
					<!-- buy crypto -->
					<div class="col-lg-6">
						<div class="contentpanel no-padding">

							<ul class="nav nav-tabs navbar-dark bg-dark" role="tablist">
								<li class="nav-item">
									
									<h4>{{"Buy ".$to}}</h4>
									
								</li>
							</ul>
							<div class="tab-content clearfix tab-content-dark">
								<div class="tab-pane active" id="deposit" >
									<form method="POST" action="{{url('/market/buy')}}">
										{{csrf_field()}}
										<div class="form-group row">
										    <label class="col-sm-4 col-form-label">
										    	Total {{$from}}
										    </label>
										    <div class="col-sm-8">
										      	<input onchange="onBuyChanged()" id="jumlahbeli" type="text" placeholder="Jumlah {{$from}}" name="amount">
										    </div>
										</div>

										<div class="form-group row">
										    <label class="col-sm-4 col-form-label">
										    	Harga
										    </label>
										    <div class ="col-sm-8">
										      	<input id="hargabeli" type="text" name="rate" value="{{$price[$to][$from]['PRICE']}}">
										    </div>
										</div>

										<div class="form-group row">
										    <label class="col-sm-4 col-form-label">
										    	Biaya
										    </label>
										    <div class="col-sm-8">
										      	<input id="biayabeli" readonly="" value="" name="cost">
										    </div>
										</div>

										<div class="form-group row">
										    <label class="col-sm-4 col-form-label">
										    	Estimasi
										    </label>
										    <div class="col-sm-8">
										      	<input id="estimasibeli" readonly="" value="">
										    </div>
										</div>
										<div class="form-group row">
											<div class="col-lg-2"></div>
											<input class="btn btn-success col-lg-8" type="submit" value="Buy">
												
											
											<input type="hidden" name="from_curr" value="{{$from}}">
											<input type="hidden" name="to_curr" value="{{$to}}">
											<div class="col-lg-2"></div>
										</div>
									</form>
								</div>
							</div>

						</div>
					</div>
					<!-- end buy crypto -->

					<!-- sell crypto -->
					<div class="col-lg-6">
						<div class="contentpanel no-padding">

							<ul class="nav nav-tabs navbar-dark bg-dark" role="tablist">
								<li class="nav-item">
									
									<h4>{{"Jual ".$to}}</h4>
									
								</li>
							</ul>
							<div class="tab-content clearfix tab-content-dark">
								<div class="tab-pane active" id="deposit" >
									<form method="POST" action="{{url('/market/sell')}}">
										{{csrf_field()}}
										<div class="form-group row">
										    <label class="col-sm-4 col-form-label">
										    	Total {{$to}}
										    </label>
										    <div class="col-sm-8">
										      	<input onchange="onSellChanged()" id="jumlahjual" type="text" placeholder="Jumlah {{$to}}" name="amount">
										    </div>
										</div>

										<div class="form-group row">
										    <label class="col-sm-4 col-form-label">
										    	Harga
										    </label>
										    <div class="col-sm-8">
										      	<input id="hargajual" type="text" value="{{$price[$to][$from]['PRICE']}}" name="rate">
										    </div>
										</div>

										<div class="form-group row">
										    <label class="col-sm-4 col-form-label">
										    	Biaya
										    </label>
										    <div class="col-sm-8">
										      	<input id="biayajual" readonly="" value="">
										    </div>
										</div>

										<div class="form-group row">
										    <label class="col-sm-4 col-form-label">
										    	Estimasi
										    </label>
										    <div class="col-sm-8">
										      	<input id="estimasijual" readonly="" value="">
										    </div>
										</div>

										<div class="form-group row">
											<div class="col-lg-2"></div>
											<input class="btn btn-success col-lg-8" type="submit" value="sell">
												
											<input type="hidden" name="from_curr" value="{{$from}}">
											<input type="hidden" name="to_curr" value="{{$to}}">
											<div class="col-lg-2"></div>
										</div>
									</form>
								</div>
							</div>

						</div>
					</div>
					<!-- end sell crypto -->
				</div>
				<!-- end buy and sell crypto -->

				<!-- order records -->
				<div class="row" style="margin-top: 25px;">
				<!-- order buy crypto -->
					<div class="col-lg-6">
						<div class="contentpanel no-padding" style="overflow-y:auto; height: 100px">

							<ul class="nav nav-tabs navbar-dark bg-dark" style ="position: static;" role="tablist">
								<li class="nav-item">
									
									<h4>Order Buy</h4>
									
								</li>
							</ul>
							
							<div class="tab-content clearfix tab-content-dark">
								<div class="tab-pane active" id="deposit">
									<table class="table table-dark table-hover no-padding table-striped">
										<thead>
											<tr>
												<td>
													Kode
												</td>
												<td>
													Jumlah {{$from}}
												</td>
												<td>
													Jumlah {{$to}}
												</td>
												<td>
													Bid
												</td>
											</tr>
										</thead>
										<tbody>

											@foreach($buygroup as $bg)
												<tr>
													<td>
														{{$bg->to_curr}}
													</td>
													<td>
														{{
															round($bg->total, 8)
														}}
													</td>
													<td>
														{{
															number_format( round(floatval($bg->total)/floatval($bg->rate), 8), 8, ".", "")
														}}
													</td>
													<td>
														{{
															round($bg->rate, 8)
														}}
													</td>
												</tr>
											@endforeach

											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- end order buy crypto -->

					<!-- order sell crypto -->
					<div class="col-lg-6">
						<div class="contentpanel no-padding" style="overflow-y:auto; height: 100px">

							<ul class="nav nav-tabs navbar-dark bg-dark" style ="position: static;" role="tablist">
								<li class="nav-item">
									
									<h4>Order Sell</h4>
									
								</li>
							</ul>
							
							<div class="tab-content clearfix tab-content-dark">
								<div class="tab-pane active" id="deposit">
									<table class="table table-dark table-hover no-padding table-striped">
										<thead>
											<tr>
												<td>
													Kode
												</td>
												<td>
													Jumlah {{$to}}
												</td>
												<td>
													Jumlah {{$from}}
												</td>
												<td>
													Bid
												</td>
											</tr>
										</thead>
										<tbody>
											@foreach($sellgroup as $sg)
												<tr>
													<td>
														{{$sg->to_curr}}
													</td>
													<td>
														{{
															round($sg->total, 8)
														}}
													</td>
													<td>
														{{
															round(floatval($sg->total)*floatval($sg->rate), 8)
														}}
													</td>
													<td>
														{{
															round($sg->rate, 8)
														}}
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- end order sell crypto -->
				</div>
				<!-- end order records -->

				<!-- current order -->
				<div class="row" style="margin-top: 25px;">
					<div class="col-lg-12">
					<div class="contentpanel no-padding" style="overflow-y:auto; height: 100px">
						<ul class="nav nav-tabs navbar-dark bg-dark" style ="position: static;" role="tablist">
							<li class="nav-item">
								<h4>Your Order</h4>
							</li>
						</ul>
							
						<div class="tab-content clearfix tab-content-dark">
							<div class="tab-pane active" id="deposit">
								<table class="table table-dark table-hover no-padding table-striped">
									<thead>
										<tr>
											<td>
												Tanggal waktu
											</td>
											<td>
												Type
											</td>
											<td>
												Harga
											</td>
											<td>
												Sum
											</td>
										</tr>
									</thead>
									<tbody>
										@foreach($orders as $order)
											<tr>
												<td>
													{{$order->updated_at}}
												</td>
												<td>
													{{$order->type}}
												</td>
												<td>
													{{$order->rate}}
												</td>
												<td>
													{{$order->amount}}
												</td>
											</tr>
										@endforeach
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
				</div>
				<!-- end current order -->

				<!-- history  -->
				<!-- <div class="row" style="margin-top: 25px;">
					<div class="col-lg-12">
					<div class="contentpanel no-padding" style="overflow-y:auto; height: 100px">
						<ul class="nav nav-tabs navbar-dark bg-dark" style ="position: static;" role="tablist">
							<li class="nav-item">
								<h4>History</h4>
							</li>
						</ul>
							
						<div class="tab-content clearfix tab-content-dark">
							<div class="tab-pane active" id="deposit">
								<table class="table table-dark table-hover no-padding table-striped">
									<thead>
										<tr>
											<td>
												Tanggal
											</td>
											<td>
												Waktu
											</td>
											<td>
												Type
											</td>
											<td>
												Harga
											</td>
											<td>
												BTC
											</td>
											<td>
												Sum
											</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												Tanggal
											</td>
											<td>
												Waktu
											</td>
											<td>
												Type
											</td>
											<td>
												Harga
											</td>
											<td>
												BTC
											</td>
											<td>
												Sum
											</td>
										</tr>
										<tr>
											<td>
												Tanggal
											</td>
											<td>
												Waktu
											</td>
											<td>
												Type
											</td>
											<td>
												Harga
											</td>
											<td>
												BTC
											</td>
											<td>
												Sum
											</td>
										</tr>
										<tr>
											<td>
												Tanggal
											</td>
											<td>
												Waktu
											</td>
											<td>
												Type
											</td>
											<td>
												Harga
											</td>
											<td>
												BTC
											</td>
											<td>
												Sum
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
				</div> -->
				<!-- end history -->
			</div>
		</div>
		<!-- end chart, etc -->
	</div>
</div>
<script src="{{ asset('js/market.js') }}"></script>
<script type="text/javascript">

window.onload = function () {

	var datajson = {!! $histo !!};
	var dataPoints = [];
	for (var i = 0; i < datajson.length; i++){
		var obj = datajson[i];
		dataPoints.push({
						x: new Date(
							parseInt(obj['time']*1000)
						),
						y: [
							parseFloat(obj['open']),
							parseFloat(obj['high']),
							parseFloat(obj['low']),
							parseFloat(obj['close'])
						]
		});
	}
	var from_curr =  '{!! $from !!}';
	var prefix ='';
	if(from_curr =='IDR'){
		prefix = 'RP';
	}
	else{
		prefix = from_curr;
	}
	var chart = new CanvasJS.Chart("chartContainer", {

		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		exportEnabled: true,
		title: {
				text: "Chart " + "{!! $from !!}" + " to " + "{!! $to !!}"
		},
		subtitles: [{
				text: "Day"
		}],
		axisX: {
				interval: 1,
				valueFormatString: "MMM"
		},
		axisY: {
				includeZero: false,
				prefix: prefix,
				title: "Price"
		},
		toolTip: {
				content: "Date: {x}<br /><strong>Price:</strong><br />Open: {y[0]}, Close: {y[3]}<br />High: {y[1]}, Low: {y[2]}"
		},
		data: [{
				type: "candlestick",
				yValueFormatString: "$##0.00",
				dataPoints: dataPoints
		}]
	});

}

	
</script>
@endsection