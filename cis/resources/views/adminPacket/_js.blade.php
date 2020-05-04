<script>

const BASE_URL = '{{ url('dashboard/adminPacket') }}';
const BASE_URL_LIST = '{{ url('dashboard/adminPacket') }}';
const ASSETS = `{{ asset('storage/images/packets/') }}`;

const SuccessToast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2500 });

const { namaEdit, menuEdit, porsiEdit, keteranganEdit, kategoriEdit, priceEdit, hargaEdit, mitra_idEdit, statusPaket, gambarEdit } = { namaEdit: '#nama-edit', menuEdit: '#menu-edit', porsiEdit: '#porsi-edit', keteranganEdit: '#keterangan-edit', kategoriEdit: '#kategori-edit', priceEdit: '#price-edit', hargaEdit: "#harga-edit", mitra_idEdit: "#partner-option-edit", statusPaket: "#status-paket", gambarEdit: "#gambar-edit" };

const { method, modal, ModalLabel, editElModal, updateBtn, saveBtn, showElModal, searchValue, searchSubmit, searchReset, nextNav, prevNav, currentPage, totalPage, totalRows, bLight, bPrimary, disabled } = 
      { method: 'input[name=_method]', modal: '#modal', ModalLabel: '#ModalLabel', editElModal: '#edit-el-modal', updateBtn: '#update-btn', saveBtn: '#save-btn', showElModal: '#show-el-modal', searchSubmit: '#search-submit', searchReset: '#search-reset', searchValue: '#search-value', nextNav: '#next-nav', prevNav: '#prev-nav', currentPage: '#current-page', totalPage: '#total-page', totalRows: '#total-rows', bLight: 'btn-light', bPrimary: 'btn-primary', disabled: 'disabled'};

const { valid, invalid, validFeed, invalidFeed } = { valid: 'is-valid', invalid: 'is-invalid', validFeed: 'valid-feedback', invalidFeed: 'invalid-feedback' };

const mySwall = {
    question: function() {
      return Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })
    },
    deleted: function() {
      return Swal.fire( 'Deleted!', 'Your template has been deleted.', 'success');
    },
    failed: function() {
      return Swal.fire( 'Failed!', 'Internal Server Error', 'error');
    }
}

const URL = {
    delete: function(id, img) {
      return `${BASE_URL}/${id}/${img}/destroy`
    },
    update: function(id) {
      return `${BASE_URL}/${id}/update`
    },
    show: function(id) {
      return `${BASE_URL}/${id}/show`
    },
    showPartner: function() {
      return `${BASE_URL}/showPartner`
    },
    all: function() {
      return `${BASE_URL}/all`
    },
    search: function(val) {
      return `${BASE_URL}/${val}/search`
    },
    create: function() {
      return `${BASE_URL}/store`
    }
}

const toggleLoading = function(params) {
  $('#text-update').text(!params ? 'Update' : 'Loading...').attr('disabled', params);
}

/* Load optin form row */
const tableRow = function (url) {
    $.ajax({
    url,
    beforSend: function() {
        $('#table-row').html(`<tr><td colspan="5"><div class="mx-auto lds-ellipsis"><div></div><div></div><div></div><div></div></div></td></tr>`)
    },
    success: function (res) {
        let tableRow = ``
        let no = 1;
        $.each(res.data, (key, val) => {
            tableRow += `<tr>
                            <td class="text-center">${no++}.</td>
                            <td>${val.city.name}</td>
                            <td>${val.nama}</td>
                            <td>${val.menu}</td>
                            <td>${val.harga}</td>
                            <td>${val.price}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-info btn-sm modal-show" href="#show" data-id="${val.id}"><i class="fas fa-info" style="padding-left: 5px; padding-right: 5px;"></i></button>
                                <a type="button" class="btn btn-warning btn-sm modal-show" href="#edit" data-id="${val.id}"><i class="fas fa-edit"></i></a>
                                <a type="button" class="btn btn-danger btn-sm delete-keahlian" href="#delete" data-image="${val.gambar}" data-id="${val.id}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>`
            ++res.from
        })
        $('#table-row').html(tableRow)
        
        // pagination
        res.next_page_url
          ? $(nextNav).attr('data-url', res.next_page_url).removeAttr(disabled).removeClass(bLight).addClass(bPrimary)
          : $(nextNav).attr(disabled, disabled).removeClass(bPrimary).addClass(bLight);

        res.prev_page_url
          ? $(prevNav).attr('data-url', res.prev_page_url).removeAttr(disabled).removeClass(bLight).addClass(bPrimary)
          : $(prevNav).attr(disabled, disabled).removeClass(bPrimary).addClass(bLight);

        $(currentPage).text(res.current_page)
        $(totalPage).text(res.last_page)
        $(totalRows).text(res.total)
    },
    error: function(err) {
        console.log(err)
    }
    })
}

/* Read table row */
$(window).on('load', function() {
    tableRow(URL.all())
})


/* Show Modal */
$(document).on('click', '.modal-show', function(e) {
const id = $(this).attr('data-id');
const reset = {
  edit: function() {
    $("#nama-edit").val('')
    $(menuEdit).val('')
    $(editElModal).removeClass('d-none');
    $(showElModal).addClass('d-none');
    $(updateBtn).removeClass('d-none');
  },
  show: function() {
    $(updateBtn).addClass('d-none');
    $(showElModal).removeClass('d-none');
    $(editElModal).addClass('d-none');
  },
  create: function() {
    this.edit();
  }
}


if ($(this).attr('href') === '#create') {
    reset.create();
    $("[name='gambar']").attr('required', true)
    $(statusPaket).val('create')
    $.ajax({ 
      url: URL.showPartner(),
      success: function(res){
        $.each(res.partner, (key, val) => {
          $('#partner-option').append(`<option value='${val.id}'>${val.name}</option>`)
        })
        $(method).val('post');
        $(ModalLabel).html('Details');
        $(ModalLabel).html('Tambah Paket Akikah');
        $(saveBtn).removeClass('d-none');
        $(updateBtn).addClass('d-none');
        $(modal).modal('show');
      }
    })
} else if($(this).attr('href') === '#edit') {
    $(gambarEdit).removeAttr('required')
    $(statusPaket).val('edit')
    reset.edit();
    $(method).val('put');
    $(ModalLabel).html('Edit');
    $(saveBtn).addClass('d-none');
    $(updateBtn).removeClass('d-none');
    $(showElModal).addClass('d-none');

    $.ajax({ url: URL.show(id),
    success: function(res){  
        const { id, nama, menu, porsi, keterangan, kategori, price, harga} = res.paket

        $.each(res.partner, (key, val) => {
          if(val.name === res.paket.city.name){
            $('#partner-option').append(`<option value='${val.id}' selected>${val.name}</option>`)
          } else {
            $('#partner-option').append(`<option value='${val.id}'>${val.name}</option>`)
          }
        })

        $(mitra_idEdit).val(res.paket.city.name);
        $(namaEdit).val(nama);
        $(menuEdit).val(menu);
        $(porsiEdit).val(porsi);
        $(keteranganEdit).val(keterangan);
        $(kategoriEdit).val(kategori);
        $(priceEdit).val(price);
        $(hargaEdit).val(harga);
        $(updateBtn).attr('data-id', id);
        $(modal).modal('show');
    },
    error: function(err) {
        console.log(err)
    }
    });
} else if ($(this).attr('href') === '#show') {
    reset.show()
    $(ModalLabel).html('Details')
    $(saveBtn).addClass('d-none')
    $.ajax({
      url: URL.show(id),
      success: function(data){
        const paket = data.paket
        const city = data.city
        let gambar = `<img src='${ASSETS}/${paket.gambar}' class="col-md-12" height="200px">`

        $("#id-keahlian").html(paket.id)
        $("#nama-mitra").html(data.paket.city.name)
        $("#nama-paket").html(paket.nama)
        $("#porsi-paket").html(paket.porsi)
        $("#keterangan-paket").html(paket.keterangan)
        $("#menu-paket").html(paket.menu)
        $("#kategori-paket").html(paket.kategori) 
        $("#price-paket").html(paket.price)
        $("#harga-paket").html(paket.harga)
        $("#created-keahlian").html(paket.created_at)
        $("#updated-keahlian").html(paket.updated_at)
        $("#gambar-paket").html(gambar)
        $(modal).modal('show')
      },
      error: function(err) {
        console.log(err)
      }
    })
  }
});

/*
Create Bidang Keahlian
*/
$('#modal-form').submit(function(evt) {
    evt.preventDefault();
    const formData = new FormData(this)
    console.log(formData);
    if(formData.get('update') === 'edit'){
      $.ajax({
        url: URL.update($('#update-btn').attr('data-id')),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        method: 'post',
        data: formData,
        cache:false,
        enctype: 'multipart/form-data',
        dataTyte: 'json',
        contentType: false,
        processData: false,
        success: function(res) {
          tableRow(URL.all());
          $('#modal').modal('hide');
          toggleLoading(false);
          $('#modal-form').trigger("reset");
          SuccessToast.fire({ type: 'success', title: 'Update Successfully' });
        },
        error: function(err) {
          console.log(err.responseJSON.errors);
          toggleLoading(false);
          showErrorMessages(err.responseJSON.errors);
        }
      })
    } else {
      $.ajax({
        url: URL.create(),
        method: 'post',
        data: formData,
        cache:false,
        enctype: 'multipart/form-data',
        dataTyte: 'json',
        contentType: false,
        processData: false,
        success: function(res) {
          tableRow(URL.all());
          $('#modal').modal('hide');
          // $('#modal').trigger("reset");
          $('#modal-form').trigger("reset");
          // $(this).find('form').trigger('reset');  
          SuccessToast.fire({ type: 'success', title: 'Berhasil menambahkan paket!' });
        },
        error: function(err) {
          console.log(err.responseJSON.errors);
          showErrorMessages(err.responseJSON.errors);
          return SuccessToast.fire({ type: 'danger', title: 'Terjadi kesalahan!' });
        }
      })
    }
});

/*
  Delete Bidang Keahlian
*/
$(document).on('click', '.delete-keahlian', function(e) {
  const id = $(this).attr('data-id')
  const img = $(this).attr('data-image')

  $(method).val('delete');

  mySwall.question().then(({value}) => {
    if (value) {
      $.ajax({
        url: URL.delete(id, img),
        method: 'delete',
        data: $('#form-delete').serialize(),
        success: function(res) {
          tableRow(`${BASE_URL}/all`);
          SuccessToast.fire({ type: 'success', title: 'Delete Successfully' });
        },
        error: function(err) {
          mySwall.failed();
        }
      });
    }
  })
})

/* Error input validation */
const showErrorMessages = function({ nama, keterangan, kategori, price, harga, mitra_id, gambar }) {
  nama ? $(namaEdit).addClass(invalid).next().text(nama[0]) : $(namaEdit).removeClass(invalid);
  keterangan ? $(keteranganEdit).addClass(invalid).next().text(keterangan[0]) : $(keteranganEdit).removeClass(invalid);
  kategori ? $(kategoriEdit).addClass(invalid).next().text(kategori[0]) : $(kategoriEdit).removeClass(invalid);
  price ? $(priceEdit).addClass(invalid).next().text(price[0]) : $(priceEdit).removeClass(invalid);
  harga ? $(hargaEdit).addClass(invalid) : $(hargaEdit).removeClass(invalid);
  mitra_id ? $(mitra_idEdit).addClass(invalid) : $(mitra_idEdit).removeClass(invalid);
  gambar ? $(gambarEdit).addClass(invalid).next().text(gambar[0]) : $(gambarEdit).removeClass(invalid);
}

/* Search Bidang Keahlian */
$(searchSubmit).on('click', function(){
  const val = $(searchValue).val()
  val ? tableRow(URL.search(val)) : ""
  $(searchValue).focus()
})

/* Reset Search */
$(searchReset).on('click', function() {
  $(searchValue).val('').focus()
  tableRow(URL.all())
})

/* Prev Page */
$(prevNav).on('click', function(){
  ($(this).attr(disabled) !== null) ? tableRow($(this).attr('data-url')) : ''
})

/* Next Page */
$(nextNav).on('click', function(){
  ($(this).attr(disabled) !== null) ? tableRow($(this).attr('data-url')) : ''
})

$('.select2-multiple').select2({
    width: '100%'
});
//Fix the above style width:100%
</script>