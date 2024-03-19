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

	.indent-2 {
		padding-left: 40px!important;
	}

</style>

<!-- Main content -->
<section class="content" id="app">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<div class="row">

		<div class="col-md-12 title-header">
			<h4 ><b>Balance Sheet</b></h4>
		</div>

		<div class="col-12">
			<div class="col-md-2 col-xs-12">
				<div class="box">
					<div class="form-group">
						<label class="label-normal" for="genLedgerFrom">AS OF</label>
						<div class="input-group">
							<input value="{{ $current_date }}" type="date" class="form-control form-control-sm rounded-0" name="from" >
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row justify-content-start">
		<div class="col-md-8">
		
			<table class="table table-sm border">

				@foreach($balanceSheet['accounts'] as $category => $type)
				<thead>
				<tr>
					<th width="50%">{{ Str::upper($category) }}</th>
					<th width="25%"></th>
					<th width="25%"></th>
				</tr>
				</thead>
				<tbody>
					
					@foreach($type['header'] as $group => $data)
					<tr>
						<td class="indent-1">{{ Str::title($group) }}</td>
						<td></td>
						<td></td>
					</tr>
						@foreach($data['data'] as $key => $value)
						<tr>
							<td class="indent-2">{{ Str::title($value['account_name']) }}</td>
							<td class="text-right">{{ number_format($value['total'], 2) }}</td>
							<td></td>
						</tr>
						@endforeach
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td class="indent-1">Total {{ Str::title($group) }}</td>
							<td></td>
							<td class="text-bold text-right">{{ number_format($data['total'], 2) }}</td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
					@endforeach
					<tr>
						<td class="text-bold">Total {{ Str::title($category) }}</td>
						<td></td>
						<td class="text-bold text-right">{{ number_format($type['total'], 2) }}</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
				</tbody>
				@endforeach
				<thead>
				<tr>
					<th width="50%">{{ $balanceSheet['total_asset']['title'] }}</th>
					<th width="25%"></th>
					<th width="25%" class="text-right">{{ number_format($balanceSheet['total_asset']['value'], 2) }}</th>
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
