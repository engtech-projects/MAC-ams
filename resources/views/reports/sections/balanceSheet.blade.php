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
		
		<div class="col-md-6">
		
			<table id="" class="table table-sm border" >

					<!-- <thead>
						<tr>
							<th width="60%"></th>
							<th width="20%"></th>
							<th width="20%"></th>
						</tr>
					</thead>
 -->
					
						@foreach($balanceSheet as $category => $type)
						<thead>
						<tr>
							<th width="50%">{{ Str::upper($category) }}</th>
							<th width="25%"></th>
							<th width="25%"></th>
						</tr>
						</thead>
						<tbody>
							<?php $total = 0; ?>
							@foreach($type as $group => $data)
							<tr>
								<th class="indent-1">{{ Str::title($group) }}</th>
								<th></th>
								<th></th>
							</tr>
								@foreach($data as $key => $value)
								<?php $total += $value['total'] ?>
								<tr>
									<td class="indent-2">{{ Str::title($value['account_name']) }}</td>
									<td>{{ number_format($value['total'], 2) }}</td>
									<td></td>
								
									
								</tr>
								@endforeach
								<tr>
									<td colspan="3">&nbsp;</td>
								</tr>
								<tr>
									<td class="indent-2">Total {{ Str::title($group) }}</td>
									<td></td>
									<td>{{ number_format($total, 2) }}</td>
								</tr>
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>
							@endforeach
						</tbody>
						@endforeach
					
					
				</table>
		</div>
	
	</div>
  </div>
</section>

@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection
