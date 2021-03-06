@extends('backend.layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<style>
  .select2-container .select2-selection--single {
    height: 37.99px !important;
  }

  .text-sm .select2-container--default .select2-selection--single .select2-selection__rendered, select.form-control-sm~.select2-container--default .select2-selection--single .select2-selection__rendered {
    margin-top: -3px !important;
  }

  .select2-selection__rendered {
    font-size: 16px !important;
    color: #818181 !important;
  }
  .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #ced4da !important;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px !important;
    top: 1px !important; 
  }

  .select2-container--default .select2-selection--single {
    border-radius: 0px;
  }
  .select2-container--default .select2-results>.select2-results__options {
    max-height: 150px !important;
  }

  .redBorder {
    border-color: red !important;
  }

  .btn-tool-action {
    font-size: .875rem;
    margin: -.75rem 0;
    padding: .25rem .5rem;
  }
  
  .btn-tool-action:hover {
    color: #fff !important;
  }
</style>
@endsection

@section('content')
@if (session()->has('Destination_SO'))
<div class="col-12">
  <div class="callout callout-danger">
    <h5><i class="fas fa-times"></i> &ensp; Pemberitahuan :</h5>
    Silahkan Selesaikan Transaksi Sebelumnya Untuk Melakukan Transaksi Barang Masuk <br> <br>
    @if (session()->has('Destination_SO'))
      <a href="{{ route('Out.index') }}" class="btn btn-outline-primary" style="text-decoration: none;">
        <i class="fa fa-arrow-left"></i> &ensp; Kembali Ke Transaksi Sebelumnya
      </a>
    @endif
  </div>
</div>
@else
<div class="col-12">
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"> <i class="fa fa-sign-in-alt"></i> &ensp; Form Transaksi Barang Masuk</h5>
      <div class="card-tools"> 
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>  

        <a href="#" class="btn btn-tool-action btn-outline-success done" onclick="event.preventDefault(); document.getElementById('end-form').submit();" style="{{ session()->has('Supplier_SE') ? '':'display:none;'  }}">
          <i class="fa fa-check"></i> &ensp; Selesai
        </a>
        <a href="#" class="btn btn-tool-action btn-outline-danger cancel" onclick="event.preventDefault(); document.getElementById('cancel-form').submit();" style="{{ session()->has('Supplier_SE') ? '':'display:none;'  }}">
          <i class="fa fa-times"></i> &ensp; Batalkan
        </a> 

        <form id="cancel-form" action="{{ route('Entry.cancel') }}" method="post" style="display: none;">
          @csrf
        </form>

        <form id="end-form" action="{{ route('Entry.store') }}" method="post" style="display: none;">
          @csrf
        </form>
            

      </div> 
    </div>
    <div class="card-body"> 
      <div class="row">
        <div class="form-group col-md-3 col-lg-3">
          <label for="">Tanggal Transaksi : </label>
          <input type="text" name="tanggal" id="tanggal" class="form-control flat" value="{{ date('d-m-Y') }}" readonly>
        </div>
        <div class="form-group col-md-4 col-lg-4">
          <label for="">Supplier : <span class="text-danger">*</span></label>
          <input type="text" name="supplier" id="supplier" class="form-control flat" value="{{ session('Supplier_SE') }}" placeholder="Masukan Suppler Barang Masuk..." {{ session()->has('Supplier_SE') ? 'readonly':'' }} required autofocus>
          <span class="text-danger empty_s" style="display: none">
            Masukan Supplier Barang !
          </span>
        </div>
        <div class="form-group col-md-5 col-lg-5">
          <label for="">Deskripsi Tambahan : </label>
          <input type="text" name="description" id="description" class="form-control flat" value="{{ session('Description_SE') }}" {{ session()->has('Description_SE') ? 'readonly':'' }} placeholder="Masukan Deskripsi Bila Perlu..">
        </div>
        <div class="col-12">
          <hr class="m-0 mb-2">
        </div>
        <div class="form-group col-md-6 col-lg-6">
          <label for="">Nama Barang : <span class="text-danger">*</span></label>
          <select name="stuff_id" id="stuff_id" class="form-control select2 flat" style="width: 100%;" data-placeholder="Pilih Data Barang" required>
            <option value=""></option>
            @foreach ($stuff as $item)
              <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
            <span class="text-danger empty_st" style="display: none">
              Silahkan Pilih Barang !
            </span> 
          </select>
        </div>
        <div class="form-group col-md-3 col-lg-3">
          <label for="">Kategori Barang : </label>
          <input type="text" name="category" id="category" class="form-control flat" placeholder="Silahkan Pilih Data Barang" readonly>
        </div>
        <div class="form-group col-md-3 col-lg-3">
          <label for="">Lokasi Penyimpanan : </label>
          <input type="text" name="storage" id="storage" class="form-control flat" placeholder="Silahkan Pilih Data Barang" readonly>
        </div>
        <div class="form-group col-12">
          <label for="">Deskripsi Barang : <span class="text-danger">*</span></label>
          <textarea name="stuff_description" id="stuff_description" class="form-control flat" placeholder="Silahkan Pilih Data Barang" readonly></textarea>
        </div> 
        <div class="form-group col-md-4 col-lg-4">
          <div class="entry update" style="display: none;">
            <div class="input-group">
              <div class="input-group-prepend" >
                <span class="input-group-text flat jsm">Jumlah Stok Masuk &ensp; : </span>
              </div>
              <input type="number" name="stock_entry" id="stock_entry" class="form-control flat" placeholder="0" min="1">
            </div>
            <span class="text-danger empty_se" style="display: none">
              Stok Masuk Tidak Boleh Kurang Dari 1 !
            </span> 
          </div>
        </div>
        <div class="form-group col-md-6 col-lg-6">
          <div class="entry update" style="display: none;">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text flat">Deskripsi &ensp; : </span>
              </div>
              <input type="text" name="stock_entry_d" id="stock_entry_d" class="form-control flat" placeholder="Deskripsi Stok Masuk...">
            </div>
          </div>
        </div>
        <div class="form-group col-md-2 col-lg-2">
          <div class="entry add-btn" style="display: none;">
            <div class="row">
              <div class="col-6">
                <button type="button" class="btn btn-outline-success btn-block flat" id="add-to-cart" style="height: 37.99px;">
                  <i class="fa fa-plus"></i>
                </button>
              </div>
              <div class="col-6">
                <button type="button" class="btn btn-outline-danger btn-block flat reset" id="" style="height: 37.99px;">
                  <i class="fa fa-times"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="update update-btn" style="display: none;">
            <div class="row">
              <div class="col-6">
                <button type="button" class="btn btn-outline-primary btn-block flat" id="update-cart" style="height: 37.99px;">
                  <i class="fa fa-check"></i>
                </button>
              </div>
              <div class="col-6">
                <button type="button" class="btn btn-outline-danger btn-block flat reset" id="" style="height: 37.99px;">
                  <i class="fa fa-times"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"> <i class="fa fa-shopping-cart"></i> &ensp; Keranjang Barang Masuk</h5>
      <div class="card-tools"> 
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>  
      </div> 
    </div>
    <div class="card-body"> 
      <div class="table-responsive">
        <table class="table table-bordered table-hover table-stripped">
          <thead>
            <tr>
              <th width="5%" class="text-center">No.</th>
              <th width="25%">Nama Barang</th>
              <th width="10%">Kategori</th>
              <th width="15%">Jumlah</th>
              <th>Deskripsi</th>
              <th width="15%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody id="cart">
            @foreach ($cart->getContent() as $item)
              @if ($item->attributes->supplier == session('Supplier_SE') && $item->attributes->transaksi == 'Stock Entry')
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->associatedModel->category->name }}</td>
                  <td>{{ $item->quantity }} Unit</td>
                  <td>{{ $item->attributes->desc_d == null ? 'Tidak Ada Deskripsi':$item->attributes->desc_d }}</td>
                  <td class="text-center">
                    <div class="btn-group"> 
                      <button class="btn btn-outline-warning btn-sm flat editSE mr-1" data-id="{{ $item->id }}">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-outline-danger btn-sm flat deleteSE" data-id="{{ $item->id }}">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif

@endsection

@section('script')
<script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>
<script>
  $(document).ready(function() {
    function getStuff() {
      $.ajax({
        url: "{{ route('json.stuff') }}",
        method: "GET",
        success: function (res) {
          $('#stuff_id').empty();
          $('#stuff_id').append('<option value=""></option>')
          res.forEach(data => {
            $('#stuff_id').append('<option value="'+data.id+'">'+data.name+'</option>')
          });
        },
        error: function (e) {
          toastWarning('Silahkan Refresh Ulang Halaman !');
        }
      })
    }

    function getDetail(id) {
      $.ajax({
        url: "{{ route('json.stuff.detail') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          id_for_detail: id,
        },
        success: function(res) {
          $('#category').val(res.category.name);
          $('#storage').val(res.storage.name);
          $('#stuff_description').val(res.description);
          $('.entry').show();
          $('.update-btn').hide();
          $('#stock_entry').val('').focus();
          $('#stock_entry_d').val('');
        },
        error: function(e) {
          if (e.status == '422') {
            toastError('Terjadi Kesalahan Silahkan Ulangi !');
          } else {
            toastError(e.responseJSON.message);
            getStuff();
            $('#stuff_id').select2('close');
          }
        }
      })
    }
    
    function getCart() {
      $.ajax({
        url: "{{ route('Cart.entry') }}",
        method: "GET",
        success: function(res) { 
          $('#cart').empty();
          var data = Object.values(res);
          var no = 1;
          for (let i = 0; i < data.length; i++) {
            var desc_d = 'Tidak Ada Deskripsi';
            const item = data[i];
            if (item.attributes.supplier == $('#supplier').val() && item.attributes.transaksi == 'Stock Entry') {
              if (item.attributes.desc_d != null) {
                desc_d = item.attributes.desc_d;
              }
              $('#cart').append(`
                <tr>
                  <td class="text-center">${no++}</td>
                  <td>${item.name}</td>
                  <td>${item.associatedModel.category.name}</td>
                  <td>${item.quantity} Unit</td>
                  <td>${desc_d}</td>
                  <td class="text-center">
                    <div class="btn-group"> 
                      <button class="btn btn-outline-warning btn-sm flat editSE mr-1" data-id="${item.id}">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-outline-danger btn-sm flat deleteSE" data-id="${item.id}">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              `);
            }
          }
        },
        error: function(e) {
          toastError('Terjadi Kesalahan !');
        }
      })
    }

    $('#stuff_id').select2().on('select2:open', () => {
      $(".select2-results:not(:has(button))").append(`
      <button class="btn btn-outline-info btn-block flat refresh">
        <i class="fa fa-undo"></i> &ensp; Refresh Data
      </button>
      <a href="{{ route('Stuff.create') }}" target="_blank" class="btn btn-outline-secondary btn-block flat" style="border-bottom-left-radius: 1px !important; border-bottom-right-radius: 1px !important;">
        <i class="fa fa-plus"></i> &ensp; Buat Data Baru
      </a>
      `
      );
      $('.select2-results').on('click', '.refresh', function() {
        $('#stuff_id').select2('close');
        getStuff();
      });
    }); 

    $('#stuff_id').on('select2:select', function (e) {
      var data = e.params.data;
      getDetail(data.id);
    }); 

    function clear() {
      $('.entry').hide();
      $('.update').hide();
      $('#category').val('');
      $('#storage').val('');
      $('#stuff_description').val('');
      $('#stuff_id').val(null).trigger('change');
      $('#stuff_id').attr('disabled', false);
    }

    $('.reset').on('click', function() {
      clear();
    });

    function validation() {
      var supplier = $('#supplier').val();
      var stuff = $('#stuff_id').val();
      var entry = $('#stock_entry').val();

      if (supplier == '') {
        $('#supplier').addClass('is-invalid').focus();
        $('.empty_s').show();
      } else {
        $('#supplier').removeClass('is-invalid');
        $('.empty_s').hide();
      }

      if (stuff == '') {
        $('.empty_st').show();
      } else {
        $('.empty_st').hide();
      }

      if (entry == '' || entry < 1) {
        $('.jsm').addClass('redBorder');
        $('#stock_entry').addClass('redBorder').focus();
        $('.empty_se').show();
      } else {
        $('.jsm').removeClass('redBorder');
        $('#stock_entry').removeClass('redBorder');
        $('.empty_se').hide();
      }

      if (supplier == '' || stuff == '' || entry == '' || entry < 1) {
        return false;
      } else {
        return true;
      }
    }

    function addToCart(supplier, desc_h, stuff, stock_entry, desc_d) {
      $.ajax({
        url: "{{ route('Cart.entry.store') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          supplier: supplier,
          desc_h: desc_h,
          stuff: stuff,
          stock_entry: stock_entry,
          desc_d: desc_d
        },
        success: function(res) {
          getCart();
          clear();
          toastInfo('Data Berhasil di-Tambahkan Kedalam Keranjang !');
          $('#supplier').prop('readonly', true);
          $('#description').prop('readonly', true);
          $('.done').show();
          $('.cancel').show();
        }, 
        error: function(e) {
          console.log(e);
          toastError('Terjadi Kesalahan !');
        }
      });
    }

    $('#add-to-cart').on('click', function() {
      var valid = validation();
      if (valid) {
        var sp = $('#supplier').val();
        var dh = $('#description').val();
        var st = $('#stuff_id').val();
        var se = $('#stock_entry').val();
        var sed = $('#stock_entry_d').val();
        addToCart(sp, dh, st, se, sed);
      }
    });

    function cartDetail(id) {
      $.ajax({
        url: "{{ route('Cart.entry.detail') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          rowId: id
        },
        success: function(res) {
          console.log(res);
          $('#category').val(res.associatedModel.category.name);
          $('#storage').val(res.associatedModel.storage.name);
          $('#stuff_description').val(res.associatedModel.description);
          $('.update').show();
          $('.add-btn').hide();
          $('#stock_entry').val(res.quantity).focus();
          $('#stock_entry_d').val(res.attributes.desc_d);
          
          $('#stuff_id').val(res.id);
          $('#stuff_id').trigger('change');
          $('#stuff_id').attr('disabled', true);
        },
        error: function(e) {
          console.log(e);
          toastError('Terjadi Kesalahan !');
        }
      })
    }

    $('#update-cart').on('click', function() {
      var sp = $('#supplier').val();
      var dh = $('#description').val();
      var st = $('#stuff_id').val();
      var se = $('#stock_entry').val();
      var sed = $('#stock_entry_d').val();
      $.ajax({
        url: "{{ route('Cart.entry.update') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          rowId: st,
          stock_in: se,
          desc_d: sed,
          desc_h: dh,
          supplier: sp,
        },
        success: function(res) {
          getCart();
          clear();
          toastInfo('Data Berhasil di-Tambahkan Kedalam Keranjang !');
        },
        error: function(e) {
          toastError('Terjadi Kesalahan !');
        }
      })
    });

    $('#cart').on('click', '.editSE', function() {
      var id = $(this).data('id');
      cartDetail(id); 
    });

    $('#cart').on('click', '.deleteSE', function() {
      var id = $(this).data('id');
      $.ajax({
        url: "{{ route('Cart.entry.delete') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          rowId: id
        },
        success: function(res) {
          getCart();
          toastWarning('Data Barang di-Hapus Dari Keranjang !');
        },
        error: function error(e) {
          toastError('Terjadi Kesalahan !');
        }
      })
    });

  });
</script>
@endsection