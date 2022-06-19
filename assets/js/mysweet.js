const flashData = $(".flash-data").data("flashdata");
console.log(flashData);
if (flashData == "tidak ditemukan.") {
	Swal.fire({
		title: "Gagal",
		text: flashData,
		icon: "error",
		type: "danger",
		showCloseButton: true,
	});
} else if (flashData == "Dihapus.") {
	Swal.fire({
		title: "Berhasil",
		text: flashData,
		icon: "success",
		type: "success",
		showCloseButton: true,
	});
} else if (flashData == 'Detail Pesanan Kosong.') {
	Swal.fire({
		title: "Gagal",
		text: flashData,
		icon: "error",
		type: "danger",
		showCloseButton: true,
	});
} else if (flashData) {
	Swal.fire({
		title: "Berhasil",
		text: "Data berhasil " + flashData,
		icon: "success",
		type: "success",
		showCloseButton: true,
	});
} 
