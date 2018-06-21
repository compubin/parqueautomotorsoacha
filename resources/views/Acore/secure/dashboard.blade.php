@extends('layouts.app')


@section('content')
<section class="page-header row">
  <h3> CMS Dashboard <small>  </small></h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li  class="active"> Cms Dashboard </li>
  </ol>
</section>
<div class="page-content row">
    <div class="page-content-wrapper no-margin">
<div class="sbox" >
	<div class="sbox-title"><h3><i class="fa fa-sliders"></i> Summary Registration History </h3></div>
    <div class="sbox-content"  >
	    <div class="row">
    		<div class="col-md-8">
    			<div id="history" style="height: 280px;" ></div>
    		</div>
    		<div class="col-md-4">
    			<div id="pie" style="height: 280px;" ></div>
    		</div>
    	</div>		

    </div>
</div>		    

<div class="row">
	<div class="col-md-6">
		<div class="sbox" >
			<div class="sbox-title"><h3><i class="fa fa-user-circle"></i> Summary Users Activities </h3></div>
		    <div class="sbox-content"  style="height: 180px;" >

				<ul class="list_dashboard">
					<li> Total Users <span class="pull-right label label-success"><b> {{ $users->Total }} </b> users </span></li>
					<li> Active Users <span class="pull-right label label-primary" ><b> {{ $users->Active }} </b> users </span></li>
					<li> Unconfirmed Users <span class="pull-right label label-warning" ><b> {{ $users->Unconfirmed }} </b> users </span></li>
					<li> Suspend/Banned Users <span class="pull-right label label-danger"><b> {{ $users->Banned }} </b> users </span></li>

				</ul>
		    			
				    	
			</div>
		</div>
	</div>
	<div class="col-md-6">

		<div class="sbox" >
			<div class="sbox-title"><h3><i class="fa fa-eye"></i> Last Seen Users </h3></div>
		    <div class="sbox-content" style="height: 180px;" >

				<ul class="list_dashboard">
		    		@foreach($last_activity as $la)
		    		<li> <b>{{ $la->first_name.' '.$la->last_name }} </b> <span class="pull-right">{{  AppHelper::get_time_ago( $la->last_activity ) }} </span></li>
		    		@endforeach

		    	</ul>
		    </div>
	    </div>
	</div>
</div>	    

 
 	<div class="sbox" >
		<div class="sbox-title"><h3><i class="fa fa-text-height"></i> Summary Web Contents  </h3></div>
	    <div class="sbox-content" style="height: 270px;">

	    	<div class="row">
	    		<div class="col-md-6">
	    			<h4> Most View Pages </h4>
	    			<ul class="list_dashboard">
			    		@foreach($dashboard['page_view'] as $pv)
			    		<li> <a href="{{ url($pv->alias)}}" target="_blank"> {{ $pv->title}} <span class="pull-right"><b>{{  $pv->views }} </b> Views </span> </a></li>
			    		@endforeach

			    	</ul>	    			
	    		</div>
	    		<div class="col-md-6">
	    			<h4> Popular Posts </h4>
	    			<ul class="list_dashboard">
			    		@foreach($dashboard['post_view'] as $pv)
			    		<li> <a href="{{ url('posts/'.$pv->alias)}}" target="_blank"> {{ $pv->title}} <span class="pull-right"><b>{{  $pv->views }} </b> Views </span> </a></li>
			    		@endforeach

			    	</ul>	    			
	    		</div>
	    		<div class="col-md-4">
	    		
	    		</div>
	    	</div>

	    </div>
	</div>       

	</div>
</div>
<style type="text/css">
	ul.list_dashboard {
		margin: 0 0 25px 0; padding: 0; list-style: none;
	}
	ul.list_dashboard li{ 
		line-height: 1.7em;

	}
	h4 { 
		font-size: 16px;
		text-shadow: 0 1px 0 #fff;
		font-weight: 600;
		border-bottom: solid 1px #999;
		padding: 2px 0px 10px;
	}

</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
	Highcharts.chart('history', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Registration History'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'registered'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Users',
        data: [<?= $chart->January;?>, <?= $chart->Febuary;?>, <?= $chart->March;?>,<?= $chart->April;?>,<?= $chart->May;?>, <?= $chart->June;?>,<?= $chart->July;?>, <?= $chart->August;?>, <?= $chart->September;?>, <?= $chart->October;?>, <?= $chart->November;?>, <?= $chart->December;?>]
    }]
});

Highcharts.chart('pie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ' Users Status '
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Status',
            colorByPoint: true,
            data: [{
                name: 'Active',
                y: <?= $pie->Active;?>
            }, {
                name: 'InActive',
                y:  <?= $pie->Unconfirmed;?>
               
            }, {
                name: 'Banned',
                y:  <?= $pie->Banned;?>
            }]
        }]
    });
</script>
@stop