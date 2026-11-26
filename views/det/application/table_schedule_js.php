<script>
    const isAdmin = <?= isset($is_admin) && $is_admin ? 1 : 0 ?>;
    let editIndex = null;

    function save_record_table_schedule(id) {
        let group = 'element_group_' + id;
        let data = {};

        $('[data-group="'+group+'"][data-type-group="table_schedule"]').each(function() {

            // 🚫 SKIP hidden "have other"
            if ($(this).is(':hidden')) return;

            let index = $(this).data('index');
            let type = $(this).attr('type');
            let tag  = this.tagName.toLowerCase();

            // ✅ CHECKBOX
            if (type === 'checkbox') {
                if (!data[index]) data[index] = [];

                if ($(this).is(':checked')) {
                    data[index].push($(this).val());
                }
            }

            // ✅ SELECT (hindari ketimpa input hidden)
            if (tag === 'select') {
                data[index] = $(this).val();
            }

            // ✅ INPUT TEXT / NORMAL
            else {
                // jangan overwrite checkbox array
                if (!Array.isArray(data[index])) {
                    data[index] = $(this).val();
                }
            }

        });


        window.tableScheduleData = window.tableScheduleData || {};
        window.tableScheduleData[id] = window.tableScheduleData[id] || [];

        let arr = window.tableScheduleData[id];

        // 🔥 EDIT MODE
        if (editIndex !== null) {
            arr[editIndex] = data;
            editIndex = null;
        } else {
            arr.push(data);
        }



        var grantee_grant_id = $("#grantee_grant_id").val();
        var dataPost = {
            custom_field_id: id,
            row: JSON.stringify(window.tableScheduleData[id])
        }
        var urlAjax = '<?= base_url(); ?>grantee/submission/update_table_schedule';
        if(isAdmin) {
            dataPost.grantee_grant_id = grantee_grant_id;
            urlAjax = '<?= base_url(); ?>admin/grantee/update_table_schedule';
        }


        $.ajax({
            url: urlAjax,
            type: 'POST',
            dataType: "JSON",
            data: dataPost,
            success: function(res) {
                if(res.success) {
                    console.log('saved');
                    renderTable(id);
                    resetForm(group);
                } else {
                    alert('Failed to save data. Please try again.');
                }
            }
        });
    }

    function appendRow(id, data, index) {
        let html = '<tr>';

        html += `
            <button class="btn-edit btn btn-primary btn-xs" data-id="${id}" data-index="${index}">Edit</button>
            <button class="btn-delete btn btn-danger btn-xs" data-id="${id}" data-index="${index}">X</button>`;

        Object.keys(data).forEach(key => {
            let val = data[key];

            if (Array.isArray(val)) {
                val = val.join(', ');
            }

            html += `<td>${val}</td>`;
        });

        html += '</tr>';

        $('#table-schedule'+id+' tbody tr:last').before(html);
    }

    function resetForm(group) {

        $('[data-group="'+group+'"][type="text"]:not(:hidden)').val('');
        $('[data-group="'+group+'"]select:not(:hidden)').val('--Select Answer--').trigger('change');

        $('[data-group="'+group+'"][type="checkbox"]').prop('checked', false);
        }

        function getFirstNumber(val) {
        if (!val) return 0;

        let match = val.toString().match(/\d+(\.\d+)?/);

        return match ? parseFloat(match[0]) : 0;
    }



    function calculateTotal(id) {

        let data = window.tableScheduleData[id] || [];

        let lengthKey = getFieldKey(id, 'length');
        let daysKey   = getFieldKey(id, 'day(s)');

        let totalMinutes = 0;

        data.forEach(row => {

            let length = getFirstNumber(row[lengthKey]); // length
            let days   = row[daysKey] || [];           // checkbox

            let countDays = Array.isArray(days) ? days.length : 0;

            totalMinutes += (length * countDays);
        });

        let hours = Math.floor(totalMinutes / 60);
        let minutes = totalMinutes % 60;

        $('#total-table-schedule'+id).text(
            hours + ' hours, ' + minutes + ' minutes'
        );
    }

    function renderTable(id) {

        let data = window.tableScheduleData[id] || [];

        let tbody = $('#table-schedule' + id + ' tbody');
        var display = '<?= $display ?? "" ?>';

        // hapus semua row kecuali row terakhir (total)
        tbody.find('tr:not(:last)').remove();

        data.forEach((row, index) => {

            let html = '<tr>';

            // tombol action
            html += `
                <td>
                    <button type="button" class="btn-edit ${display} btn btn-primary btn-xs" data-id="${id}" data-index="${index}"><i class='fa fa-edit'></i></button>
                    <button type="button" class="btn-delete ${display} btn btn-danger btn-xs" data-id="${id}" data-index="${index}"><i class='fa fa-trash'></i></button>
                </td>
            `;

            // isi kolom
            Object.keys(row).forEach(key => {

                let val = row[key];

                if (Array.isArray(val)) {
                    val = val.join(', ');
                }

                html += `<td>${val}</td>`;
            });

            html += '</tr>';

            // insert sebelum row total
            tbody.find('tr:last').before(html);
        });

        // hitung total
        calculateTotal(id);
    }

    $(document).on('click', '.btn-delete', function() {

        if (!confirm('Are you sure you want to delete this?')) return;

        let id    = $(this).data('id');
        let index = $(this).data('index');

        let data = window.tableScheduleData[id] || [];

        // 🔥 hapus data berdasarkan index
        data.splice(index, 1);

        // update global
        window.tableScheduleData[id] = data;

        // 🔥 render ulang table
        renderTable(id);

        // 🔥 sync ke DB
        syncTableToDB(id);
    });

    $(document).on('click', '.btn-edit', function() {

        let id    = $(this).data('id');
        let index = $(this).data('index');

        editIndex = index;
        editId    = id;

        let row   = window.tableScheduleData[id][index];
        let group = 'element_group_' + id;

        // reset dulu biar bersih
        resetForm(group);

        $('[data-group="'+group+'"]').each(function() {

            if ($(this).is(':hidden')) return;

            let fieldIndex = $(this).data('index');
            let type       = $(this).attr('type');
            let tag        = this.tagName.toLowerCase();

            let value = row[fieldIndex];

            // ✅ CHECKBOX
            if (type === 'checkbox') {

                if (Array.isArray(value)) {
                    if (value.includes($(this).val())) {
                        $(this).prop('checked', true);
                    }
                }

            }
            // ✅ SELECT
            else if (tag === 'select') {
                $(this).val(value).trigger('change');
            }
            // ✅ INPUT
            else {
                $(this).val(value);
            }

        });

        // 🔥 UX (optional)
        $('.btn-save-record').text('Update Record');
    });

    function syncTableToDB(id) {

        var grantee_grant_id = $("#grantee_grant_id").val();
        var dataPost = {
            custom_field_id: id,
            row: JSON.stringify(window.tableScheduleData[id])
        }
        
        var urlAjax = '<?= base_url(); ?>grantee/submission/update_table_schedule';
        
        if(isAdmin) {
            dataPost.grantee_grant_id = grantee_grant_id;
            urlAjax = '<?= base_url(); ?>admin/grantee/update_table_schedule';
        }

        $.ajax({
            url: urlAjax,
            type: 'POST',
            dataType: 'JSON',
            data: dataPost,
            success: function(res) {
                console.log('sync success');
            }
        });
    }

    $(document).ready(function() {
        if(window.tableScheduleData){
            Object.keys(window.tableScheduleData).forEach(id => {
                renderTable(id);
            });
        }
    });

    function getFieldKey(id, keyword) {

        let config = window.tableScheduleConfig[id] || [];

        let found = config.find(col =>
            col.property_name.toLowerCase().includes(keyword.toLowerCase())
        );

        return found ? found.id : null;
    }    
</script>