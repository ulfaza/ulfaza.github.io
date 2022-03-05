<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Siswa - Admin</title>

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
							<li>
								<a href="#">Siswa</a>
							</li>
						</ul><!-- /.breadcrumb -->
					</div>

					<div class="page-content">
						<div class="page-header">
							<h4>
								Siswa
								@foreach($kelas as $k)
								{{ $k->tingkat }} {{ $k->k_nama }}
								<a style="float: right; margin-left: 10px" href="{{route('import.siswa',$k->k_id)}}" class="btn btn-xs btn-success">
									Import Excel
								</a>
								<a style="float: right;" href="{{route('insert.siswa',$k->k_id)}}" class="btn btn-xs btn-success">
									Tambah 
								</a>
								@endforeach
							</h4>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								{{ csrf_field() }}
					            <table id="editable" class="table  table-bordered table-hover">
					              <thead>
					                <tr>
					                  <th width="5%">NO</th>
					                  <th width="10%">NIS</th>
					                  <th width="10%">NISN</th>
					                  <th width="50%">Nama Siswa</th>
					                  <th width="20%">Status</th>
					                </tr>
					              </thead>
					              <tbody>
					                @foreach($siswa as $s)
					                <tr>
					                  <td>{{ $s->s_id }}</td>
					                  <td>{{ $s->nis }}</td>
					                  <td>{{ $s->nisn }}</td>
					                  <td>{{ $s->s_nama }}</td>
					                  <td>{{ $s->status }}</td>
					                </tr>
					                @endforeach
					              </tbody>
					            </table>
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
		$(document).ready(function(){

		  $.ajaxSetup({
		    headers:{
		      'X-CSRF-Token' : $("input[name=_token]").val()
		    }
		  });

		  $('#editable').Tabledit({
		    url:'{{ route("action.siswa") }}',
		    hideIdentifier: true,
		    dataType:"json",
		    columns:{
		      identifier:[0, 's_id'],
		      editable:[[1, 'nis'],[2, 'nisn'],[3, 's_nama'],[4, 'status']]
		    },
		    deleteButton:true,
		    restoreButton:false,
		    onSuccess:function(data, textStatus, jqXHR)
		    {
		      if(data.action == 'delete')
		      {
		        $('#'+data.s_id).remove();
		      }
		    }
		  });
		});  
		</script>
	</body>
</html>
