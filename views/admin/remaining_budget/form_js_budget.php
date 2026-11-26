<script>
    $(document).ready(function() {
        do_format_input_currency();
        
        calculateRemaining();

        $('.currency-usd').on('input', function() {
            calculateRemaining();
        });

        $('.currency-usd').on('blur', function() {
            $(this).val(Accounting.format_money($(this).val(), 'USD'));
            calculateRemaining();
        });

        function calculateRemaining() {
            let grantCostVal = $('#grant_cost').val() || '';
            let grantCostText = String(grantCostVal).replace(/[^0-9.,]/g, '');
            let grantCost = parseFloat(grantCostText.replace(/,/g, '')) || 0;
            let grantCostPaymentVal = $('#grant_cost_payment').val() || '';
            let grantCostPaymentText = String(grantCostPaymentVal).replace(/[^0-9.,]/g, '');
            let grantCostPayment = parseFloat(grantCostPaymentText.replace(/,/g, '')) || 0;
            let grantCostRemaining = grantCost - grantCostPayment;
            $('#grant_cost_remaining').val(Accounting.format_money(String(grantCostRemaining), 'USD'));

            let grantSupportingVal = $('#grant_supporting').val() || '';
            let grantSupportingText = String(grantSupportingVal).replace(/[^0-9.,]/g, '');
            let grantSupporting = parseFloat(grantSupportingText.replace(/,/g, '')) || 0;
            let grantSupportingPaymentVal = $('#grant_supporting_payment').val() || '';
            let grantSupportingPaymentText = String(grantSupportingPaymentVal).replace(/[^0-9.,]/g, '');
            let grantSupportingPayment = parseFloat(grantSupportingPaymentText.replace(/,/g, '')) || 0;
            let grantSupportingRemaining = grantSupporting - grantSupportingPayment;
            $('#grant_supporting_remaining').val(Accounting.format_money(String(grantSupportingRemaining), 'USD'));

            let internationalTravelVal = $('#international_travel').val() || '';
            let internationalTravelText = String(internationalTravelVal).replace(/[^0-9.,]/g, '');
            let internationalTravel = parseFloat(internationalTravelText.replace(/,/g, '')) || 0;
            let internationalTravelPaymentVal = $('#international_travel_payment').val() || '';
            let internationalTravelPaymentText = String(internationalTravelPaymentVal).replace(/[^0-9.,]/g, '');
            let internationalTravelPayment = parseFloat(internationalTravelPaymentText.replace(/,/g, '')) || 0;
            let internationalTravelRemaining = internationalTravel - internationalTravelPayment;
            $('#international_travel_remaining').val(Accounting.format_money(String(internationalTravelRemaining), 'USD'));
        }
    });

    function confirmDelete(id) {
        $('#confirm-delete-btn').attr('href', '<?php echo site_url("admin/remaining_budget/delete/") ?>' + id);
        $('#confirm-delete-modal').modal('show');
    }
</script>

