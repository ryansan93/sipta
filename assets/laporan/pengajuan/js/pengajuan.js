var pengajuan = {
	start_up: function () {
		pengajuan.setting_up();
	}, // end - start_up

	setting_up: function () {
		$('.dosen').select2({placeholder: 'Pilih Dosen'}).on("select2:select", function (e) {
            var dosen = $('.dosen').select2().val();

            for (var i = 0; i < dosen.length; i++) {
                if ( dosen[i] == 'all' ) {
                    $('.dosen').select2().val('all').trigger('change');

                    i = dosen.length;
                }
            }

            $('.dosen').next('span.select2').css('width', '100%');
        });
        $('.dosen').next('span.select2').css('width', '100%');

        $("#StartDate").datetimepicker({
            locale: 'id',
            format: 'DD MMM Y'
        });

        $("#EndDate").datetimepicker({
            locale: 'id',
            format: 'DD MMM Y'
        });

        $("#StartDate").on("dp.change", function (e) {
            var minDate = dateSQL($("#StartDate").data("DateTimePicker").date())+' 00:00:00';
            $("#EndDate").data("DateTimePicker").minDate(moment(new Date(minDate)));
        });
        var start_date = $("#StartDate").find('input').data('tgl');
        if ( !empty(start_date) && empty($("#StartDate").find('input').val()) ) {
        	$("#StartDate").data('DateTimePicker').date(moment(new Date(start_date)));
        }
	}, // end - setting_up

	getLists: function() {
		var err = 0;
		$.map( $('[data-required=1]'), function(ipt) {
			if ( empty( $(ipt).val() ) ) {
				$(ipt).parent().addClass('has-error');
				err++;
			} else {
				$(ipt).parent().removeClass('has-error');
			}
		});

		if ( err > 0 ) {
			bootbox.alert('Harap lengkapi parameter terlebih dahulu.');
		} else {
			var start_date = dateSQL($('#StartDate').data('DateTimePicker').date());
			var end_date = dateSQL($('#EndDate').data('DateTimePicker').date());
			var dosen = $('select.dosen').val();

			var params = {
				'start_date': start_date,
				'end_date': end_date,
				'dosen': dosen
			};

			$.ajax({
	            url : 'laporan/Pengajuan/getLists',
	            type : 'POST',
	            dataType : 'JSON',
	            data: {
	            	'params': params
	            },
	            beforeSend : function(){ showLoading(); },
	            success : function(data){
	                hideLoading();
	                if ( data.status == 1 ) {
		                $('table.by_tanggal tbody').html( data.content.list_report_by_tanggal );
		                $('table.by_dosen tbody').html( data.content.list_report_by_dosen );
		                $('div.by_prodi').html( data.content.list_report_by_prodi );
		            } else {
		            	bootbox.alert(data.message);
		            }
	            },
	        });
		}
	}, // end - getLists
};

pengajuan.start_up();