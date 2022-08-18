var ks = {
	start_up: function () {
		ks.setting_up();
	}, // end - start_up

	setting_up: function () {
		$('.mahasiswa').select2();
		$('.mahasiswa').on('select2:select', function() {
			ks.getLists();
		});
	}, // end - setting_up

	getLists: function() {
		var mahasiswa = $('select.mahasiswa').val();

		if ( !empty(mahasiswa) ) {			
			$.ajax({
	            url : 'laporan/KartuSeminar/getLists',
	            type : 'GET',
	            dataType : 'HTML',
	            data: {
	            	'mahasiswa': mahasiswa
	            },
	            beforeSend : function(){ showLoading(); },
	            success : function(html){
	                hideLoading();
	                
	                $('table.tbl_seminar tbody').html( html );
	            },
	        });
		} else {
			$('table.tbl_seminar tbody').html('<tr><td colspan="7">Data tidak ditemukan.</td></tr>');
		}
	}, // end - getLists
};

ks.start_up();