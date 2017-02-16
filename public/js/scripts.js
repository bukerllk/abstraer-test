function ajaxList() {
    $.get('getAjax', function (data) {
        $.each(data, function() {
            $('#resultAjax > tbody').append(
                '<tr><td>'
                + this.coordinates
                + '</td><td>'
                + this.name +
                + '</td><td>'
                + this.created_at +
                '</td></tr>'
            );
        });
    });
};
function validateForm() {
    var zipone=$('#agent1').val();
    var zipotwo=$('#agent2').val();
    if (!zipone){
        alert('Ingrese el Zip Code para Agent 1');
        return false;
    }
    if (!zipotwo){
        alert('Ingrese el Zip Code para Agent 2');
        return false;
    }
    $('#formGo').submit();
}