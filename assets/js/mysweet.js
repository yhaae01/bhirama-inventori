const flashData = $(".flash-data").data("flashdata");

if (flashData) {
	Swal.fire({
		title: "Berhasil",
		text: "Data berhasil " + flashData,
		type: "success",
		showCloseButton: true,
	});
}
