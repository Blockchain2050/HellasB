<script>
$(document).ready(function() {
    $custom_fields = "<?php echo custom_fields_sort();?>";
    if ($custom_fields) {
        //remove custom fields non-custom fields created fields
        $i = 0;
        $('.customfield-item').each(function() {
            if ($(this).attr('data-guid') == '') {
                $(this).attr('data-guid', $i);
                $(this).attr('data-order', $i);
                $i--;
            }
        });
        $allfields_raw = $custom_fields.split(',');
        $.each($allfields_raw, function(key, val) {
            $order = key + 1;
            $field = $('div[data-guid="' + val.replace('customfield-item-', '') + '"]').attr('data-order', $order);
        });
        $list = $('.customfield-item').sort(function(a, b) {
            var contentA = parseInt($(a).attr('data-order'));
            var contentB = parseInt($(b).attr('data-order'));
            return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
        });
        $('.custom-field-items').html($list);
        $("input[name='birthdate']").removeClass('hasDatepicker');
        var cYear = (new Date).getFullYear();
        var alldays = Ossn.Print('datepicker:days');
        var shortdays = alldays.split(",");
        var allmonths = Ossn.Print('datepicker:months');
        var shortmonths = allmonths.split(",");

        var datepick_args = {
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            yearRange: '1900:' + cYear,
        };

        if (Ossn.isLangString('datepicker:days')) {
            datepick_args['dayNamesMin'] = shortdays;
        }
        if (Ossn.isLangString('datepicker:months')) {
            datepick_args['monthNamesShort'] = shortmonths;
        }
        $("input[name='birthdate']").datepicker(datepick_args);
    }
});
</script>