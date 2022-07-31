var ns = {
	start_up: function () {
		ns.setting_up();
	}, // end - start_up

	setting_up: function() {
		var today = moment(new Date()).format('YYYY-MM-DD');

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
        if ( !empty(start_date) ) {
        	$("#StartDate").data('DateTimePicker').date(moment(new Date(start_date)));
        }

        $("#EndDate").on("dp.change", function (e) {
            var maxDate = dateSQL($("#EndDate").data("DateTimePicker").date())+' 23:59:59';
            if ( maxDate >= (today+' 00:00:00') ) {
                $("#StartDate").data("DateTimePicker").maxDate(moment(new Date(maxDate)));
            }
        });
        var end_date = $("#EndDate").find('input').data('tgl');
        if ( !empty(end_date) ) {
        	$("#EndDate").data('DateTimePicker').date(moment(new Date(end_date)));
        }

        if ( !empty(start_date) && !empty(end_date) ) {
        	pengajuan.getLists();
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
			bootbox.alert('Harap isi periode terlebih dahulu.');
		} else {
			var start_date = dateSQL($('#StartDate').data('DateTimePicker').date());
			var end_date = dateSQL($('#EndDate').data('DateTimePicker').date());

			var params = {
				'start_date': start_date,
				'end_date': end_date
			};

			$.ajax({
	            url : 'transaksi/NoSurat/getLists',
	            type : 'GET',
	            dataType : 'HTML',
	            data: {
	            	'params': params
	            },
	            beforeSend : function(){ showLoading(); },
	            success : function(html){
	                hideLoading();
	                $('table tbody').html( html );
	            },
	        });
		}
	}, // end - getLists

	modalAddForm: function () {
		$('.modal').modal('hide');

        $.get('transaksi/NoSurat/modalAddForm',{
        },function(data){
            var _options = {
                className : 'large',
                message : data,
                addClass : 'form',
                onEscape: true,
            };
            bootbox.dialog(_options).bind('shown.bs.modal', function(){
                $(this).find('.modal-header').css({'padding-top': '0px'});
                $(this).find('.modal-dialog').css({'width': '90%', 'max-width': '100%'});
            });
        },'html');
	}, // end - modalAddForm

	modalEditForm: function (elm) {
		$('.modal').modal('hide');

		var tr = $(elm).closest('tr');

        $.get('transaksi/NoSurat/modalEditForm',{
            'id': $(tr).data('id')
        },function(data){
            var _options = {
                className : 'large',
                message : data,
                addClass : 'form',
                onEscape: true,
            };
            bootbox.dialog(_options).bind('shown.bs.modal', function(){
                $(this).find('.modal-header').css({'padding-top': '0px'});
                $(this).find('.modal-dialog').css({'width': '70%', 'max-width': '100%'});
            });
        },'html');
	}, // end - modalEditForm

	save: function() {
		var div = $('.modal');

		var data = $.map( $(div).find('tbody tr'), function(tr) {
			if ( !empty($(tr).find('input').val()) ) {
				var _data = {
					'kode_pengajuan': $(tr).find('td.kode_pengajuan').text(),
					'no_surat': $(tr).find('input').val()
				};

				return _data;
			}
		});

		if ( empty(data) ) {
			bootbox.alert('Tidak ada data yang akan anda simpan.');
		} else {
			bootbox.confirm('Apakah anda yakin ingin menyimpan data ?', function(result) {
				if ( result ) {
			        $.ajax({
			            url: 'transaksi/NoSurat/save',
			            data: {
			                'params': data
			            },
			            type: 'POST',
			            dataType: 'JSON',
			            beforeSend: function() { showLoading(); },
			            success: function(data) {
			                hideLoading();
			                if ( data.status == 1 ) {
			                	bootbox.alert(data.message, function() {
			                		$('.modal').modal('hide');

			                		var start_date = $('#StartDate').find('input').val();
			                		var end_date = $('#EndDate').find('input').val();

			                		if ( !empty(start_date) && !empty(end_date) ) {
			                			ns.getLists();
			                		}
			                	});
			                } else {
			                    bootbox.alert(data.message);
			                }
			            }
			        });
				}
			});
		}
    }, // end - save

    delete: function(elm) {
		var tr = $(elm).closest('tr');

		bootbox.confirm('Apakah anda yakin ingin meng-hapus data ?', function(result) {
			if ( result ) {
				var params = {
					kode: $(elm).data('kode'),
					no_surat: $(elm).data('nosurat')
				};

		        $.ajax({
		            url: 'transaksi/NoSurat/delete',
		            data: {
		                'params': params
		            },
		            type: 'POST',
		            dataType: 'JSON',
		            beforeSend: function() { showLoading(); },
		            success: function(data) {
		                hideLoading();
		                if ( data.status == 1 ) {
		                	bootbox.alert(data.message, function() {
		                		var start_date = $('#StartDate').find('input').val();
		                		var end_date = $('#EndDate').find('input').val();

		                		if ( !empty(start_date) && !empty(end_date) ) {
		                			ns.getLists();
		                		}
		                	});
		                } else {
		                    bootbox.alert(data.message);
		                }
		            }
		        });
			}
		});
    }, // end - delete
};

ns.start_up();