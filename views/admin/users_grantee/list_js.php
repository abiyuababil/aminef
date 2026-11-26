<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function () {
        $( ".dateWithRange" ).daterangepicker({
            autoUpdateInput: false,
            locale: {
                // format: 'DD-MMM-YYYY',
                cancelLabel: 'Clear'
            }
        });

        $('.dateWithRange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            document.forms.frm_manage.submit()
        });

        $('.dateWithRange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            document.forms.frm_manage.submit()
        });

        // AJAX cascade for Country -> Home State -> Home City in Export Modal
        $('#modal_country').on('change', function() {
            var countryId = $(this).val();
            var $homeState = $('#modal_home_state');
            var $homeCity = $('#modal_home_city');

            $homeState.empty().append('<option value="">Nothing Selected</option>');
            $homeCity.empty().append('<option value="">Nothing Selected</option>');
            $homeState.selectpicker('refresh');
            $homeCity.selectpicker('refresh');

            if (countryId) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo site_url("world/state"); ?>/' + countryId,
                    dataType: 'JSON',
                    success: function(r) {
                        if (r && r.length > 0) {
                            $.each(r, function(idx, item) {
                                $homeState.append('<option value="' + item.id + '">' + item.name + '</option>');
                            });
                        }
                        $homeState.selectpicker('refresh');
                    }
                });
            }
        });

        // AJAX cascade for Home State -> Home City
        $('#modal_home_state').on('change', function() {
            var stateId = $(this).val();
            var $homeCity = $('#modal_home_city');

            $homeCity.empty().append('<option value="">Nothing Selected</option>');
            $homeCity.selectpicker('refresh');

            if (stateId) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo site_url("world/city"); ?>/' + stateId,
                    dataType: 'JSON',
                    success: function(r) {
                        if (r && r.length > 0) {
                            $.each(r, function(idx, item) {
                                $homeCity.append('<option value="' + item.id + '">' + item.name + '</option>');
                            });
                        }
                        $homeCity.selectpicker('refresh');
                    }
                });
            }
        });

        // AJAX cascade for Grant State -> Grant City
        $('#modal_grant_state').on('change', function() {
            var stateId = $(this).val();
            var $grantCity = $('#modal_grant_city');

            $grantCity.empty().append('<option value="">Nothing Selected</option>');
            $grantCity.selectpicker('refresh');

            if (stateId) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo site_url("world/city"); ?>/' + stateId,
                    dataType: 'JSON',
                    success: function(r) {
                        if (r && r.length > 0) {
                            $.each(r, function(idx, item) {
                                $grantCity.append('<option value="' + item.id + '">' + item.name + '</option>');
                            });
                        }
                        $grantCity.selectpicker('refresh');
                    }
                });
            }
        });

        $('#modalDownloadV2').on('shown.bs.modal', function() {
            $('#modalDownloadV2 .selectpicker').selectpicker('refresh');
        });
    })
	
	function submitFilter(e) {
		if (e.keyCode == 13) {
			$('#frm_manage').submit();
			return false;
		}
	}
    
    function show_download_modal(params) {
        var url = "<?php echo site_url('admin/users_grantee/download_excel_v2?') ?>" + params;
        $('#form-download-excel-v2').attr('action', url);

        // Clear any previous selected row IDs
        $('#form-download-excel-v2 input[name="ids[]"]').remove();

        // Check if rows are selected in the table
        var checkedRows = $('.chk-row:checked');
        if (checkedRows.length > 0) {
            checkedRows.each(function() {
                $('#form-download-excel-v2').append('<input type="hidden" name="ids[]" value="' + $(this).val() + '">');
            });
        }

        goToStep(1);
        $('#modalDownloadV2').modal('show');
    }

    function goToStep(step) {
        if (step === 1) {
            document.getElementById('bodyStep1').style.display = 'block';
            document.getElementById('bodyStep2').style.display = 'none';
            document.getElementById('tabStep1').classList.add('active');
            document.getElementById('tabStep2').classList.remove('active');
            document.getElementById('btnBack').style.visibility = 'hidden';
            document.getElementById('btnNext').style.display = 'inline-block';
            document.getElementById('btnDownload').style.display = 'none';
        } else {
            document.getElementById('bodyStep1').style.display = 'none';
            document.getElementById('bodyStep2').style.display = 'block';
            document.getElementById('tabStep1').classList.remove('active');
            document.getElementById('tabStep2').classList.add('active');
            document.getElementById('btnBack').style.visibility = 'visible';
            document.getElementById('btnNext').style.display = 'none';
            document.getElementById('btnDownload').style.display = 'inline-block';
        }
    }

    function setAllCheckboxes(status) {
        document.querySelectorAll('#orderedCheckboxList input[type="checkbox"]').forEach(cb => cb.checked = status);
    }

    function triggerDownload() {
        var checkedCols = $('#orderedCheckboxList input[type="checkbox"]:checked');
        if (checkedCols.length === 0) {
            alert('Please select at least one column to download.');
            return false;
        }

        $('#form-download-excel-v2').submit();
        setTimeout(function() {
            $('#modalDownloadV2').modal('hide');
        }, 1000);
    }
</script>