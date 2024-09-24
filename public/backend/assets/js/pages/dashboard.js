$(document).ready(function () {

    $('.select2').select2({
    });

    $('.accordion-collapse').on('shown.bs.collapse', function () {
        var id=$(this).attr('data-id');
        var status = $('#status').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var room_id = $('#room_no').val();
        var data = {
            'status': status,
            'start_date': start_date,
            'end_date': end_date,
            'room_id': room_id,
        };
        $.ajax({
            url: url_for_update_total + id,
            type: 'GET',
            success: function (response) {
                getCategoryWiseData(data);
            }
        });
    });

    $('.reset-filter').on('click', function (e) {
        e.preventDefault();
        $('#status').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $('#room_no').val('').trigger('change');
        getCategoryWiseData();
        getTherapist();
    });

    function truncateContent() {
        $('.content').each(function() {
            var showChar = 70; // How many characters to show before truncating
            var ellipsestext = "...";
            var content = $(this).find('.truncate-text').text();

            if (content.length > showChar) {
                var truncatedText = content.substr(0, showChar);
                var hiddenText = content.substr(showChar);

                $(this).find('.truncate-text').html(truncatedText + '<span class="more-content">' + ellipsestext + '</span>');
                $(this).find('.read-more').show();

                $(this).find('.read-more').click(function(e) {
                    e.preventDefault();
                    $(this).siblings('.truncate-text').html(truncatedText + hiddenText);
                    $(this).hide();
                });
            }
        });
    }
});
