var dp = {
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

        $.get('parameter/DurasiPelaksanaan/modalAddForm',{
        },function(data){
            var _options = {
                className : 'large',
                message : data,
                addClass : 'form',
                onEscape: true,
            };
            bootbox.dialog(_options).bind('shown.bs.modal', function(){
                $(this).find('.modal-header').css({'padding-top': '0px'});
                $(this).find('.modal-dialog').css({'width': '30%', 'max-width': '100%'});

                dp.setting_up();
            });
        },'html');
	}, // end - modalAddForm

	modalEditForm: function (elm) {
		$('.modal').modal('hide');

		var tr = $(elm).closest('tr');

        $.get('parameter/DurasiPelaksanaan/modalEditForm',{
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

                dp.setting_up();
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
			var durasi = numeral.unformat($(div).find('.durasi').val());

			bootbox.confirm('Apakah anda yakin ingin menyimpan data ?', function(result) {
				if ( result ) {
					var data = {
						'durasi': durasi
					};

			        $.ajax({
			            url: 'parameter/DurasiPelaksanaan/save',
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
			var id = $(elm).data('id');
			var durasi = numeral.unformat($(div).find('.durasi').val());

			bootbox.confirm('Apakah anda yakin ingin meng-ubah data ?', function(result) {
				if ( result ) {
					var data = {
						'id': id,
						'durasi': durasi
					};

			        $.ajax({
			            url: 'parameter/DurasiPelaksanaan/edit',
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
				var id = $(tr).data('id');

		        $.ajax({
		            url: 'parameter/DurasiPelaksanaan/delete',
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

dp.start_up();