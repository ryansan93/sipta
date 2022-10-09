var dhs = {
	start_up: function () {
		dhs.setting_up();
	}, // end - start_up

	setting_up: function () {
		$('.mahasiswa').select2();
		$('.mahasiswa').on('select2:select', function() {
			dhs.getLists();
		});
	}, // end - setting_up

	collapseRow: function (elm) {
		var tr_header = $(elm).closest('tr.header');
		var tr_detail = $(tr_header).next('tr.detail');

		if ( $(elm).hasClass('fa-caret-square-o-right') ) {
			$(tr_detail).removeClass('hide');
			$(elm).removeClass('fa-caret-square-o-right');
			$(elm).addClass('fa-caret-square-o-down');
		} else {
			$(tr_detail).addClass('hide');
			$(elm).addClass('fa-caret-square-o-right');
			$(elm).removeClass('fa-caret-square-o-down');
		}
	}, // end - collapseRow

	getLists: function() {
		var mahasiswa = $('select.mahasiswa').val();

		if ( !empty(mahasiswa) ) {			
			$.ajax({
	            url : 'laporan/DaftarHadirSeminar/getLists',
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

dhs.start_up();