@extends('layouts.app')

@section('content')

<style type="text/css">

	.title-header{
		margin-bottom:10px;
		padding-bottom:10px;
		border-bottom:2px solid #4ec891;
	}

	.indent-1 {
		padding-left: 20px!important;
	}

	.indent-1-r {
		padding-right: 20px!important;
	}

	.indent-2 {
		padding-left: 40px!important;
	}

	.border-0, .border-0 td  {
		border: 0;
	}

</style>

<!-- Main content -->
<section class="content" id="app">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<div class="row">

		<?php

			// echo '<pre>';
			// var_export($currentEarnings);
			// echo '</pre>';

		?>

		<div class="col-md-12 title-header">
			<h4 ><b>Income Statement</b></h4>
		</div>

		
		<form method="get" id="frm-generate-income-statement" class="col-12">
		@csrf

		<div class="row">
			<div class="col-md-3 col-xs-12">
				<div class="box">
					<div class="form-group">
						<label class="label-normal">From</label>
						<div class="input-group">
							<input type="date" value="{{ $from }}" name="from" class="form-control form-control-sm rounded-0" required>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-12">
				<div class="box">
					<div class="form-group">
						<label class="label-normal">To</label>
						<div class="input-group">
							<input type="date" value="{{ $to }}" name="to" class="form-control form-control-sm rounded-0" required>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-2 col-xs-12">
	            <div class="box pt-4">
					<input type="submit" class="btn btn-success" value="Search">
	            </div>
			</div>
		</div>

		</form>

		
	</div>

	<div class="row justify-content-start">
		<div class="col-md-8">
		
			<table class="table table-sm border">

				@foreach($incomeStatement['accounts'] as $category => $type)
				<thead>
				<tr>
					<th class="indent-1" width="50%">{{ Str::upper($category) }}</th>
					<th width="25%"></th>
					<th width="25%"></th>
				</tr>
				</thead>
				<tbody>
					
					@foreach($type['types'] as $group => $data)
					<tr class="border-0">
						<td class="indent-1">{{ Str::title($data['name']) }}</td>
						<td></td>
						<td></td>
					</tr>
						@foreach($data['accounts'] as $key => $value)
						<tr class="border-0">
							<td class="indent-2">{{ Str::title($value['account_name']) }}</td>
							<td class="text-right">{{ number_format($value['total'], 2) }}</td>
							<td></td>
						</tr>
						@endforeach
					<tr class="border-0">
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr style="border-style: double;">
						<td class="indent-1">Total {{ Str::title($data['name']) }}</td>
						<td></td>
						<td class="text-bold text-right indent-1-r">{{ number_format($data['total'], 2) }}</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					@endforeach
					<tr style="border-style: double;">
						<td class="indent-1 text-bold">Total {{ Str::title($category) }}</td>
						<td></td>
						<td class="text-bold text-right indent-1-r">{{ number_format($type['total'], 2) }}</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
				</tbody>
				@endforeach
				<thead>
				<tr>
					<th class="indent-1" width="50%">{{ $incomeStatement['profit']['title'] }}</th>
					<th width="25%"></th>
					<th width="25%" class="text-right indent-1-r">{{ number_format($incomeStatement['profit']['value'], 2) }}</th>
				</tr>
				<tr>
					<th class="indent-1" width="50%">{{ $incomeStatement['income_tax']['title'] }}</th>
					<th width="25%"></th>
					<th width="25%" class="text-right indent-1-r">{{ number_format($incomeStatement['income_tax']['value'], 2) }}</th>
				</tr>
				<tr><th colspan="3">&nbsp;</th></tr>
				<tr>
					<th class="indent-1" width="50%">{{ $incomeStatement['net_income']['title'] }}</th>
					<th width="25%"></th>
					<th width="25%" class="text-right indent-1-r">{{ number_format($incomeStatement['net_income']['value'], 2) }}</th>
				</tr>
				</thead>
					
				</table>
		</div>
	</div>	
  </div>
</section>

@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection
