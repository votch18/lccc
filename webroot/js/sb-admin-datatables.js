// Call the dataTables jQuery plugin
$(document).ready(function() {
    $(document).ready(function(){
        var table = $('#dataTable').DataTable( {
            "lengthMenu": [ 10, 25, 50 ],
            "pageLength": 25
        });
    });
});
