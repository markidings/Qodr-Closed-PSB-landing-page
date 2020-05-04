<script>

const BASE_URL = '{{ url('dashboard/paket') }}';
const BASE_URL_LIST = '{{ url('dashboard/paket') }}';
const SuccessToast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2500 });
const ASSETS = `{{ asset('storage/images/packets/') }}`;

const { namaEdit, menuEdit, porsiEdit, keteranganEdit, kategoriEdit, jkEdit, hargaEdit } = { namaEdit: '#nama-edit', menuEdit: '#menu-edit', porsiEdit: '#porsi-edit', keteranganEdit: '#keterangan-edit', kategoriEdit: '#kategori-edit', jkEdit: '#jk-edit', hargaEdit: "#harga-edit" };

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
    delete: function(id) {
      return `${BASE_URL}/${id}/destroy`
    },
    update: function(id) {
      return `${BASE_URL}/${id}/update`
    },
    show: function(id) {
      return `${BASE_URL}/${id}/show`
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

function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }

/* Load optin form row */
const tableRow = function (url) {
    $.ajax({
    url,
    beforSend: function() {
        $('#table-row').html(`<tr><td colspan="5"><div class="mx-auto lds-ellipsis"><div></div><div></div><div></div><div></div></div></td></tr>`)
    },
    success: function (res) {
        // console.log(res)
        let tableRow = ``
        let no = 1;
        if (res.data.length > 0) {
            $.each(res.data, (key, val) => {
                tableRow += `<tr>
                                <td class="text-center">${no++}.</td>
                                <td>${val.nama}</td>
                                <td>${val.menu}</td>
                                <td>${val.porsi}</td>
                                <td>` + formatRupiah(val.harga, "Rp. ") + `</td>
                                <td>` + formatRupiah(val.price, "Rp. ") + `</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm modal-show" href="#show" data-id="${val.id}"><i class="fas fa-info" style="padding-left: 5px; padding-right: 5px;"></i></button>
                                </td>
                            </tr>`
                ++res.from
            })
        } else {
            tableRow = `<td colspan="5"><h3 class="text-center">Not Found</h3></td>`;
        }
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
    $(hargaEdit).removeAttr('readonly')
  }
}


if ($(this).attr('href') === '#create') { 
    Swal.fire({
      title: 'Silahkan Hubungi Admin CS untuk menambahkan paket anda! Terimakasih..',
      width: 600,
      padding: '3em',
      background: '#fff url(https://www.gambaranimasi.org/templates/gifstheme/assets/images/signature-header.png)',
      backdrop: `
        rgba(78, 205, 196, 0.2)
        url("https://www.gambaranimasi.org/data/media/234/animasi-bergerak-kambing-0029.gif")
        center top
        no-repeat
      `
    })
    //return console.log('mitra')
} else if($(this).attr('href') === '#edit') {
    reset.edit();
    $(method).val('post');
    $(ModalLabel).html('Edit');
    $(saveBtn).addClass('d-none');
    $(updateBtn).removeClass('d-none');
    $(showElModal).addClass('d-none');

    $.ajax({ url: URL.show(id),
    success: function(res){
        const { id, nama, menu, porsi, keterangan, kategori, jk, harga} = res.paket
        $(namaEdit).val(nama);
        $(menuEdit).val(menu);
        $(porsiEdit).val(porsi);
        $(keteranganEdit).val(keterangan);
        $(kategoriEdit).val(kategori);
        $(jkEdit).val(jk);
        $(hargaEdit).val(harga);
        $(hargaEdit).attr('readonly', 'readonly')
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
        let gambar = `<img src='${ASSETS}/${paket.gambar}' class="col-md-12" height="200px">`

        $("#id-keahlian").html(paket.id)
        $("#nama-paket").html(paket.nama)
        $("#menu-paket").html(paket.menu)
        $("#porsi-paket").html(paket.porsi)
        $("#keterangan-paket").html(paket.keterangan)
        $("#kategori-paket").html(paket.kategori)
        $("#harga-paket").html(formatRupiah(paket.harga, 'RP. '))
        $("#price-paket").html(formatRupiah(paket.price, 'RP. '))
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
Create Paket
*/
$(document).on('click', '#save-btn', function(e) {
    const data = $('#modal-form').serialize();
    $.ajax({
      url: URL.create(),
      method: 'post',
      data,
      success: function(res) {
        tableRow(URL.all());
        $('#modal').modal('hide');
        SuccessToast.fire({ type: 'success', title: 'Berhasil menambahkan bidang keahlian!' });
      },
      error: function(err) {
        console.log(err)
        showErrorMessages(err.responseJSON.errors);
      }
    })
});

/*
  Update Bidang Keahlian
*/
$(document).on('click', '#update-btn', function(e) {
  const data = $('#modal-form').serialize();
  toggleLoading(true);
  $.ajax({
    url: URL.update($('#update-btn').attr('data-id')),
    method: 'put',
    data,
    success: function(res) {
      tableRow(URL.all());
      $('#modal').modal('hide');
      toggleLoading(false);
      SuccessToast.fire({ type: 'success', title: 'Update Successfully' });
    },
    error: function(err) {
      console.log(err);
      toggleLoading(false);
      showErrorMessages(err.responseJSON.errors);
    }
  })
});

/*
  Delete Bidang Keahlian
*/
$(document).on('click', '.delete-keahlian', function(e) {
  const id = $(this).attr('data-id')
  mySwall.question().then(({value}) => {
    if (value) {
      $.ajax({
        url: URL.delete(id),
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
const showErrorMessages = function({ nama }) {
  nama ? $(namaEdit).addClass(invalid).next().text(nama[0]) : $(namaEdit).removeClass(invalid);
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

</script>