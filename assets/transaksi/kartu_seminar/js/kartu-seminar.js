var ks = {
	start_up: function () {
	}, // end - start_up

	getDataSeminarAktif: function() {
		var dcontent = $('.tbl_seminar tbody');

		var val = $('.jenis_pengajuan').val();

		if ( !empty(val) ) {
			$.ajax({
	            url : 'transaksi/KartuSeminar/getDataSeminarAktif',
	            data : {
	                'jenis_pengajuan_kode' : val
	            },
	            type : 'GET',
	            dataType : 'HTML',
	            beforeSend : function(){ showLoading(); },
	            success : function(html){
	                hideLoading();
	                $(dcontent).html(html);
	            },
	        });
		} else {
			$(dcontent).html('<tr><td colspan="8">Data tidak ditemukan.</td></tr>');
		}
	}, // end - getDataSeminarAktif

	checkIn: function(elm) {
		var pengajuan_kode = $(elm).attr('data-pengajuankode');

		$.ajax({
            url : 'transaksi/KartuSeminar/checkIn',
            data : {
                'pengajuan_kode' : pengajuan_kode
            },
            type : 'POST',
            dataType : 'JSON',
            beforeSend : function(){ showLoading(); },
            success : function(html){
                hideLoading();

                ks.getDataSeminarAktif();
            },
        });
	}, // end - checkIn

	checkOut: function(elm) {
		var pengajuan_kode = $(elm).attr('data-pengajuankode');

		$.ajax({
            url : 'transaksi/KartuSeminar/checkOut',
            data : {
                'pengajuan_kode' : pengajuan_kode
            },
            type : 'POST',
            dataType : 'JSON',
            beforeSend : function(){ showLoading(); },
            success : function(html){
                hideLoading();

                ks.getDataSeminarAktif();
            },
        });
	}, // end - checkOut
};

ks.start_up();