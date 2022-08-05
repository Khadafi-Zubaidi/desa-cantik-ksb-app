@extends('masterlayout.master_layout_backend')
@section('content')
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand navbar-dark">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">Dashboard Admin</a>
                    </li>
                </ul>
            </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <a href="#" class="brand-link">
                    <span class="brand-text font-weight-light">Menu Utama</span>
                </a>
                <div class="sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{asset('foto_admin_app')}}/{{$LoggedUserInfo->foto_admin_app}}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">{{$LoggedUserInfo->nama_admin_app}}</a>
                        </div>
                    </div>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{route('tambah_data_kecamatan_oleh_admin_app')}}" class="nav-link">
                                    <i class="nav-icon fas fa-plus"></i>
                                    <p>
                                        Tambah Data
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('dashboard_admin_app')}}" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>
                                        Kembali ke Dashboard
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <h1 class="m-0">{{ config('app.name') }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Data Kecamatan</h5>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @csrf
                                                <table id="data_tabel" class="table table-bordered table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Kode Wilayah Kecamatan</th>
                                                            <th>Nama Kecamatan</th>
                                                            <th colspan="2">Nama Kabupaten</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $no = 1; @endphp
                                                        @foreach($DataTabel as $dt)
                                                            <tr>
                                                                <td>{{$no++}}</td>
                                                                <td>{{$dt->kode_wilayah_kecamatan}}</td>
                                                                <td>{{$dt->nama_kecamatan}}</td>
                                                                <td>{{$dt->nama_kabupaten}}</td>
                                                                <td>
                                                                    <a href="javascript:void(0)" onclick="ubahDataKabupaten({{$dt->id}})" class="btn btn-warning btn-block btn-sm">Ubah Nama Kabupaten</a>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0)" onclick="ubahData({{$dt->id}})" class="btn btn-warning btn-block btn-sm">Ubah</a>
                                                                    <a href="javascript:void(0)" onclick="hapusData({{$dt->id}})" class="btn btn-danger btn-block btn-sm">Hapus</a>
                                                                </td>
                                                            </tr>
                                                            <!-- Ubah Data Nama Kabupaten -->
                                                            <div class="modal fade" id="Modal1">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Ubah Data</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form id="Form1" action="" method="post">
                                                                                @csrf
                                                                                <input type="hidden" id="id1"/>
                                                                                <input type="hidden" id="id_kabupaten1"/>
                                                                                <div class="input-group mb-3">
                                                                                    <label>Nama Kabupaten</label>
                                                                                    <select name="id_kabupaten" id="id_kabupaten_option" class="form-control" style="width: 100%;">
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <button type="submit" class="btn btn-success btn-block">Simpan Perubahan Data</button>
                                                                                </div>
                                                                            </form>
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <script>
                                                                function ubahDataKabupaten(id)
                                                                {
                                                                    $.get('/cari_id_kecamatan/'+id,function(data){
                                                                        $("#id1").val(data.id);
                                                                        $("#id_kabupaten1").val(data.id_kabupaten);
                                                                        $("#Modal1").modal('toggle');
                                                                    });
                                                                    $.ajax({
                                                                        type:"GET",
                                                                        url:"/tampil_data_kabupaten_untuk_pilihan",
                                                                        dataType: 'JSON',
                                                                        success:function(res){
                                                                            if(res){
                                                                                $("#id_kabupaten_option").empty();
                                                                                $("#id_kabupaten_option").append('<option>---Pilih Kabupaten---</option>');
                                                                                $.each(res,function(id,nama_kabupaten){
                                                                                    $("#id_kabupaten_option").append('<option value="'+nama_kabupaten+'">'+nama_kabupaten+'-'+id+'</option>');
                                                                                });
                                                                            }else{
                                                                                $("#id_kabupaten_option").empty();
                                                                            }
                                                                        }
                                                                    });
                                                                    $('#id_kabupaten_option').change(function(){
                                                                        var data_value = $(this).val();
                                                                        $("#id_kabupaten1").val(data_value);
                                                                    });
                                                                    $("#Form1").submit(function (e){
                                                                        e.preventDefault();
                                                                        let id = $("#id1").val();
                                                                        let id_kabupaten = $("#id_kabupaten1").val();
                                                                        let _token = $("input[name=_token]").val();
                                                                        $.ajax({
                                                                            url:"{{route('kecamatan.simpan_perubahan_data_kabupaten')}}",
                                                                            type: "PUT",
                                                                            data:{
                                                                                id:id,
                                                                                id_kabupaten:id_kabupaten,
                                                                                _token:_token
                                                                            },
                                                                            success:function(response){
                                                                                $("#Modal1").modal('hide');
                                                                                window.location = "{{route('tampil_data_kecamatan_oleh_admin_app')}}";
                                                                            }
                                                                        })
                                                                    })
                                                                }
                                                            </script>
                                                            <!-- Ubah Data Kecamatan -->
                                                            <div class="modal fade" id="Modal2">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Ubah Data</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form id="Form2" action="" method="post">
                                                                                @csrf
                                                                                <input type="hidden" id="id2"/>
                                                                                <label>Kode Wilayah Kecamatan *</label><br>
                                                                                <div class="input-group mb-3">
                                                                                    <input type="text" id="kode_wilayah_kecamatan2" class="form-control" required>
                                                                                </div>
                                                                                <label>Nama Kecamatan *</label><br>
                                                                                <div class="input-group mb-3">
                                                                                    <input type="text" id="nama_kecamatan2" class="form-control" required>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan Data</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <script>
                                                                function ubahData(id)
                                                                {
                                                                    $.get('/cari_id_kecamatan/'+id,function(data){
                                                                        $("#id2").val(data.id);
                                                                        $("#kode_wilayah_kecamatan2").val(data.kode_wilayah_kecamatan);
                                                                        $("#nama_kecamatan2").val(data.nama_kecamatan);
                                                                        $("#Modal2").modal('toggle');
                                                                    })
                                                                    $("#Form2").submit(function (e){
                                                                        e.preventDefault();
                                                                        let id = $("#id2").val();
                                                                        let kode_wilayah_kecamatan = $("#kode_wilayah_kecamatan2").val();
                                                                        let nama_kecamatan = $("#nama_kecamatan2").val();
                                                                        let _token = $("input[name=_token]").val();
                                                                        $.ajax({
                                                                            url:"{{route('kecamatan.simpan_perubahan_data')}}",
                                                                            type: "PUT",
                                                                            data:{
                                                                                id:id,
                                                                                kode_wilayah_kecamatan:kode_wilayah_kecamatan,
                                                                                nama_kecamatan:nama_kecamatan,
                                                                                _token:_token
                                                                            },
                                                                            success:function(response){
                                                                                $("#Modal2").modal('hide');
                                                                                window.location = "{{route('tampil_data_kecamatan_oleh_admin_app')}}";
                                                                            }
                                                                        })
                                                                    })
                                                                }
                                                            </script>
                                                            <!-- Hapus Data Kecamatan -->
                                                            <div class="modal fade" id="Modal3">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Hapus Data</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form id="Form3" action="" method="post">
                                                                                @csrf
                                                                                <input type="hidden" id="id3"/>
                                                                                <label>Kode Wilayah Kecamatan *</label><br>
                                                                                <div class="input-group mb-3">
                                                                                    <input type="text" id="kode_wilayah_kecamatan3" class="form-control" disabled>
                                                                                </div>
                                                                                <label>Nama Kecamatan *</label><br>
                                                                                <div class="input-group mb-3">
                                                                                    <input type="text" id="nama_kecamatan3" class="form-control" disabled>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <button type="submit" class="btn btn-primary btn-block">Hapus Data</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <script>
                                                                function hapusData(id)
                                                                {
                                                                    $.get('/cari_id_kecamatan/'+id,function(data){
                                                                        $("#id3").val(data.id);
                                                                        $("#kode_wilayah_kecamatan3").val(data.kode_wilayah_kecamatan);
                                                                        $("#nama_kecamatan3").val(data.nama_kecamatan);
                                                                        $("#Modal3").modal('toggle');
                                                                    })
                                                                    $("#Form3").submit(function (e){
                                                                        e.preventDefault();
                                                                        bootbox.confirm("Anda yakin mau hapus data ini ?", function(result){
                                                                            if(result){
                                                                                let id = $("#id3").val();
                                                                                let _token = $("input[name=_token]").val();
                                                                                $.ajax({
                                                                                    url:"{{route('kecamatan.hapus_data')}}",
                                                                                    type: "PUT",
                                                                                    data:{
                                                                                        id:id,
                                                                                        _token:_token
                                                                                    },
                                                                                    success:function(response){
                                                                                            $("#Modal3").modal('hide');
                                                                                            window.location = "{{route('tampil_data_kecamatan_oleh_admin_app')}}";
                                                                                    }
                                                                                })
                                                                            }
                                                                        });
                                                                            
                                                                    })
                                                                }
                                                            </script>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
@endsection