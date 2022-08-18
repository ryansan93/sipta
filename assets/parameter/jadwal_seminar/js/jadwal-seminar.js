var js = {
	start_up: function () {
		js.setting_up();
	}, // end - start_up

	setting_up: function() {
        $("#TglBerlaku").datetimepicker({
            locale: 'id',
            format: 'DD MMM Y'
        });

        if ( $("#TglBerlaku").length > 1 ) {
        	$("#TglBerlaku").data("DateTimePicker").minDate(moment(new Date()));
        }

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

	changeTabActive: function(elm) {
        var vhref = $(elm).data('href');
        var edit = $(elm).data('edit');
        // change tab-menu
        $('.nav-tabs').find('a').removeClass('active');
        $('.nav-tabs').find('a').removeClass('show');
        $('.nav-tabs').find('li a[data-tab='+vhref+']').addClass('show');
        $('.nav-tabs').find('li a[data-tab='+vhref+']').addClass('active');

        // change tab-content
        $('.tab-pane').removeClass('show');
        $('.tab-pane').removeClass('active');
        $('div#'+vhref).addClass('show');
        $('div#'+vhref).addClass('active');

        if ( vhref == 'action' ) {
            var v_id = $(elm).attr('data-id');

            js.loadForm(v_id, edit);
        };
    }, // end - changeTabActive

    loadForm: function(v_id = null, resubmit = null) {
        var dcontent = $('div#action');

        $.ajax({
            url : 'parameter/JadwalSeminar/loadForm',
            data : {
                'id' :  v_id,
                'resubmit' : resubmit
            },
            type : 'GET',
            dataType : 'HTML',
            beforeSend : function(){ showLoading(); },
            success : function(html){
                hideLoading();
                $(dcontent).html(html);
                js.setting_up();
            },
        });
    }, // end - loadForm

	getLists: function() {
		var div = $('#riwayat');

		var err = 0;
		$.map( $(div).find('[data-required=1]'), function(ipt) {
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

			var params = {
				'start_date': start_date,
				'end_date': end_date
			};

			$.ajax({
	            url : 'parameter/JadwalSeminar/getLists',
	            type : 'GET',
	            dataType : 'HTML',
	            data: {
	            	'params': params
	            },
	            beforeSend : function(){ showLoading(); },
	            success : function(html){
	                hideLoading();

		            $(div).find('table.tbl_riwayat tbody').html( html );
	            },
	        });
		}
	}, // end - getLists

	save: function() {
		var div = $('#action');

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
			bootbox.confirm('Apakah anda yakin ingin menyimpan data ?', function(result) {
				if ( result ) {
					var detail = $.map( $(div).find('table tbody tr'), function(tr) {
						var _detail = {
							'kode_asal': $(tr).find('.asal').attr('data-val'),
							'kode_tujuan': $(tr).find('.tujuan').attr('data-val'),
							'lama_hari': numeral.unformat($(tr).find('.lama_hari').val())
						};

						return _detail;
					});

					var params = {
						'tgl_berlaku': dateSQL( $(div).find('#TglBerlaku').data('DateTimePicker').date() ),
						'detail': detail
					};

			        $.ajax({
			            url: 'parameter/JadwalSeminar/save',
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
};

js.start_up();