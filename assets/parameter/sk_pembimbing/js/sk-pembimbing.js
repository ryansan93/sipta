var skp = {
	startUp: function () {
        var div = $('div.detailed');

        $(div).find('select.mahasiswa').select2();
        $(div).find('select.dosen').select2();
	}, // end - startUp

    changeFilter: function(elm) {
        var div_detailed = $(elm).closest('div.detailed');
        var val = $(elm).val();

        if ( val == 'mahasiswa' ) {
            $(div_detailed).find('div.mahasiswa').removeClass('hide');
            $(div_detailed).find('div.dosen').addClass('hide');
        } else {
            $(div_detailed).find('div.mahasiswa').addClass('hide');
            $(div_detailed).find('div.dosen').removeClass('hide');
        }
    }, // end - changeFilter

    getLists: function() {
        var div = $('div.detailed');

        var jenis_filter = $(div).find('.jenis_filter').val();

        var err = 0;
        $.map( $(div).find('[data-required=1]'), function(ipt) {
            var _div = $(ipt).closest('div.'+jenis_filter);

            if ( $(_div).length > 0 ) {
                if ( !$(_div).hasClass('hide') ) {
                    if ( empty($(ipt).val()) ) {
                        $(ipt).parent().addClass('has-error');
                        err++;
                    } else {
                        $(ipt).parent().removeClass('has-error');
                    }
                }
            }
        });

        if ( err > 0 ) {
            bootbox.alert('Harap lengkapi data terlebih dahulu.');
        } else {
            var data = {
                'jenis_filter': jenis_filter,
                'value_filter': $(div).find('select.'+jenis_filter).select2().val()
            };

            $.ajax({
                url: 'parameter/SkPembimbing/getLists',
                data: {
                    'params': data
                },
                type: 'GET',
                dataType: 'HTML',
                beforeSend: function() { showLoading(); },
                success: function(html) {
                    hideLoading();

                    $(div).find('table.tbl_riwayat tbody').html( html );
                }
            });
        }
    }, // end - getLists

    addRow: function(elm) {
        var tr = $(elm).closest('tr');
        var tbody = $(tr).closest('tbody');

        $(tbody).find('select').select2('destroy');
        $(tbody).find('select').removeAttr('data-select2-id');
        $(tbody).find('select').removeAttr('tabindex');
        $(tbody).find('select').removeAttr('aria-hidden');
        $(tbody).find('select option').removeAttr('data-select2-id');

        var tr_clone = $(tr).clone();
        $(tr_clone).find('input, select').val('');

        $(tbody).append( $(tr_clone) );

        $(tbody).find('select').select2();
    }, // end - addRow

    removeRow: function(elm) {
        var tr = $(elm).closest('tr');
        var tbody = $(tr).closest('tbody');

        if ( $(tbody).find('tr').length > 1 ) {
            $(tr).remove();
        }
    }, // end - removeRow

	modalAddForm: function () {
		$('.modal').modal('hide');

        $.get('parameter/SkPembimbing/modalAddForm',{
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

                $(this).removeAttr('tabindex');

                $(this).find('select').select2();
            });
        },'html');
	}, // end - modalAddForm

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
            bootbox.confirm('Apakah anda yakin ingin menyimpan data ?', function(result) {
                if ( result ) {
                    var list_pembimbing = $.map( $(div).find('table.tbl_pembimbing tbody tr'), function(tr) {
                        var _list_pembimbing = {
                            'no': $(tr).find('.no').val(),
                            'nip': $(tr).find('.dosen').select2().val()
                        };

                        return _list_pembimbing;
                    });

                    var data = {
                        'mahasiswa': $(div).find('.mahasiswa').select2().val(),
                        'list_pembimbing': list_pembimbing
                    };

                    $.ajax({
                        url: 'parameter/SkPembimbing/save',
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

    modalEditForm: function (elm) {
        $('.modal').modal('hide');

        $.get('parameter/SkPembimbing/modalEditForm',{
            'id': $(elm).data('id')
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

                $(this).removeAttr('tabindex');

                $(this).find('select').select2();
            });
        },'html');
    }, // end - modalEditForm

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
            bootbox.confirm('Apakah anda yakin ingin meng-ubah data ?', function(result) {
                if ( result ) {
                    var list_pembimbing = $.map( $(div).find('table.tbl_pembimbing tbody tr'), function(tr) {
                        var _list_pembimbing = {
                            'no': $(tr).find('.no').val(),
                            'nip': $(tr).find('.dosen').select2().val()
                        };

                        return _list_pembimbing;
                    });

                    var data = {
                        'id': $(elm).data('id'),
                        'mahasiswa': $(div).find('.mahasiswa').select2().val(),
                        'list_pembimbing': list_pembimbing
                    };

                    $.ajax({
                        url: 'parameter/SkPembimbing/edit',
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
                                    skp.getLists();
                                    $(div).modal('hide');
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
        bootbox.confirm('Apakah anda yakin ingin meng-hapus data ?', function(result) {
            if ( result ) {
                $.ajax({
                    url: 'parameter/SkPembimbing/delete',
                    data: {
                        'params': $(elm).data('id')
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function() { showLoading(); },
                    success: function(data) {
                        hideLoading();
                        if ( data.status == 1 ) {
                            bootbox.alert(data.message, function() {
                                skp.getLists();
                                $('.modal').modal('hide');
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

skp.startUp();