var jsu = {
	start_up: function () {
	}, // end - start_up

	setting_up: function() {
        $("#Awal").datetimepicker({
            locale: 'id',
            format: 'LT'
        });

        $("#Akhir").datetimepicker({
            locale: 'id',
            format: 'LT'
        });

        $("#Awal").on("dp.change", function (e) {
            var minDate = dateTimeSQL($("#Awal").data("DateTimePicker").date());
            $("#Akhir").data("DateTimePicker").minDate(moment(new Date(minDate)));
        });

        $("#Akhir").on("dp.change", function (e) {
            var maxDate = dateTimeSQL($("#Akhir").data("DateTimePicker").date());
            $("#Awal").data("DateTimePicker").maxDate(moment(new Date(maxDate)));
        });

        $.map( $('.date'), function(date) {
        	if ( !empty($(date).find('input').data('val')) ) {
        		var val = $(date).find('input').data('val');

        		var hour = val.substr(0, 2);
        		var minute = val.substr(3, 2);

        		var d = moment(new Date()).format('YYYY-MM-DD');
				var day = parseInt(d.substr(8, 2));
				var month = parseInt(d.substr(5, 2));
				var year = parseInt(d.substr(0, 4));

				var _date = d+' '+hour+':'+minute;

        		$(date).data('DateTimePicker').date(new Date(_date));
        		if ( $(date).attr('id') == 'Akhir' ) {
            		$("#Awal").data("DateTimePicker").maxDate(new Date(_date));
        		} else {
            		$("#Akhir").data("DateTimePicker").minDate(moment(new Date(_date)));
        		}
        	}
        });
	}, // end - setting_up

	modalAddForm: function () {
		$('.modal').modal('hide');

        $.get('parameter/JamSeminarUjian/modalAddForm',{
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

                jsu.setting_up();
            });
        },'html');
	}, // end - modalAddForm

	modalEditForm: function (elm) {
		$('.modal').modal('hide');

		var tr = $(elm).closest('tr');

        $.get('parameter/JamSeminarUjian/modalEditForm',{
            'id': $(tr).data('kode')
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

                jsu.setting_up();
            });
        },'html');
	}, // end - modalEditForm

	save: function() {
		var div = $('.modal');

		var err = 0;
		$.map( $(div).find('[data-required=1]'), function(ipt) {
			if ( empty($(ipt).val()) ) {
				$(ipt).parent().addClass('has-error');
				err++;
			} else {
				$(ipt).parent().removeClass('has-error');
			}
		});

		if ( err > 0 ) {
			bootbox.alert('Harap lengkapi data terlebih dahulu.');
		} else {
			var jenis_pengajuan = $(div).find('.jenis_pengajuan').val();
			var awal = dateTimeSQL( $(div).find('#Awal').data('DateTimePicker').date() );
			var akhir = dateTimeSQL( $(div).find('#Akhir').data('DateTimePicker').date() );

			bootbox.confirm('Apakah anda yakin ingin menyimpan data ?', function(result) {
				if ( result ) {
					var data = {
						'jenis_pengajuan_kode': jenis_pengajuan,
						'awal': awal,
						'akhir': akhir
					};

			        $.ajax({
			            url: 'parameter/JamSeminarUjian/save',
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
			                		location.reload();
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

    edit: function(elm) {
		var div = $('.modal');

		var err = 0;
		$.map( $(div).find('[data-required=1]'), function(ipt) {
			if ( empty($(ipt).val()) ) {
				$(ipt).parent().addClass('has-error');
				err++;
			} else {
				$(ipt).parent().removeClass('has-error');
			}
		});

		if ( err > 0 ) {
			bootbox.alert('Harap lengkapi data terlebih dahulu.');
		} else {
			var kode = $(elm).data('kode');
			var jenis_pengajuan = $(div).find('.jenis_pengajuan').val();
			var awal = dateTimeSQL( $(div).find('#Awal').data('DateTimePicker').date() );
			var akhir = dateTimeSQL( $(div).find('#Akhir').data('DateTimePicker').date() );

			bootbox.confirm('Apakah anda yakin ingin meng-ubah data ?', function(result) {
				if ( result ) {
					var data = {
						'id': kode,
						'jenis_pengajuan_kode': jenis_pengajuan,
						'awal': awal,
						'akhir': akhir
					};

			        $.ajax({
			            url: 'parameter/JamSeminarUjian/edit',
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
			                		location.reload();
			                	});
			                } else {
			                    bootbox.alert(data.message);
			                }
			            }
			        });
				}
			});
		}
    }, // end - edit

    delete: function(elm) {
		var tr = $(elm).closest('tr');

		bootbox.confirm('Apakah anda yakin ingin meng-hapus data ?', function(result) {
			if ( result ) {
				var id = $(tr).data('kode');

		        $.ajax({
		            url: 'parameter/JamSeminarUjian/delete',
		            data: {
		                'id': id
		            },
		            type: 'POST',
		            dataType: 'JSON',
		            beforeSend: function() { showLoading(); },
		            success: function(data) {
		                hideLoading();
		                if ( data.status == 1 ) {
		                	bootbox.alert(data.message, function() {
		                		location.reload();
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

jsu.start_up();