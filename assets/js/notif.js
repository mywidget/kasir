function notif(m,t){
$.notify({
	message: m 
},{
	type: t,
animate: {
		enter: 'animated fadeInRight',
		exit: 'animated fadeOutRight'
	},
placement: {
		from: 'bottom',
		align: 'right'
	}
});
}

function sweeta(a,b,icon){
swal({
	title: 'Anda yakin?',
	text: "Periksa kembali sebelum di cetak!",
	type: 'warning',
	buttons:{
		confirm: {
			text : 'Ya, ceyak!',
			className : 'btn btn-success'
		},
		cancel: {
			visible: true,
			className: 'btn btn-danger'
		}
	}
}).then((Delete) => {
	if (Delete) {
		swal({
			title: 'Batal!',
			text: 'Your file has been deleted.',
			type: 'success',
			buttons : {
				confirm: {
					className : 'btn btn-success'
				}
			}
		});
	} else {
		swal.close();
	}
});
}
function sweet_time(tim,title,msg){
let timerInterval
Swal.fire({
  title: title,
  html: msg,
  showCloseButton: true,
  timer: tim,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading()
    timerInterval = setInterval(() => {
      const content = Swal.getContent()
      if (content) {
        const b = content.querySelector('b')
        if (b) {
          b.textContent = Swal.getTimerLeft()
        }
      }
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  // if (result.dismiss === Swal.DismissReason.timer) {
    // console.log('I was closed by the timer')
  // }
})
}
function sweet_cetak(a){
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})

swalWithBootstrapButtons.fire({
  title: 'Anda yakin?',
  text: "Periksa kembali sebelum di cetak!",
  icon: 'warning',
  showCancelButton: false,
  confirmButtonText: 'Ya, cetak!',
  cancelButtonText: 'Batal! ',
  showCloseButton: true,
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
	  cetak(a);
	   // var id = $(this).attr('data-id');
    // swalWithBootstrapButtons.fire(
      // 'Deleted! '+a,
      // 'Your file has been deleted.',
      // 'success'
    // )
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'di Batalkan',
      'Data tidak dicetak ',
      'error'
    )
  }
})
}
function sweet(a,b,icon,btn){
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-'+btn
  },
  buttonsStyling: false
})

swalWithBootstrapButtons.fire({
  icon: icon,
  title: a,
  text: b
})
}
function sweetb(a,b,icon){
swal(a, b, {
	icon : icon,
	buttons: {        			
		confirm: {
			className : 'btn btn-'+icon
		}
	},
});
}