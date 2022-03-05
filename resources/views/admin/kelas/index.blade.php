<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Kelas - Admin</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		@include('admin/loadcss')

		<!-- inline styles related to this page -->
		
	</head>

	<body class="no-skin">
		@include('admin/header')

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			@include('admin/sidebar')

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="{{route('adminhome')}}">Home</a>
							</li>
							<li>
								<a href="{{route('kelas')}}">Kelas</a>
							</li>
						</ul><!-- /.breadcrumb -->
					</div>

					

					<div class="page-content">
						<div class="page-header">
							<h4>
								Kelas
								<a style="float: right; margin-left: 10px" href="{{route('import.wali.kelas')}}" class="btn btn-xs btn-success">
									Import Wali Kelas 
								</a>
								<a style="float: right; margin-left: 10px" href="{{route('import.kelas')}}" class="btn btn-xs btn-success">
									Import Kelas
								</a>
								<a style="float: right;" href="{{route('insert.kelas')}}" class="btn btn-xs btn-success">
									Tambah 
								</a>
							</h4>
							
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								@yield('content')
								<div class="table-responsive" >
									<table id="datatable" class="table  table-bordered table-hover">
										<thead>
											<tr>
												<th style="width: 15%">NO</th>
												<th style="width: 25%">Kelas</th>
												<th style="width: 30%">Wali Kelas</th>
												<th style="width: 30%"></th>
											</tr>
										</thead>

										<tbody>
											@foreach($kelas as $k)
											<tr>
												<td>{{ $no++ }}</td>
												<td>{{ $k->tingkat }} {{ $k->k_nama }}</td>
												<td>{{ $k->nama }}</td>
												<td>
													<div class="btn-group">
														<a href="{{route('siswa',$k->k_id)}}" class="btn btn-xs btn-info">
															Siswa
														</a>

														<a href="{{route('edit.kelas',$k->k_id)}}" class="btn btn-xs btn-success">
															<i class="ace-icon fa fa-pencil bigger-120"></i>
														</a>

														<a onclick="return confirm('Apakah anda yakin akan menghapus data ini ?')" href="{{route('delete.kelas',$k->k_id)}}" class="btn btn-xs btn-danger">
															<i class="ace-icon fa fa-trash bigger-120"></i>
														</a>
													</div>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>							
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			@include('admin/footer')

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		@include('admin/loadjs')

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			$(document).ready(function() {
			    $('#datatable').DataTable();
			} );
		</script>
	</body>
</html>
