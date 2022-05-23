const flashData = $(".flash-data").data("flashdata");

console.log(flashData);
if (flashData == "Data tidak ditemukan.") {
	Swal.fire({
		title: "Gagal",
		text: flashData,
		type: "danger",
		showCloseButton: true,
	});
} else if (flashData) {
	Swal.fire({
		title: "Berhasil",
		text: "Data berhasil " + flashData,
		type: "success",
		showCloseButton: true,
	});
}
